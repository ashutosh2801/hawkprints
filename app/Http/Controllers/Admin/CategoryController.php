<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('products');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->has_image === 'yes') {
            $query->whereNotNull('image')->where('image', '!=', '');
        } elseif ($request->has_image === 'no') {
            $query->whereNull('image')->orWhere('image', '');
        }

        $perPage = min((int) $request->per_page, 200) ?: 20;
        $categories = $query->orderBy('name')->paginate($perPage);
        
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($request->name);
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = 0;

        if ($request->image_url) {
            $validated['image'] = $request->image_url;
        }

        Category::create($validated);

        return redirect('/admin/categories')
            ->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($request->name);
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->image_url) {
            $validated['image'] = $request->image_url;
        }

        $category->update($validated);

        return back()->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/admin/categories')
            ->with('success', 'Category deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->category_ids;
        if ($ids) {
            Category::whereIn('id', $ids)->delete();
        }
        return redirect('/admin/categories')
            ->with('success', count($ids ?? []) . ' categories deleted.');
    }
}