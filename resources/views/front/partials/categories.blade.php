<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <span class="inline-block px-4 py-1.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-full mb-4">Popular Choices</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">Shop customer favourites</h2>
            <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">Discover our most loved printing products, chosen by thousands of satisfied customers</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @php
                $categoryIds = $category_ids ?? [];
                if (!empty($categoryIds)) {
                    $categories = \App\Models\Category::whereIn('id', $categoryIds)
                        ->where('is_active', true)
                        ->orderBy('name')
                        ->get();
                } else {
                    $categories = \App\Models\Category::where('is_active', true)
                        ->orderBy('sort_order')
                        ->take(6)
                        ->get();
                }
            @endphp

            @foreach($categories as $category)
                <a href="{{ route('shop.category', $category->slug) }}" class="group">
                    <div class="relative overflow-hidden rounded-2xl bg-gray-50 hover:bg-white hover:shadow-xl transition-all duration-500 border border-transparent hover:border-gray-100">
                        <div class="aspect-square overflow-hidden">
                            @if($category->image)
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100">
                                <span class="text-4xl font-bold text-blue-400">{{ substr($category->name, 0, 1) }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/60 to-transparent">
                            <h3 class="font-semibold text-white text-sm text-center">{{ $category->name }}</h3>
                        </div>
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
