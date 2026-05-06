<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-14">
            <div>
                <span class="inline-block px-4 py-1.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-full mb-4">Just In</span>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $heading ?? 'New Arrivals' }}</h2>
                <p class="mt-4 text-lg text-gray-500 max-w-xl">Fresh additions to our collection, ready to bring your ideas to life</p>
            </div>
            <a href="{{ route('shop') }}" class="mt-6 md:mt-0 inline-flex items-center gap-2 text-blue-700 font-medium hover:text-blue-800 transition-colors group">
                View all products
                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
            $productLimit = $limit ?? 4;
            $categoryIds = $category_ids ?? [];

            $query = \App\Models\Product::where('is_active', true)
                ->orderBy('created_at', 'desc');

            if (!empty($categoryIds)) {
                $query->whereIn('category_id', $categoryIds);
            }

            $newProducts = $query->take($productLimit)->get();
            @endphp

            @forelse($newProducts as $product)
                <div class="group">
                    <a href="{{ route('shop.product', $product->slug) }}" class="block">
                        <div class="relative aspect-[4/3] overflow-hidden rounded-2xl bg-gray-100 mb-4">
                            <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute top-3 left-3">
                                <span class="px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-full">New</span>
                            </div>
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors duration-300"></div>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-blue-700 transition-colors line-clamp-1">{{ $product->name }}</h3>
                        <p class="text-lg font-bold text-gray-900">{{ $product->formatted_price }}</p>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-gray-500 text-lg">No new arrivals yet. Check back soon!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
