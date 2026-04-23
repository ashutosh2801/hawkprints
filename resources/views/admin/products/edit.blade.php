@extends('admin.layout')

@section('page-title', 'Edit Product - ' . $product->name)

@section('content')
<div class="max-w-6xl">
    <div class="mb-6">
        <a href="/admin/products" class="text-blue-600 hover:underline">&larr; Back to Products</a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
    <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    <div class="bg-white rounded-lg shadow">
        <div class="border-b">
            <nav class="flex -mb-px" aria-label="Tabs">
                <button onclick="switchTab('basic')" id="tab-basic" class="tab-btn py-4 px-6 border-b-2 border-blue-600 text-blue-600 font-medium text-sm">Basic Details</button>
                <button onclick="switchTab('pricing')" id="tab-pricing" class="tab-btn py-4 px-6 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">Pricing Options</button>
                <button onclick="switchTab('images')" id="tab-images" class="tab-btn py-4 px-6 border-b-2 border-transparent text-gray-500 hover:text-gray-700 font-medium text-sm">Images</button>
            </nav>
        </div>

        <div class="p-6">
            <!-- Basic Details Tab -->
            <div id="panel-basic" class="tab-panel">
                <form action="/admin/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-2 gap-6">
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Product Name</label>
                            <input type="text" name="name" value="{{ $product->name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                            <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">SKU</label>
                            <input type="text" name="sku" value="{{ $product->sku }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Base Price ($)</label>
                            <input type="number" name="base_price" step="0.01" value="{{ $product->base_price }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Stock Status</label>
                            <select name="in_stock" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                                <option value="1" {{ $product->in_stock ? 'selected' : '' }}>In Stock</option>
                                <option value="0" {{ !$product->in_stock ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                        
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ $product->description }}</textarea>
                        </div>
                        
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Featured Product</label>
                            <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="w-4 h-4">
                            <span class="ml-2 text-sm text-gray-600">Show on homepage</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save Basic Details</button>
                    </div>
                </form>
            </div>

            <!-- Pricing Options Tab -->
            <div id="panel-pricing" class="tab-panel hidden">
                <div class="mb-4">
                    <h4 class="text-lg font-medium">Current Pricing Options</h4>
                    <p class="text-sm text-gray-600">Manage pricing options - each option is a choice customer makes</p>
                </div>

                @forelse($pricingOptions as $opt)
                <div class="bg-gray-50 p-4 rounded-lg mb-4 border">
                    <form action="/admin/pricing-options/{{ $opt['id'] }}" method="POST">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Option Name</label>
                                <input type="text" name="option_name" value="{{ $opt['option_name'] }}" required class="w-full px-3 py-2 text-sm border rounded-lg">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Type</label>
                                <select name="option_type" class="w-full px-3 py-2 text-sm border rounded-lg">
                                    <option value="quantity" {{ isset($opt['option_type']) && $opt['option_type']=='quantity' ? 'selected' : '' }}>Quantity</option>
                                    <option value="paper" {{ isset($opt['option_type']) && $opt['option_type']=='paper' ? 'selected' : '' }}>Paper Type</option>
                                    <option value="size" {{ isset($opt['option_type']) && $opt['option_type']=='size' ? 'selected' : '' }}>Size</option>
                                    <option value="finishing" {{ isset($opt['option_type']) && $opt['option_type']=='finishing' ? 'selected' : '' }}>Finish</option>
                                    <option value="sided" {{ isset($opt['option_type']) && $opt['option_type']=='sided' ? 'selected' : '' }}>Sides</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Required</label>
                                <input type="checkbox" name="is_required" value="1" {{ !empty($opt['is_required']) ? 'checked' : '' }} class="w-4 h-4 mt-2">
                            </div>
                            <div class="flex items-end gap-2">
                                <button type="submit" class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Update</button>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Choices (comma separated)</label>
                                <input type="text" name="choices_text" value="{{ implode(', ', $opt['choices'] ?? []) }}" class="w-full px-3 py-2 text-sm border rounded-lg">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Prices (comma separated)</label>
                                <input type="text" name="prices_text" value="{{ implode(', ', $opt['prices'] ?? []) }}" class="w-full px-3 py-2 text-sm border rounded-lg">
                            </div>
                        </div>
                    </form>
                    <form action="/admin/pricing-options/{{ $opt['id'] }}" method="POST" class="mt-3" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-lg">Delete</button>
                    </form>
                </div>
                @empty
                <div class="bg-gray-50 p-4 rounded-lg mb-4 text-gray-500 text-sm">No pricing options yet.</div>
                @endforelse

                <hr class="my-6">

                <h4 class="text-md font-medium mb-3">Add New Pricing Option</h4>
                <form action="/admin/products/{{ $product->id }}/pricing-options" method="POST" class="bg-blue-50 p-4 rounded-lg border">
                    @csrf
                    <div class="grid grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Option Name</label>
                            <input type="text" name="option_name" required class="w-full px-3 py-2 text-sm border rounded-lg" placeholder="Select Quantity">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Type</label>
                            <select name="option_type" class="w-full px-3 py-2 text-sm border rounded-lg">
                                <option value="quantity">Quantity</option>
                                <option value="paper">Paper Type</option>
                                <option value="size">Size</option>
                                <option value="finishing">Finish</option>
                                <option value="sided">Sides</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Required</label>
                            <input type="checkbox" name="is_required" value="1" checked class="w-4 h-4 mt-2">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white text-sm rounded-lg">Add</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Choices (comma separated)</label>
                            <input type="text" name="choices_text" required class="w-full px-3 py-2 text-sm border rounded-lg" placeholder="500 qty, 1000 qty">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Prices (comma separated)</label>
                            <input type="text" name="prices_text" required class="w-full px-3 py-2 text-sm border rounded-lg" placeholder="24.99, 39.99">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Images Tab -->
            <div id="panel-images" class="tab-panel hidden">
                <h4 class="text-lg font-medium mb-4">Product Images</h4>

                <form action="/admin/products/{{ $product->id }}/images" method="POST" enctype="multipart/form-data" id="image-upload-form" class="mb-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <!-- Drag & Drop Zone -->
                    <div id="drop-zone" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 hover:bg-blue-50 transition-colors cursor-pointer">
                        <div id="drop-content">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-4v12m-10-12a4 4 0 01-4-4V12a4 4 0 014-4h10a4 4 0 014 4v20a4 4 0 01-4 4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">Drag and drop images here or <span class="text-blue-600 font-medium">click to browse</span></p>
                            <p class="text-xs text-gray-500">PNG, JPG, WEBP - Max 10MB each</p>
                        </div>
                        <div id="preview-section" class="hidden">
                            <div class="grid grid-cols-4 gap-4" id="preview-images"></div>
                            <button type="button" onclick="clearImages()" class="mt-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Clear All</button>
                            <button type="submit" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Upload Images</button>
                        </div>
                    </div>
                    <input type="file" name="images[]" id="file-input" accept="image/*" multiple class="hidden">
                </form>

                <h4 class="text-md font-medium mb-3">Current Images ({{ $productImages->count() }})</h4>
                <div class="grid grid-cols-4 gap-4">
                    @forelse($productImages as $image)
                    <div class="border rounded-lg p-2">
                        <img src="{{ $image->small ?: $image->image }}" alt="" class="w-full h-24 object-cover rounded">
                        <div class="text-xs text-center mt-1 text-gray-500">#{{ $image->sort_order }}</div>
                        <form action="/admin/product-images/{{ $image->id }}" method="POST" onsubmit="return confirm('Delete?')" class="mt-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">Delete</button>
                        </form>
                    </div>
                    @empty
                    <div class="col-span-4 text-gray-500 text-sm">No images uploaded yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('border-blue-600', 'text-blue-600');
        b.classList.add('border-transparent', 'text-gray-500');
    });
    document.getElementById('panel-' + tab).classList.remove('hidden');
    document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-gray-500');
    document.getElementById('tab-' + tab).classList.add('border-blue-600', 'text-blue-600');
}

// Drag and Drop for Images
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('file-input');
const previewImages = document.getElementById('preview-images');
const dropContent = document.getElementById('drop-content');
const previewSection = document.getElementById('preview-section');

dropZone.addEventListener('click', () => fileInput.click());

dropZone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropZone.classList.add('border-blue-500', 'bg-blue-50');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('border-blue-500', 'bg-blue-50');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-blue-500', 'bg-blue-50');
    handleFiles(e.dataTransfer.files);
});

fileInput.addEventListener('change', () => {
    handleFiles(fileInput.files);
});

function handleFiles(files) {
    if (files.length === 0) return;
    
    previewImages.innerHTML = '';
    Array.from(files).forEach(file => {
        if (!file.type.startsWith('image/')) return;
        
        const reader = new FileReader();
        reader.onload = (e) => {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg">
                <p class="text-xs text-gray-500 truncate">${file.name}</p>
            `;
            previewImages.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
    
    dropContent.classList.add('hidden');
    previewSection.classList.remove('hidden');
}

function clearImages() {
    fileInput.value = '';
    previewImages.innerHTML = '';
    dropContent.classList.remove('hidden');
    previewSection.classList.add('hidden');
}
</script>

@endsection