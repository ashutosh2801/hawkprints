<section class="py-12 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full filter blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative">
        <div class="text-center mb-10">
            <span class="inline-block px-4 py-1.5 bg-white/10 text-white text-sm font-medium rounded-full mb-4 border border-white/20">Discover More</span>
            <h2 class="text-3xl md:text-4xl font-bold">Explore our range</h2>
            <p class="mt-4 text-lg text-gray-300 max-w-2xl mx-auto">Browse through our extensive collection of printing solutions</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @php
                $categoryIds = $category_ids ?? [];
                if (!empty($categoryIds)) {
                    $exploreItems = \App\Models\Category::whereIn('id', $categoryIds)
                        ->where('is_active', true)
                        ->orderBy('name')
                        ->get();
                } else {
                    $exploreItems = \App\Models\Category::where('is_active', true)
                        ->orderBy('sort_order')
                        ->take(4)
                        ->get();
                }
            @endphp

            @foreach($exploreItems as $category)
                <a href="{{ route('shop.category', $category->slug) }}" class="group">
                    <div class="relative rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500">
                        <div class="aspect-square overflow-hidden">
                            @if($category->image)
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-700 to-gray-800">
                                <span class="text-5xl font-bold text-gray-600">{{ substr($category->name, 0, 1) }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-5">
                            <h3 class="font-semibold text-lg group-hover:text-blue-400 transition-colors">{{ $category->name }}</h3>
                            <div class="mt-2 flex items-center gap-2 text-sm text-gray-300 group-hover:text-white transition-colors">
                                <span>Explore</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
