<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class EmailService
{
    public function sendOrderEmails(Order $order)
    {
        $customer = $order->customer_name;
        $orderNumber = $order->order_number;
        $orderTotal = '$' . number_format($order->total, 2);
        $orderDate = $order->created_at->format('M j, Y');
        
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
            <thead>
                <tr style="background: #f8f9fa;">
                    <th style="padding: 8px; text-align: left; border-bottom: 2px solid #dee2e6;">Product</th>
                    <th style="padding: 8px; border-bottom: 2px solid #dee2e6;">Qty</th>
                    <th style="padding: 8px; border-bottom: 2px solid #dee2e6; text-align: right;">Price</th>
                    <th style="padding: 8px; border-bottom: 2px solid #dee2e6; text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>' . $itemsHtml . '</tbody>
            <tfoot>
                <tr><td colspan="3" style="padding: 8px; text-align: right; font-weight: bold;">Subtotal:</td><td style="padding: 8px; text-align: right;">$' . number_format($order->subtotal, 2) . '</td></tr>
                <tr><td colspan="3" style="padding: 8px; text-align: right; font-weight: bold;">Tax:</td><td style="padding: 8px; text-align: right;">$' . number_format($order->tax, 2) . '</td></tr>
                <tr><td colspan="3" style="padding: 8px; text-align: right; font-weight: bold;">Shipping:</td><td style="padding: 8px; text-align: right;">$' . number_format($order->shipping, 2) . '</td></tr>
                <tr><td colspan="3" style="padding: 8px; text-align: right; font-weight: bold; font-size: 1.1em;">Total:</td><td style="padding: 8px; text-align: right; font-weight: bold; font-size: 1.1em;">$' . number_format($order->total, 2) . '</td></tr>
            </tfoot>
        </table>';

        $data = [
            'customer_name' => $customer,
            'order_number' => $orderNumber,
            'order_total' => $orderTotal,
            'order_items' => $orderItems,
            'order_date' => $orderDate,
        ];

        $companyName = Setting::get('company_name', 'Hawk Prints');
        $companyEmail = Setting::get('company_email', 'info@hawkprints.ca');

        $customerTemplate = EmailTemplate::where('slug', 'order_confirmation')->where('is_active', true)->first();
        if ($customerTemplate && $customerTemplate->send_to_customer) {
            $this->sendEmail(
                $order->customer_email,
                $customerTemplate->subject,
                $this->parseTemplate($customerTemplate->body, $data),
                $companyName,
                $companyEmail
            );
        }

        $adminTemplate = EmailTemplate::where('slug', 'order_admin_notification')->where('is_active', true)->first();
        if ($adminTemplate && $adminTemplate->send_to_admin) {
            $this->sendEmail(
                $companyEmail,
                $adminTemplate->subject . ' - ' . $orderNumber,
                $this->parseTemplate($adminTemplate->body, $data),
                $companyName,
                $companyEmail
            );
        }
    }

    protected function parseTemplate(string $body, array $data): string
    {
        foreach ($data as $key => $value) {
            $body = str_replace('{{ ' . $key . ' }}', $value, $body);
            $body = str_replace('{{' . $key . '}}', $value, $body);
        }
        return $body;
    }

    protected function sendEmail(string $to, string $subject, string $body, string $fromName, string $fromEmail)
    {
        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, sans-serif; background: #f8f9fa;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="https://placehold.co/150x50?text=' . urlencode($fromName) . '" alt="' . e($fromName) . '" style="height: 40px;">
            </div>
            ' . $body . '
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; text-align: center; font-size: 12px; color: #999;">
                <p>&copy; ' . date('Y') . ' ' . e($fromName) . '. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>';

        try {
            Mail::html($html, function ($message) use ($to, $subject, $fromName, $fromEmail) {
                $message->to($to)
                    ->subject($subject)
                    ->from($fromEmail, $fromName)
                    ->replyTo($fromEmail);
            });
        } catch (\Exception $e) {
            \Log::error('Email send failed: ' . $e->getMessage());
        }
    }
}