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

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('categories') && $request->categories) {
            $categorySlugs = is_array($request->categories) ? $request->categories : [$request->categories];
            $categories = Category::whereIn('slug', $categorySlugs)->pluck('id');
            $query->whereIn('category_id', $categories);
        }

        if ($request->has('min_price') && $request->min_price) {
            $query->where('base_price', '>=', $request->min_price);
        }

        if ($request->has('max_price') && $request->max_price) {
            $query->where('base_price', '<=', $request->max_price);
        }

        if ($request->has('in_stock') && $request->in_stock) {
            $query->where('in_stock', true);
        }

        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('base_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('base_price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->withCount('products')->get();

        return view('shop.index', compact('products', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->where('is_active', true)->paginate(12);

        return view('shop.category', compact('category', 'products'));
    }

public function product($slug)
    {
        $product = Product::where('slug', $slug)
            ->with(['variants', 'productImages', 'category', 'pricingOptions'])
            ->firstOrFail();
        
        if ($product->category_id) {
            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->take(4)
                ->get();
        } else {
            $relatedProducts = Product::where('id', '!=', $product->id)
                ->where('is_active', true)
                ->inRandomOrder()
                ->take(4)
                ->get();
        }
        
        return view('shop.product', compact('product', 'relatedProducts'));
    }
}
