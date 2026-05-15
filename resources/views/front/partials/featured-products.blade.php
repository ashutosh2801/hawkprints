<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <span class="inline-block px-4 py-1.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-full mb-4">Curated Selection</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Featured products</h2>
            <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">Handpicked products that showcase our quality craftsmanship</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $productIds = $product_ids ?? [];
                $limit = $limit ?? 6;

                if (!empty($productIds)) {
                    $featuredProducts = \App\Models\Product::whereIn('id', $productIds)
                        ->where('is_active', true)
                        ->with('category', 'pricingOptions')
                        ->get()
                        ->take($limit);
                } else {
                    $featuredProducts = \App\Models\Product::where('is_active', true)
                        ->where('is_featured', true)
                        ->with('category', 'pricingOptions')
                        ->take($limit)
                        ->get();

                    if ($featuredProducts->isEmpty()) {
                        $featuredProducts = \App\Models\Product::where('is_active', true)
                            ->with('category', 'pricingOptions')
                            ->take($limit)
                            ->get();
                    }
                }
            @endphp

            @forelse($featuredProducts as $product)
                <div class="group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100">
                    <a href="/shop/product/{{ $product->slug }}" class="block">
                        <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                            @if($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            @endif
                            @if(!$product->in_stock)
                                <span class="absolute top-3 left-3 bg-gray-900/80 backdrop-blur-sm text-white text-xs px-3 py-1.5 rounded-full font-medium">Out of Stock</span>
                            @endif
                            <div class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-5">
                            @if($product->category)
                                <p class="text-xs text-blue-600 font-medium uppercase tracking-wider mb-2">{{ $product->category->name }}</p>
                            @endif
                            <h3 class="font-semibold text-gray-900 mb-3 group-hover:text-blue-700 transition-colors line-clamp-2">{{ $product->name }}</h3>
                            <p class="text-xl font-bold text-gray-900">{{ $product->formatted_price }}</p>
                        </div>
                    </a>
                    <div class="px-5 pb-5">
                        @if($product->pricingOptions->count() > 0)
                            <a href="/shop/product/{{ $product->slug }}" class="block w-full py-2.5 bg-blue-700 hover:bg-blue-800 text-white text-center rounded-xl font-medium transition-colors duration-300 text-sm">
                                Select Options
                            </a>
                        @else
                            <form action="/cart/add/{{ $product->slug }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-xl font-medium transition-colors duration-300 text-sm">
                                    Add to Cart
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <p class="text-gray-500 text-lg">No featured products yet. Check back soon!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
