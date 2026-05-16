<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        EmailTemplate::firstOrCreate(['slug' => 'order_confirmation'], [
            'name' => 'Order Confirmation',
            'subject' => 'Order Confirmation - {{order_number}}',
            'body' => '<h1 style="color: #1d4ed8; margin-bottom: 10px;">Thank you for your order!</h1>
<p>Hi <strong>{{customer_name}}</strong>,</p>
<p>Your order <strong>#{{order_number}}</strong> has been placed successfully on {{order_date}}.</p>
<p><strong>Order Total:</strong> {{order_total}}</p>
{{order_items}}
<p>We will notify you once your order ships.</p>
<p>If you have any questions, reply to this email or contact us at {{company_email}}.</p>',
            'send_to_customer' => true,
            'send_to_admin' => false,
            'is_active' => true,
        ]);

        EmailTemplate::firstOrCreate(['slug' => 'order_admin_notification'], [
            'name' => 'Admin Order Notification',
            'subject' => 'New Order Received',
            'body' => '<h1 style="color: #1d4ed8;">New Order Received</h1>
<p>A new order has been placed.</p>
<p><strong>Customer:</strong> {{customer_name}}</p>
<p><strong>Order:</strong> #{{order_number}}</p>
<p><strong>Date:</strong> {{order_date}}</p>
<p><strong>Total:</strong> {{order_total}}</p>
{{order_items}}',
            'send_to_customer' => false,
            'send_to_admin' => true,
            'is_active' => true,
        ]);

        EmailTemplate::firstOrCreate(['slug' => 'order_status_update'], [
            'name' => 'Order Status Update',
            'subject' => 'Order #{{order_number}} - {{order_status}}',
            'body' => '<h1 style="color: #1d4ed8;">Order Status Updated</h1>
<p>Hi <strong>{{customer_name}}</strong>,</p>
<p>Your order <strong>#{{order_number}}</strong> status has been updated.</p>
<p><strong>New Status:</strong> <span style="color: #1d4ed8; font-weight: bold;">{{order_status}}</span></p>
<p><strong>Order Date:</strong> {{order_date}}</p>
<p><strong>Order Total:</strong> {{order_total}}</p>
{{order_items}}
<p>If you have any questions, reply to this email or contact us at {{company_email}}.</p>',
            'send_to_customer' => true,
            'send_to_admin' => false,
            'is_active' => true,
        ]);

        EmailTemplate::firstOrCreate(['slug' => 'contact_inquiry_confirmation'], [
            'name' => 'Contact Inquiry Confirmation',
            'subject' => 'Thank you for contacting us',
            'body' => '<h1 style="color: #1d4ed8;">Thank you for reaching out!</h1>
<p>Hi <strong>{{customer_name}}</strong>,</p>
<p>We have received your inquiry and will get back to you within 1-2 business days.</p>
<p><strong>Your Message:</strong></p>
<blockquote style="padding: 12px; background: #f8f9fa; border-left: 4px solid #1d4ed8; margin: 12px 0;">
{{inquiry_message}}
</blockquote>
<p>If you have any urgent questions, please call us directly.</p>',
            'send_to_customer' => true,
            'send_to_admin' => false,
            'is_active' => true,
        ]);

        EmailTemplate::firstOrCreate(['slug' => 'contact_inquiry_admin_notification'], [
            'name' => 'Admin Contact Inquiry Notification',
            'subject' => 'New Contact Inquiry - {{customer_name}}',
            'body' => '<h1 style="color: #1d4ed8;">New Contact Inquiry</h1>
<p>A new inquiry has been received.</p>
<p><strong>Name:</strong> {{customer_name}}</p>
<p><strong>Email:</strong> {{customer_email}}</p>
<p><strong>Phone:</strong> {{customer_phone}}</p>
<p><strong>Message:</strong></p>
<blockquote style="padding: 12px; background: #f8f9fa; border-left: 4px solid #1d4ed8; margin: 12px 0;">
{{inquiry_message}}
</blockquote>',
            'send_to_customer' => false,
            'send_to_admin' => true,
            'is_active' => true,
        ]);

        EmailTemplate::firstOrCreate(['slug' => 'welcome_email'], [
            'name' => 'Welcome Email',
            'subject' => 'Welcome to {{company_name}}!',
            'body' => '<h1 style="color: #1d4ed8;">Welcome to {{company_name}}!</h1>
<p>Hi <strong>{{customer_name}}</strong>,</p>
<p>Thank you for creating an account with us.</p>
<p>You can now track your orders, save your addresses, and enjoy a faster checkout experience.</p>
<p><strong>Your Account Details:</strong></p>
<ul>
<li><strong>Email:</strong> {{customer_email}}</li>
<li><strong>Registered:</strong> {{registered_date}}</li>
</ul>
<p>If you have any questions, feel free to contact us at {{company_email}}.</p>',
            'send_to_customer' => true,
            'send_to_admin' => false,
            'is_active' => true,
        ]);
    }
}
