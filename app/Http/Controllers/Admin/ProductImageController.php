<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Laravel\Facades\Image;

class ProductImageController extends Controller
{
    public function store(Request $request)
    {
        $productId = $request->input('product_id');
        
        if (!$productId) {
            return back()->with('error', 'Product ID missing');
        }
        
        $product = Product::find($productId);
        if (!$product) {
            return back()->with('error', 'Product not found');
        }
        
        if (!$request->hasFile('images')) {
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
            
            $originalImage = Image::read($file);
            
            $originalImage->save(storage_path('app/public/products/' . $filename));
            
            $smallImage = clone $originalImage;
            $smallImage->scale(width: 300);
            $smallImage->save(storage_path('app/public/products/small/' . $filename));
            
            $mediumImage = clone $originalImage;
            $mediumImage->scale(width: 600);
            $mediumImage->save(storage_path('app/public/products/medium/' . $filename));
            
            ProductImage::create([
                'product_id' => $productId,
                'image' => '/storage/products/' . $filename,
                'small' => '/storage/products/small/' . $filename,
                'medium' => '/storage/products/medium/' . $filename,
                'sort_order' => ++$maxOrder,
                'is_active' => true,
            ]);
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

    public function attach(Request $request, Product $product)
    {
        $request->validate([
            'image_ids' => 'required|array',
            'image_ids.*' => 'exists:product_images,id',
        ]);

        $maxOrder = $product->images()->max('sort_order') ?? 0;

        foreach ($request->image_ids as $imageId) {
            $image = ProductImage::find($imageId);
            if ($image && !$image->product_id) {
                $image->update([
                    'product_id' => $product->id,
                    'sort_order' => ++$maxOrder,
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Images attached to product.']);
    }
}