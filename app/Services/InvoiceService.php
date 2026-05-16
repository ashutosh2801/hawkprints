<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceService
{
    public function generate(Order $order): \Barryvdh\DomPDF\PDF
    {
        $order->load('items');

        $companyName = Setting::get('company_name', 'Five Rivers Print');
        $companyEmail = Setting::get('company_email', 'info@fiveriversprint.ca');
        $companyPhone = Setting::get('company_phone', '');
        $companyAddress = Setting::get('company_address', '');

        $itemsHtml = '';
        foreach ($order->items as $item) {
            $itemsHtml .= '<tr>
                <td style="padding: 8px; border-bottom: 1px solid #ddd;">' . e($item->product_name) . ($item->variant_name ? ' (' . e($item->variant_name) . ')' : '') . '</td>
                <td style="padding: 8px; border-bottom: 1px solid #ddd; text-align: center;">' . $item->quantity . '</td>
                <td style="padding: 8px; border-bottom: 1px solid #ddd; text-align: right;">$' . number_format($item->price, 2) . '</td>
                <td style="padding: 8px; border-bottom: 1px solid #ddd; text-align: right;">$' . number_format($item->quantity * $item->price, 2) . '</td>
            </tr>';
        }

        $html = '<html><head>
        <meta charset="utf-8">
        <style>
            body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; }
            .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1d4ed8; padding-bottom: 15px; }
            .header h1 { color: #1d4ed8; margin: 0 0 5px; font-size: 22px; }
            .header p { margin: 2px 0; color: #666; font-size: 11px; }
            .invoice-info { margin-bottom: 20px; }
            .invoice-info table { width: 100%; }
            .invoice-info td { vertical-align: top; padding: 4px 0; }
            .invoice-info .label { color: #666; font-size: 10px; text-transform: uppercase; }
            .invoice-info .value { font-weight: bold; }
            table.items { width: 100%; border-collapse: collapse; margin: 20px 0; }
            table.items th { background: #f8f9fa; padding: 10px 8px; text-align: left; border-bottom: 2px solid #dee2e6; font-size: 11px; text-transform: uppercase; color: #666; }
            table.items td { padding: 8px; border-bottom: 1px solid #eee; }
            table.items tfoot td { padding: 6px 8px; }
            .total-row td { font-weight: bold; font-size: 14px; border-top: 2px solid #333; padding-top: 8px; }
            .footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; text-align: center; font-size: 10px; color: #999; }
        </style>
        </head><body>
            <div class="header">
                <h1>' . e($companyName) . '</h1>
                <p>' . e($companyAddress) . '</p>
                <p>' . e($companyEmail) . ' | ' . e($companyPhone) . '</p>
            </div>
            <div class="invoice-info">
                <table>
                    <tr>
                        <td style="width: 50%;">
                            <div class="label">Invoice To</div>
                            <div class="value">' . e($order->customer_name) . '</div>
                            <div>' . e($order->customer_email) . '</div>
                            <div>' . nl2br(e($order->shipping_address ?? '')) . '</div>
                        </td>
                        <td style="width: 50%; text-align: right;">
                            <div class="label">Invoice #</div>
                            <div class="value">' . e($order->order_number) . '</div>
                            <div class="label" style="margin-top: 8px;">Order Date</div>
                            <div>' . $order->created_at->format('M j, Y') . '</div>
                            <div class="label" style="margin-top: 8px;">Payment Method</div>
                            <div>' . ($order->payment_method === 'stripe' ? 'Credit Card' : 'Cash on Delivery') . '</div>
                        </td>
                    </tr>
                </table>
            </div>
            <table class="items">
                <thead><tr>
                    <th>Product</th><th>Qty</th><th>Price</th><th>Total</th>
                </tr></thead>
                <tbody>' . $itemsHtml . '</tbody>
                <tfoot>
                    <tr><td colspan="3" style="text-align: right;">Subtotal:</td><td>$' . number_format($order->subtotal, 2) . '</td></tr>
                    <tr><td colspan="3" style="text-align: right;">Tax:</td><td>$' . number_format($order->tax, 2) . '</td></tr>
                    <tr><td colspan="3" style="text-align: right;">Shipping:</td><td>$' . number_format($order->shipping, 2) . '</td></tr>
                    <tr class="total-row"><td colspan="3" style="text-align: right;">Total:</td><td>$' . number_format($order->total, 2) . '</td></tr>
                </tfoot>
            </table>
            <div class="footer">
                <p>Thank you for your business!</p>
                <p>&copy; ' . date('Y') . ' ' . e($companyName) . '. All rights reserved.</p>
            </div>
        </body></html>';

        return Pdf::loadHTML($html);
    }
}
