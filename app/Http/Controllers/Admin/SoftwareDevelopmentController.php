<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePageSection;
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

    public function editContent()
    {
        $section = HomePageSection::where('key', 'software-development-page')->firstOrFail();
        $settings = $section->settings ?? [];
        return view('admin.software-development.content', compact('settings'));
    }

    public function updateContent(Request $request)
    {
        $section = HomePageSection::where('key', 'software-development-page')->firstOrFail();
        $settings = $request->input('settings', []);

        foreach (['stats', 'services', 'showcase', 'process', 'why', 'testimonials'] as $key) {
            if (isset($settings[$key]) && is_array($settings[$key])) {
                $settings[$key] = array_values($settings[$key]);
            }
        }

        if (isset($settings['tech']) && is_array($settings['tech'])) {
            foreach ($settings['tech'] as $cat => $val) {
                $settings['tech'][$cat] = array_map('trim', explode(',', $val));
            }
        }

        if (isset($settings['services']) && is_array($settings['services'])) {
            foreach ($settings['services'] as $i => $service) {
                if (isset($service['features']) && is_string($service['features'])) {
                    $settings['services'][$i]['features'] = array_map('trim', explode(',', $service['features']));
                }
            }
        }

        $enabledKeys = ['hero', 'stats_section', 'services_section', 'showcase_section', 'process_section', 'why_section', 'tech_section', 'testimonials_section', 'cta', 'contact_section'];
        foreach ($enabledKeys as $ek) {
            if (isset($settings[$ek])) {
                $settings[$ek]['enabled'] = !empty($settings[$ek]['enabled']);
            }
        }

        $itemKeys = ['services', 'process', 'why', 'testimonials'];
        foreach ($itemKeys as $ik) {
            if (isset($settings[$ik]) && is_array($settings[$ik])) {
                foreach ($settings[$ik] as $i => $item) {
                    if (isset($item['enabled'])) {
                        $settings[$ik][$i]['enabled'] = !empty($item['enabled']);
                    }
                }
            }
        }

        $section->update(['settings' => $settings]);

        return redirect()->route('admin.software-development.content')->with('success', 'Page content updated successfully.');
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
