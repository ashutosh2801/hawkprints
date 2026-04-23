<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Explore all categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @php
            $allCategories = \App\Models\Category::where('is_active', true)
                ->whereNull('parent_id')
                ->with('products')
                ->get();
            @endphp

            @forelse($allCategories as $category)
                <a href="{{ route('shop.category', $category->slug) }}" class="group">
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                        <div class="aspect-square overflow-hidden bg-gray-200">
                            @if($category->image)
                                <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4 text-center">
                            <h3 class="font-semibold text-gray-800 group-hover:text-blue-700">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $category->products_count }} products</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    <p>No categories found.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>