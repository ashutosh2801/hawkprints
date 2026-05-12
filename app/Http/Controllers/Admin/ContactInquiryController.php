<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class ContactInquiryController extends Controller
{
    public function index()
    {
        $inquiries = ContactInquiry::orderBy('created_at', 'desc')->get();
        $unreadCount = ContactInquiry::where('is_read', false)->count();
        return view('admin.contact-inquiries.index', compact('inquiries', 'unreadCount'));
    }

    public function show(ContactInquiry $contactInquiry)
    {
        if (!$contactInquiry->is_read) {
            $contactInquiry->update(['is_read' => true]);
        }
        return view('admin.contact-inquiries.show', compact('contactInquiry'));
    }

    public function reply(Request $request, ContactInquiry $contactInquiry)
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string|max:10000',
        ]);

        $contactInquiry->update([
            'admin_reply' => $validated['admin_reply'],
            'replied_at' => now(),
        ]);

        return back()->with('success', 'Reply sent successfully.');
    }

    public function destroy(ContactInquiry $contactInquiry)
    {
        $contactInquiry->delete();
        return redirect()->route('admin.contact-inquiries')->with('success', 'Inquiry deleted.');
    }
}
