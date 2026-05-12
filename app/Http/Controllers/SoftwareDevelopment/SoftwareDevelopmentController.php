<?php

namespace App\Http\Controllers\SoftwareDevelopment;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\SoftwareDevelopmentRequest;
use Illuminate\Http\Request;

class SoftwareDevelopmentController extends Controller
{
    public function index()
    {
        return view('front.software-development');
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'service' => 'required|string|in:web_development,mobile_development,ux_ui_design,custom_software,cloud_solutions,consulting,other',
            'budget' => 'nullable|numeric|min:0|max:999999.99',
            'message' => 'required|string|max:5000',
        ]);

        $validated['budget'] = $validated['budget'] ?? null;

        $request_record = SoftwareDevelopmentRequest::create($validated);

        AdminNotification::createNotification('software', [
            'name' => $request_record->name,
            'email' => $request_record->email,
            'phone' => $request_record->phone,
            'company' => $request_record->company,
            'service' => $request_record->service,
            'message' => $request_record->message,
            'software_request_id' => $request_record->id,
        ]);

        return back()->with('success', 'Thank you! Your software development inquiry has been received. We will contact you within 24 hours.');
    }
}
