@extends('layouts.app')

@section('title', $category->name . ' - Hawk Prints')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-gray-600">{{ $category->description }}</p>
            @endif
        </div>

        @if($category->children->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Subcategories</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($category->children as $child)
                        <a href="{{ route('shop.category', $child->slug) }}" class="px-4 py-2 bg-white rounded-full hover:bg-blue-700 hover:text-white transition">
                            {{ $child->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow group">
                    <a href="{{ route('shop.product', $product->slug) }}" class="block">
                        <div class="relative aspect-square overflow-hidden bg-gray-100">
                            <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @if(!$product->in_stock)
                                <span class="absolute top-2 left-2 bg-blue-700 text-white text-xs px-2 py-1 rounded">Out of Stock</span>
                            @endif
                        </div>
                        <div class="p-4">
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
                    <p class="text-gray-500 text-lg">No products in this category yet.</p>
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