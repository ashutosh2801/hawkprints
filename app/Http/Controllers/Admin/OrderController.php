<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\EmailService;
use App\Services\InvoiceService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('order_number', 'like', "%{$request->search}%")
                  ->orWhere('customer_name', 'like', "%{$request->search}%")
                  ->orWhere('customer_email', 'like', "%{$request->search}%");
            });
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        
        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update($validated);

        if ($oldStatus !== $order->status && $order->customer_email) {
            try {
                $itemsHtml = '';
                foreach ($order->items as $item) {
                    $itemsHtml .= '<tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;">' . e($item->product_name) . '</td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee; text-align: center;">' . $item->quantity . '</td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee; text-align: right;">$' . number_format($item->price, 2) . '</td>
                        <td style="padding: 8px; border-bottom: 1px solid #eee; text-align: right; font-weight: bold;">$' . number_format($item->quantity * $item->price, 2) . '</td>
                    </tr>';
                }
                $orderItems = '<table style="width: 100%; border-collapse: collapse;">
                    <thead><tr style="background: #f8f9fa;">
                        <th style="padding: 8px; text-align: left; border-bottom: 2px solid #dee2e6;">Product</th>
                        <th style="padding: 8px; border-bottom: 2px solid #dee2e6;">Qty</th>
                        <th style="padding: 8px; border-bottom: 2px solid #dee2e6; text-align: right;">Price</th>
                        <th style="padding: 8px; border-bottom: 2px solid #dee2e6; text-align: right;">Total</th>
                    </tr></thead>
                    <tbody>' . $itemsHtml . '</tbody>
                </table>';

                $emailService = new EmailService();
                $emailService->sendTemplateEmail('order_status_update', $order->customer_email, [
                    'customer_name' => $order->customer_name,
                    'order_number' => $order->order_number,
                    'order_status' => ucfirst($order->status),
                    'order_date' => $order->created_at->format('M j, Y'),
                    'order_total' => '$' . number_format($order->total, 2),
                    'order_items' => $orderItems,
                ]);
            } catch (\Exception $e) {
                \Log::error('Order status email failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Order status updated.');
    }

    public function downloadInvoice(Order $order)
    {
        $invoiceService = new InvoiceService();
        $pdf = $invoiceService->generate($order);
        return $pdf->download('invoice-' . $order->order_number . '.pdf');
    }

    public function sendInvoice(Request $request, Order $order)
    {
        if (!$order->customer_email) {
            return back()->with('error', 'Customer has no email address.');
        }

        try {
            $emailService = new EmailService();
            $sent = $emailService->sendTemplateEmail(
                'order_confirmation',
                $order->customer_email,
                [
                    'customer_name' => $order->customer_name,
                    'order_number' => $order->order_number,
                    'order_date' => $order->created_at->format('M j, Y'),
                    'order_total' => '$' . number_format($order->total, 2),
                    'order_items' => '',
                ],
                false,
                $order
            );

            if ($sent) {
                return back()->with('success', 'Invoice sent to ' . $order->customer_email);
            }
            return back()->with('error', 'Invoice template is inactive or not configured.');
        } catch (\Exception $e) {
            \Log::error('Send invoice failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to send invoice. Please try again.');
        }
    }
}