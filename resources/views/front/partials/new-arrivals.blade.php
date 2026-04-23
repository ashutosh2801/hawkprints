<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">New Arrivals</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $newProducts = \App\Models\Product::where('is_active', true)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
            @endphp

            @forelse($newProducts as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow group">
                    <a href="{{ route('shop.product', $product->slug) }}" class="block">
                        <div class="relative aspect-square overflow-hidden bg-gray-100">
                            <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-1 group-hover:text-blue-700">{{ $product->name }}</h3>
                            <p class="text-lg font-bold text-gray-900">{{ $product->formatted_price }}</p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    <p>No new arrivals yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>