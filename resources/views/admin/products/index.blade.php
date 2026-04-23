@extends('admin.layout')

@section('page-title', 'Products')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <form action="/admin/products" method="GET" class="flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="px-4 py-2 border border-gray-300 rounded-lg">
        <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">Filter</button>
    </form>
    <a href="/admin/products/create" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Add Product</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($products as $product)
            <tr>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex-shrink-0"></div>
                        <div class="ml-4">
                            <p class="font-medium">{{ $product->name }}</p>
                            <p class="text-sm text-gray-500">{{ $product->sku }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $product->category?->name ?? '-' }}</td>
                <td class="px-6 py-4 font-medium">${{ number_format($product->base_price, 2) }}</td>
                <td class="px-6 py-4">
                    @if($product->in_stock)
                    <span class="text-green-600">In Stock</span>
                    @else
                    <span class="text-blue-600">Out of Stock</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <a href="/admin/products/{{ $product->id }}/edit" class="text-blue-600 hover:underline mr-3">Edit</a>
                    <form action="/admin/products/{{ $product->id }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-blue-600 hover:underline" onclick="return confirm('Delete this product?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $products->links() }}</div>
@endsection