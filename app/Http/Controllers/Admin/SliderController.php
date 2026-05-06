<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->paginate(20);
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'link_url' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:50',
            'image_url' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = 0;

        if ($request->image_url) {
            $validated['image'] = $request->image_url;
        }

        Slider::create($validated);

        return redirect('/admin/sliders')
            ->with('success', 'Slider created.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'link_url' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:50',
            'image_url' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->image_url) {
            $validated['image'] = $request->image_url;
        }

        $slider->update($validated);

        return back()->with('success', 'Slider updated.');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect('/admin/sliders')
            ->with('success', 'Slider deleted.');
    }
}