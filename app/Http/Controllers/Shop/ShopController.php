<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('shop.index', compact('products'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->with('products')->firstOrFail();
        $products = $category->products()->where('is_active', true)->paginate(12);

        return view('shop.category', compact('category', 'products'));
    }

public function product($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['variants', 'images', 'category', 'pricingOptions'])
            ->firstOrFail();
        
        // Ensure images are loaded
        if (!$product->relationLoaded('images')) {
            $product->load('images');
        }
        
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();
        
        return view('shop.product', compact('product', 'relatedProducts'));
    }
}
