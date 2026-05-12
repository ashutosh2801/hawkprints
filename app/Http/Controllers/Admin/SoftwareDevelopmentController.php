<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SoftwareDevelopmentRequest;
use Illuminate\Http\Request;

class SoftwareDevelopmentController extends Controller
{
    public function index()
    {
        $requests = SoftwareDevelopmentRequest::orderBy('created_at', 'desc')->get();
        $unreadCount = SoftwareDevelopmentRequest::where('is_read', false)->count();
        return view('admin.software-development.index', compact('requests', 'unreadCount'));
    }

    public function show(SoftwareDevelopmentRequest $softwareDevelopmentRequest)
    {
        if (!$softwareDevelopmentRequest->is_read) {
            $softwareDevelopmentRequest->update(['is_read' => true]);
        }
        return view('admin.software-development.show', compact('softwareDevelopmentRequest'));
    }

    public function updateStatus(Request $request, SoftwareDevelopmentRequest $softwareDevelopmentRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,contacted,closed',
        ]);

        $softwareDevelopmentRequest->update($validated);

        return back()->with('success', 'Status updated successfully.');
    }

    public function updateNotes(Request $request, SoftwareDevelopmentRequest $softwareDevelopmentRequest)
    {
        $validated = $request->validate([
            'admin_notes' => 'nullable|string|max:10000',
        ]);

        $softwareDevelopmentRequest->update($validated);

        return back()->with('success', 'Notes saved successfully.');
    }

    public function destroy(SoftwareDevelopmentRequest $softwareDevelopmentRequest)
    {
        $softwareDevelopmentRequest->delete();
        return redirect()->route('admin.software-development')->with('success', 'Request deleted.');
    }
}
