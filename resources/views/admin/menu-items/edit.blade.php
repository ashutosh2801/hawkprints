@extends('admin.layout')

@section('page-title', 'Edit Menu Item')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Edit Menu Item</h2>
            <a href="{{ route('admin.menu-items') }}" class="text-blue-600 hover:text-blue-800">← Back to List</a>
        </div>

        <form method="POST" action="{{ route('admin.menu-items.update', $menuItem->id) }}" class="p-4 bg-gray-50 rounded-lg">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Type</label>
                    <select name="type" id="linkType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" onchange="toggleLinkFields()">
                        <option value="custom" {{ $menuItem->type === 'custom' ? 'selected' : '' }}>Custom URL</option>
                        <option value="category" {{ $menuItem->type === 'category' ? 'selected' : '' }}>Category</option>
                        <option value="product" {{ $menuItem->type === 'product' ? 'selected' : '' }}>Product</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Parent Menu Item</label>
                    <select name="parent_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">-- None (Top Level) --</option>
                        @php $parentItems = App\Models\MenuItem::whereNull('parent_id')->where('id', '!=', $menuItem->id)->orderBy('name')->get(); @endphp
                        @foreach($parentItems as $parent)
                        <option value="{{ $parent->id }}" {{ $menuItem->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="customFields" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Custom Label</label>
                    <input type="text" name="name" value="{{ $menuItem->name }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Custom URL</label>
                    <input type="text" name="slug" value="{{ $menuItem->slug }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div id="categoryFields" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Category</label>
                <select name="reference_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $menuItem->reference_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="productFields" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Product</label>
                <select name="reference_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Product</option>
                    @foreach($products as $prod)
                    <option value="{{ $prod->id }}" {{ $menuItem->reference_id == $prod->id ? 'selected' : '' }}>{{ $prod->name }} - ${{ number_format($prod->base_price, 2) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ $menuItem->sort_order }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex items-center gap-2 mt-6">
                    <input type="checkbox" name="is_active" value="1" id="is_active" {{ $menuItem->is_active ? 'checked' : '' }} class="w-4 h-4 text-blue-600 rounded">
                    <label for="is_active" class="text-sm text-gray-700">Active</label>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function toggleLinkFields() {
    var type = document.getElementById('linkType').value;
    document.getElementById('customFields').classList.toggle('hidden', type !== 'custom');
    document.getElementById('categoryFields').classList.toggle('hidden', type !== 'category');
    document.getElementById('productFields').classList.toggle('hidden', type !== 'product');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleLinkFields();
});
</script>
@endsection