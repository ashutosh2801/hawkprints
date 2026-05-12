@extends('layouts.app')

@section('title', 'Shop - Five Rivers Print')
@section('meta_description', 'Browse our full catalog of printing products. From business cards to banners, find everything you need at Five Rivers Print.')

@section('content')
<!-- JSON-LD BreadcrumbList -->
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
        {"@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}"},
        {"@type": "ListItem", "position": 2, "name": "Shop", "item": "{{ url('/shop') }}"}
    ]
}
</script>
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                    <h2 class="text-lg font-bold mb-4">Filters</h2>
                    
                    <form action="{{ route('shop') }}" method="GET" id="filterForm">
                        <!-- Search -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3">Categories</h3>
                            <div class="space-y-2">
                                @foreach($categories as $cat)
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="categories[]" value="{{ $cat->slug }}" 
                                           {{ in_array($cat->slug, request('categories', [])) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-700 rounded border-gray-300 focus:ring-blue-700">
                                    <span class="text-gray-700 hover:text-blue-700">{{ $cat->name }}</span>
                                    <span class="text-gray-400 text-xs ml-auto">({{ $cat->products_count }})</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3">Price Range</h3>
                            <div class="flex items-center gap-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <span class="text-gray-400">-</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-1/2 px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3">Availability</h3>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} class="w-4 h-4 text-blue-700 rounded border-gray-300 focus:ring-blue-700">
                                <span class="text-gray-700">In Stock Only</span>
                            </label>
                        </div>

                        <!-- Sort By -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3">Sort By</h3>
                            <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
                            </select>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 text-sm font-medium">
                                Apply Filters
                            </button>
                            <a href="{{ route('shop') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </aside>

            <!-- Products Grid -->
            <main class="flex-1">
                <!-- Active Filters & Results Count -->
                <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                    <div>
                        <p class="text-gray-600">
                            @if(request()->anyFilled(['search', 'categories', 'min_price', 'max_price', 'in_stock']))
                                Showing <span class="font-semibold">{{ $products->total() }}</span> results
                            @else
                                <span class="font-semibold">{{ $products->total() }}</span> Products
                            @endif
                        </p>
                    </div>
                    
                    <!-- Active Filters Tags -->
                    @if(request()->anyFilled(['search', 'categories', 'min_price', 'max_price', 'in_stock']))
                    <div class="flex flex-wrap items-center gap-2">
                        @if(request('search'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                            Search: {{ request('search') }}
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="hover:text-blue-900">×</a>
                        </span>
                        @endif
                        @foreach(request('categories', []) as $cat)
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                            {{ $cat }}
                            <a href="{{ request()->fullUrlWithQuery(['categories' => array_values(array_filter(request('categories'), fn($c) => $c !== $cat))]) }}" class="hover:text-blue-900">×</a>
                        </span>
                        @endforeach
                        @if(request('min_price') || request('max_price'))
                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                            ${{ request('min_price') ?: '0' }} - ${{ request('max_price') ?: '∞' }}
                            <a href="{{ request()->fullUrlWithQuery(['min_price' => null, 'max_price' => null]) }}" class="hover:text-blue-900">×</a>
                        </span>
                        @endif
                    </div>
                    @endif
                </div>

                @if($products->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                    <p class="text-gray-500 mb-4">Try adjusting your filters or search terms</p>
                    <a href="{{ route('shop') }}" class="inline-block px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800">
                        Clear All Filters
                    </a>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow group">
                        <a href="{{ route('shop.product', $product->slug) }}" class="block">
                            <div class="relative aspect-square overflow-hidden bg-gray-100">
                                <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @if(!$product->in_stock)
                                    <span class="absolute top-2 left-2 bg-red-600 text-white text-xs px-2 py-1 rounded">Out of Stock</span>
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
                            @if($product->pricingOptions->count() > 0)
                                <a href="{{ route('shop.product', $product->slug) }}" class="block w-full py-2 bg-blue-700 hover:bg-blue-800 text-white text-center rounded font-semibold">
                                    Select Options
                                </a>
                            @else
                                <form action="{{ route('cart.add', $product->slug) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full py-2 bg-blue-700 hover:bg-blue-800 text-white rounded font-semibold">
                                        Add to Cart
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($products->hasPages())
                    <div class="mt-8">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    
    filterForm.addEventListener('submit', function(e) {
        const searchInput = filterForm.querySelector('input[name="search"]');
        if (searchInput && !searchInput.value.trim()) {
            searchInput.disabled = true;
        }
    });

    filterForm.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            filterForm.submit();
        });
    });
});
</script>
@endpush