<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductImageController extends Controller
{
    public function store(Request $request)
    {
        $productId = $request->input('product_id');
        
        // Log debug info
        $logMsg = "Image upload attempt - product_id: " . ($productId ?? 'null') . ", files: " . ($request->hasFile('images') ? 'yes' : 'no');
        Log::info($logMsg);
        
        if (!$productId) {
            Log::error('No product_id in request');
            return back()->with('error', 'Product ID missing');
        }
        
        $product = Product::find($productId);
        if (!$product) {
            Log::error('Product not found: ' . $productId);
            return back()->with('error', 'Product not found');
        }
        
        if (!$request->hasFile('images')) {
            Log::error('No images in request');
            return back()->with('error', 'Please select an image');
        }
        
        $files = $request->file('images');
        if (!is_array($files)) {
            $files = [$files];
        }
        
        $maxOrder = ProductImage::where('product_id', $productId)->max('sort_order') ?? 0;
        
        foreach ($files as $file) {
            if (!$file) continue;
            
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Save to storage
            $file->storeAs('products', $filename, 'public');
            $file->storeAs('products/small', $filename, 'public');
            $file->storeAs('products/medium', $filename, 'public');
            
            ProductImage::create([
                'product_id' => $productId,
                'image' => '/storage/products/' . $filename,
                'small' => '/storage/products/small/' . $filename,
                'medium' => '/storage/products/medium/' . $filename,
                'sort_order' => ++$maxOrder,
                'is_active' => true,
            ]);
            
            Log::info('Saved image: ' . $filename);
        }
        
        return back()->with('success', count($files) . ' image(s) uploaded!');
    }

    public function destroy(ProductImage $image)
    {
        $imagePaths = [$image->image, $image->small, $image->medium];
        
        foreach ($imagePaths as $path) {
            if ($path) {
                $storagePath = str_replace('/storage/', '', $path);
                try {
                    Storage::disk('public')->delete($storagePath);
                } catch (\Exception $e) {
                    Log::error('Failed to delete: ' . $storagePath);
                }
            }
        }
        
        $image->delete();
        
        return back()->with('success', 'Image deleted.');
    }
}