<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\ContactInquiry;
use App\Models\Setting;
use App\Services\EmailService;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|max:5000',
        ]);

        $inquiry = ContactInquiry::create($validated);

        AdminNotification::createNotification('contact', [
            'name' => $inquiry->name,
            'email' => $inquiry->email,
            'phone' => $inquiry->phone,
            'message' => $inquiry->message,
            'contact_inquiry_id' => $inquiry->id,
        ]);

        $emailService = new EmailService();

        $inquiryData = [
            'customer_name' => $inquiry->name,
            'customer_email' => $inquiry->email,
            'customer_phone' => $inquiry->phone ?? 'N/A',
            'inquiry_message' => nl2br(e($inquiry->message)),
        ];

        try {
            $emailService->sendTemplateEmail('contact_inquiry_confirmation', $inquiry->email, $inquiryData);
        } catch (\Exception $e) {
            \Log::error('Contact confirmation email failed: ' . $e->getMessage());
        }

        try {
            $companyEmail = Setting::get('company_email', 'info@fiveriversprint.ca');
            $emailService->sendTemplateEmail('contact_inquiry_admin_notification', $companyEmail, $inquiryData);
        } catch (\Exception $e) {
            \Log::error('Contact admin email failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you! Your message has been received. We will get back to you shortly.');
    }
}
