<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $templates = EmailTemplate::orderBy('name')->get();
        return view('admin.email-templates.index', compact('templates'));
    }

    public function create()
    {
        $slugs = EmailTemplate::getSlugs();
        return view('admin.email-templates.create', compact('slugs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:email_templates,slug',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'is_active' => 'nullable',
            'send_to_customer' => 'nullable',
            'send_to_admin' => 'nullable',
            'attach_invoice' => 'nullable',
        ]);

        EmailTemplate::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'subject' => $request->subject,
            'body' => $request->body,
            'is_active' => $request->has('is_active'),
            'send_to_customer' => $request->has('send_to_customer'),
            'send_to_admin' => $request->has('send_to_admin'),
            'attach_invoice' => $request->has('attach_invoice'),
        ]);

        return redirect('/admin/email-templates')->with('success', 'Template created!');
    }

    public function edit(EmailTemplate $emailTemplate)
    {
        $slugs = EmailTemplate::getSlugs();
        return view('admin.email-templates.edit', compact('emailTemplate', 'slugs'));
    }

    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:email_templates,slug,' . $emailTemplate->id,
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'is_active' => 'nullable',
            'send_to_customer' => 'nullable',
            'send_to_admin' => 'nullable',
            'attach_invoice' => 'nullable',
        ]);

        $emailTemplate->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'subject' => $request->subject,
            'body' => $request->body,
            'is_active' => $request->has('is_active'),
            'send_to_customer' => $request->has('send_to_customer'),
            'send_to_admin' => $request->has('send_to_admin'),
            'attach_invoice' => $request->has('attach_invoice'),
        ]);

        return redirect('/admin/email-templates')->with('success', 'Template updated!');
    }

    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();
        return back()->with('success', 'Template deleted!');
    }
}