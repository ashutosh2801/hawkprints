<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::with('children')->orderBy('sort_order')->get();
        $allItems = MenuItem::orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.menu-items.index', [
            'menuItems' => $menuItems, 
            'allItems' => $allItems,
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'type' => 'nullable|in:custom,category,product',
            'reference_ids' => 'nullable|array',
            'reference_ids.*' => 'integer',
            'parent_id' => 'nullable|exists:menu_items,id',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'location' => 'nullable|in:header,footer',
        ]);

        $type = $validated['type'] ?? 'custom';
        $isActive = $request->has('is_active') ? true : false;
        $sortOrder = $validated['sort_order'] ?? 0;
        $parentId = $validated['parent_id'] ?? null;
        $location = $validated['location'] ?? null;

        if ($type === 'category' && !empty($validated['reference_ids'])) {
            foreach ($validated['reference_ids'] as $refId) {
                $category = Category::find($refId);
                if ($category) {
                    MenuItem::create([
                        'name' => $category->name,
                        'slug' => '/shop/category/' . $category->slug,
                        'type' => 'category',
                        'reference_id' => $category->id,
                        'parent_id' => $parentId,
                        'sort_order' => $sortOrder,
                        'is_active' => $isActive,
                        'location' => $location,
                    ]);
                    $sortOrder++;
                }
            }
        } elseif ($type === 'product' && !empty($validated['reference_ids'])) {
            foreach ($validated['reference_ids'] as $refId) {
                $product = Product::find($refId);
                if ($product) {
                    MenuItem::create([
                        'name' => $product->name,
                        'slug' => '/shop/product/' . $product->slug,
                        'type' => 'product',
                        'reference_id' => $product->id,
                        'parent_id' => $parentId,
                        'sort_order' => $sortOrder,
                        'is_active' => $isActive,
                        'location' => $location,
                    ]);
                    $sortOrder++;
                }
            }
        } else {
            MenuItem::create([
                'name' => $validated['name'] ?? 'Untitled',
                'slug' => $validated['slug'] ?? '/',
                'type' => 'custom',
                'parent_id' => $parentId,
                'sort_order' => $sortOrder,
                'is_active' => $isActive,
                'location' => $location,
            ]);
        }

        return back()->with('success', 'Menu item(s) created successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'type' => 'nullable|in:custom,category,product',
            'reference_id' => 'nullable|integer',
            'parent_id' => 'nullable|exists:menu_items,id',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'location' => 'nullable|in:header,footer',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update($validated);

        return back()->with('success', 'Menu item updated successfully!');
    }

    public function edit($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $allItems = MenuItem::orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $products = Product::where('is_active', true)->orderBy('name')->get();
        
        return view('admin.menu-items.edit', [
            'menuItem' => $menuItem,
            'allItems' => $allItems, 
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function destroy($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        
        MenuItem::where('parent_id', $id)->delete();
        $menuItem->delete();

        return back()->with('success', 'Menu item deleted successfully!');
    }

    public function toggle($id)
    {
        $menuItem = MenuItem::findOrFail($id);
        $menuItem->update(['is_active' => !$menuItem->is_active]);

        return back()->with('success', 'Menu item status updated!');
    }
}