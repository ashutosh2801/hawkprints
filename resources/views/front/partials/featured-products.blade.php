<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Featured Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
            $featuredProducts = \App\Models\Product::where('is_active', true)
                ->where('is_featured', true)
                ->with('category')
                ->take(6)
                ->get();

            if($featuredProducts->isEmpty()) {
                $featuredProducts = \App\Models\Product::where('is_active', true)->with('category')->take(6)->get();
            }
            @endphp

            @forelse($featuredProducts as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow group">
                    <a href="/shop/product/{{ $product->slug }}" class="block">
                        <div class="relative aspect-square overflow-hidden bg-gray-100">
                            <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @if(!$product->in_stock)
                                <span class="absolute top-2 left-2 bg-blue-700 text-white text-xs px-2 py-1 rounded">Out of Stock</span>
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
                        <form action="/cart/add/{{ $product->slug }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full py-2 bg-blue-700 hover:bg-blue-800 text-white rounded font-semibold">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    <p>No featured products yet. Check back soon!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>