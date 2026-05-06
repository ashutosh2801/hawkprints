<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaLibraryController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductImage::orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('image', 'like', '%' . $request->search . '%');
        }

        $images = $query->paginate(48);

        return view('admin.media-library.index', compact('images'));
    }

    public function getList(Request $request)
    {
        $query = ProductImage::orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('image', 'like', '%' . $request->search . '%')
                  ->orWhere('alt', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->product_id) {
            $query->where('product_id', $request->product_id);
        }

        $images = $query->get()->map(function ($image) {
            return [
                'id' => $image->id,
                'url' => $image->image,
                'thumbnail' => $image->small ?: $image->image,
                'alt' => $image->alt ?? '',
                'title' => $image->title ?? '',
                'sort_order' => $image->sort_order,
                'product_id' => $image->product_id,
                'is_primary' => $image->is_primary,
                'created_at' => $image->created_at->format('M d, Y'),
            ];
        });

        return response()->json(['images' => $images]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'required|file|image|max:10240',
            'product_id' => 'nullable|exists:products,id',
        ]);

        $productId = $request->product_id;
        $maxOrder = $productId ? ProductImage::where('product_id', $productId)->max('sort_order') ?? 0 : 0;

        $uploaded = [];

        foreach ($request->file('files') as $file) {
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('products', $filename, 'public');
            $file->storeAs('products/small', $filename, 'public');
            $file->storeAs('products/medium', $filename, 'public');

            $image = ProductImage::create([
                'product_id' => $productId,
                'image' => '/storage/products/' . $filename,
                'small' => '/storage/products/small/' . $filename,
                'medium' => '/storage/products/medium/' . $filename,
                'sort_order' => ++$maxOrder,
                'is_primary' => $maxOrder === 1 && $productId,
                'is_active' => true,
            ]);

            $uploaded[] = [
                'id' => $image->id,
                'url' => $image->image,
                'thumbnail' => $image->small ?: $image->image,
            ];
        }

        return response()->json([
            'success' => true,
            'images' => $uploaded,
            'message' => count($uploaded) . ' image(s) uploaded!',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'alt' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'replace_file' => 'nullable|file|image|max:10240',
        ]);

        $image = ProductImage::find($id);
        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Image not found'], 404);
        }

        $image->alt = $request->alt;
        $image->title = $request->title;

        if ($request->hasFile('replace_file')) {
            $file = $request->file('replace_file');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();

            $oldPaths = [$image->image, $image->small, $image->medium];

            $file->storeAs('products', $filename, 'public');
            $file->storeAs('products/small', $filename, 'public');
            $file->storeAs('products/medium', $filename, 'public');

            $image->image = '/storage/products/' . $filename;
            $image->small = '/storage/products/small/' . $filename;
            $image->medium = '/storage/products/medium/' . $filename;

            foreach ($oldPaths as $path) {
                if ($path) {
                    $storagePath = str_replace('/storage/', '', $path);
                    Storage::disk('public')->delete($storagePath);
                }
            }
        }

        $image->save();

        return response()->json([
            'success' => true,
            'message' => 'Image updated successfully.',
            'image' => [
                'id' => $image->id,
                'url' => $image->image,
                'thumbnail' => $image->small ?: $image->image,
                'alt' => $image->alt ?? '',
                'title' => $image->title ?? '',
            ],
        ]);
    }

    public function destroy($id)
    {
        $image = ProductImage::find($id);
        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Image not found'], 404);
        }

        $paths = [$image->image, $image->small, $image->medium];

        foreach ($paths as $path) {
            if ($path) {
                $storagePath = str_replace('/storage/', '', $path);
                Storage::disk('public')->delete($storagePath);
            }
        }

        $image->delete();

        return response()->json(['success' => true, 'message' => 'Image deleted.']);
    }

    public function setPrimary($id)
    {
        $image = ProductImage::find($id);
        if (!$image || !$image->product_id) {
            return response()->json(['success' => false, 'message' => 'Invalid image'], 404);
        }

        ProductImage::where('product_id', $image->product_id)->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return response()->json(['success' => true, 'message' => 'Primary image updated.']);
    }
}
