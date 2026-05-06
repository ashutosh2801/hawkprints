<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePageSection;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $sections = HomePageSection::ordered()->get();
        $available = HomePageSection::SECTIONS;

        $missing = [];
        foreach ($available as $key => $info) {
            if (!$sections->contains('key', $key)) {
                $missing[$key] = $info;
            }
        }

        $categories = \App\Models\Category::where('is_active', true)->orderBy('name')->get(['id', 'name', 'slug', 'image']);
        $products = \App\Models\Product::where('is_active', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'slug', 'image', 'category_id']);
        $products = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'image' => $p->image,
                'category' => $p->category?->name ?? '',
            ];
        });

        return view('admin.home-page.index', compact('sections', 'available', 'missing', 'categories', 'products'));
    }

    public function toggle($id)
    {
        $section = HomePageSection::findOrFail($id);
        $section->update(['is_active' => !$section->is_active]);

        return back()->with('success', 'Section toggled.');
    }

    public function update(Request $request, $id)
    {
        $section = HomePageSection::findOrFail($id);

        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'settings' => 'nullable|array',
        ]);

        $updateData = [];
        if (isset($validated['title'])) $updateData['title'] = $validated['title'];
        if (isset($validated['description'])) $updateData['description'] = $validated['description'];
        if (isset($validated['settings'])) $updateData['settings'] = $validated['settings'];

        $section->update($updateData);

        if ($request->expectsJson() || $request->header('Content-Type') === 'application/json') {
            return response()->json(['success' => true, 'message' => 'Section updated.']);
        }

        return back()->with('success', 'Section updated.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
        ]);

        foreach ($request->order as $index => $id) {
            HomePageSection::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    public function add($key)
    {
        if (!isset(HomePageSection::SECTIONS[$key])) {
            return back()->with('error', 'Invalid section.');
        }

        $info = HomePageSection::SECTIONS[$key];

        if (HomePageSection::where('key', $key)->exists()) {
            return back()->with('error', 'Section already added.');
        }

        $maxOrder = HomePageSection::max('sort_order') ?? 0;

        HomePageSection::create([
            'key' => $key,
            'title' => $info['title'],
            'description' => $info['description'],
            'is_active' => true,
            'sort_order' => $maxOrder + 1,
        ]);

        return back()->with('success', 'Section added.');
    }

    public function remove($id)
    {
        $section = HomePageSection::findOrFail($id);
        $section->delete();

        return back()->with('success', 'Section removed.');
    }
}
