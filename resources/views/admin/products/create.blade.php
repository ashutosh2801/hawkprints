@extends('admin.layout')

@section('page-title', 'Add Product')

@section('content')
<form action="/admin/products" method="POST" enctype="multipart/form-data" class="max-w-4xl">
    @csrf

    <div class="grid grid-cols-2 gap-6">
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
            <input type="text" name="sku" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Base Price</label>
            <input type="number" name="base_price" step="0.01" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Stock Status</label>
            <select name="in_stock" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <option value="1">In Stock</option>
                <option value="0">Out of Stock</option>
            </select>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg wysiwyg"></textarea>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
            <div class="flex items-start gap-4">
                <div id="product-image-preview" class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg overflow-hidden flex items-center justify-center bg-gray-50">
                    <span class="text-gray-400 text-sm">No image</span>
                </div>
                <div class="space-y-2">
                    <button type="button" onclick="selectFromLibrary('product')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                        Choose from Library
                    </button>
                    <input type="hidden" name="image_url" id="product-image-url" value="">
                </div>
            </div>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Featured</label>
            <input type="checkbox" name="is_featured" value="1" class="w-4 h-4">
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Allow Artwork Upload</label>
            <input type="checkbox" name="allow_artwork_upload" value="1" checked class="w-4 h-4">
            <span class="ml-2 text-sm text-gray-600">Allow customers to upload their artwork</span>
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Artwork Instructions</label>
            <textarea name="artwork_instructions" class="w-full px-4 py-2 border border-gray-300 rounded-lg wysiwyg" placeholder="Instructions for customers about artwork requirements (optional)"></textarea>
        </div>
    </div>

    <div class="mt-6 flex gap-4">
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create Product</button>
        <a href="/admin/products" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</a>
    </div>
</form>

<script>
function selectFromLibrary(type) {
    openMediaLibrary({
        mode: 'single',
        callback: function(ids) {
            var img = mediaLibraryState.allImages.find(i => i.id === ids[0]);
            if (img) {
                document.getElementById(type + '-image-url').value = img.url;
                document.getElementById(type + '-image-preview').innerHTML = '<img src="' + img.url + '" alt="" class="w-full h-full object-cover">';
            }
        }
    });
}
</script>

@include('admin.partials.media-library')
@endsection
