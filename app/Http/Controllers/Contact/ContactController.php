<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\ContactInquiry;
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

        return back()->with('success', 'Thank you! Your message has been received. We will get back to you shortly.');
    }
}
