@extends('layouts.app')

@section('title', 'All Products - Hawk Prints')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">All Products</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow group">
                    <a href="{{ route('shop.product', $product->slug) }}" class="block">
                        <div class="relative aspect-square overflow-hidden bg-gray-100">
                            <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @if(!$product->in_stock)
                                <span class="absolute top-2 left-2 bg-blue-700 text-white text-xs px-2 py-1 rounded">Out of Stock</span>
                            @endif
                            @if($product->is_featured)
                                <span class="absolute top-2 right-2 bg-green-600 text-white text-xs px-2 py-1 rounded">Featured</span>
                            @endif
                        </div>
                        <div class="p-4">
                            @if($product->category)
                                <p class="text-sm text-blue-700 mb-1">{{ $product->category->name }}</p>
                            @endif
                            <h3 class="font-semibold text-gray-800 mb-2 group-hover:text-blue-700">{{ $product->name }}</h3>
                            <p class="text-lg font-bold text-gray-900">{{ $product->formatted_price }}</p>
                        </div>
                    </a>
                    <div class="px-4 pb-4">
                        <form action="{{ route('cart.add', $product->slug) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 bg-blue-700 hover:bg-blue-800 text-white rounded font-semibold">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">No products found.</p>
                    <a href="{{ route('shop') }}" class="inline-block mt-4 text-blue-700 hover:underline">Browse all products</a>
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection