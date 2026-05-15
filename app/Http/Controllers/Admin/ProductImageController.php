<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\Product;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductImageController extends Controller
{
    protected $storageService;

    public function __construct(ImageStorageService $storageService)
    {
        $this->storageService = $storageService;
    }

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

            $paths = $this->storageService->uploadWithSizes($file, $filename, [
                'small' => 300,
                'medium' => 600,
            ]);

            ProductImage::create([
                'product_id' => $productId,
                'image' => $paths['image'],
                'small' => $paths['small'] ?? null,
                'medium' => $paths['medium'] ?? null,
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
                try {
                    $this->storageService->delete($path);
                } catch (\Exception $e) {
                    Log::error('Failed to delete: ' . $path);
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
            if ($image) {
                if (!$image->product_id || $image->product_id != $product->id) {
                    $image->update([
                        'product_id' => $product->id,
                        'sort_order' => ++$maxOrder,
                    ]);
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Images attached to product.']);
    }
}