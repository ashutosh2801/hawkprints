<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-14">
            <span class="inline-block px-4 py-1.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-full mb-4">Full Catalog</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $heading ?? 'Explore all categories' }}</h2>
            <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">Everything you need, all in one place</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @php
            $categoryLimit = $limit ?? 0;

            $query = \App\Models\Category::where('is_active', true)
                ->whereNull('parent_id')
                ->withCount('products');

            if ($categoryLimit > 0) {
                $allCategories = $query->take($categoryLimit)->get();
            } else {
                $allCategories = $query->get();
            }
            @endphp

            @forelse($allCategories as $category)
                <a href="{{ route('shop.category', $category->slug) }}" class="group">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-gray-100">
                        <div class="aspect-[4/3] overflow-hidden">
                            @if($category->image)
                                <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors mb-1">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $category->products_count }} product{{ $category->products_count !== 1 ? 's' : '' }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                    </div>
                    <p class="text-gray-500 text-lg">No categories found.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
