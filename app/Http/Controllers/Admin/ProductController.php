<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\PricingOption;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        
        if ($request->category) {
            $query->where('category_id', $request->category);
        }
        
        $products = $query->orderBy('created_at', 'desc')->paginate(20);
        $categories = Category::where('is_active', true)->get();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'sku' => 'nullable|string',
            'base_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|file|image',
            'in_stock' => 'nullable|boolean',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($request->name);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['in_stock'] = $request->boolean('in_stock', true);
        $validated['is_active'] = true;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $product = Product::create($validated);

        return redirect('/admin/products/' . $product->id . '/edit')
            ->with('success', 'Product created.');
    }

public function edit($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect('/admin/products')->with('error', 'Product not found');
        }
        
        $categories = Category::where('is_active', true)->get();
        $productImages = ProductImage::where('product_id', $id)->orderBy('sort_order')->get();
        
        $opts = PricingOption::where('product_id', $id)->orderBy('sort_order')->get();
        $pricingOptions = $opts->toArray();
        
        return view('admin.products.edit', compact('product', 'categories', 'productImages', 'pricingOptions'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return back()->with('error', 'Product not found');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'sku' => 'nullable|string',
            'base_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|file|image',
            'in_stock' => 'nullable|boolean',
        ]);

        $validated['is_featured'] = $request->has('is_featured');
        $validated['in_stock'] = $request->boolean('in_stock', true);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $product->update($validated);

        return back()->with('success', 'Product updated.');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
        }
        return redirect('/admin/products')->with('success', 'Product deleted.');
    }

    public function addPricingOption(Request $request, Product $product)
    {
        $request->validate([
            'option_name' => 'required|string|max:255',
            'option_type' => 'required|string|max:50',
            'choices_text' => 'required|string',
            'prices_text' => 'required|string',
        ]);

        $choices = array_map('trim', explode(',', $request->choices_text));
        $prices = array_map('trim', explode(',', $request->prices_text));

        $option = $product->pricingOptions()->create([
            'option_name' => $request->option_name,
            'option_type' => $request->option_type,
            'choices' => $choices,
            'prices' => $prices,
            'is_required' => $request->boolean('is_required', true),
            'sort_order' => ($product->pricingOptions()->max('sort_order') ?? 0) + 1,
        ]);

        return back()->with('success', 'Pricing option added.');
    }

    public function updatePricingOption(Request $request, PricingOption $option)
    {
        $request->validate([
            'option_name' => 'required|string|max:255',
            'option_type' => 'required|string|max:50',
            'choices_text' => 'required|string',
            'prices_text' => 'required|string',
        ]);

        $choices = array_map('trim', explode(',', $request->choices_text));
        $prices = array_map('trim', explode(',', $request->prices_text));

        $option->update([
            'option_name' => $request->option_name,
            'option_type' => $request->option_type,
            'choices' => $choices,
            'prices' => $prices,
            'is_required' => $request->boolean('is_required', true),
        ]);

        return back()->with('success', 'Pricing option updated.');
    }

    public function deletePricingOption(PricingOption $option)
    {
        $option->delete();
        return back()->with('success', 'Pricing option deleted.');
    }
}