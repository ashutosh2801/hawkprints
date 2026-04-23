@extends('layouts.app')

@section('title', $product->name . ' - Hawk Prints')
@section('meta_description', $product->short_description ?? $product->meta_description)

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <nav class="mb-6 text-sm">
            <ol class="flex items-center gap-2 text-gray-600">
                <li><a href="/" class="hover:text-blue-700">Home</a></li>
                <li>/</li>
                <li><a href="/shop" class="hover:text-blue-700">Shop</a></li>
                @if($product->category)
                <li>/</li>
                <li><a href="/shop/category/{{ $product->category->slug }}" class="hover:text-blue-700">{{ $product->category->name }}</a></li>
                @endif
                <li>/</li>
                <li>{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-lg shadow-lg p-6 lg:p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <div class="aspect-square rounded-lg overflow-hidden bg-gray-100">
                        <img src="{{ $product->primary_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>
                </div>

                <div>
                    @if($product->category)
                        <p class="text-blue-700 font-medium mb-2">{{ $product->category->name }}</p>
                    @endif
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    <p class="text-gray-600 mb-6">{{ $product->short_description }}</p>

                    @if($product->pricingOptions->count() > 0)
                    <form action="/cart/add/{{ $product->slug }}" method="POST" id="pricingForm">
                        @csrf
                        
                        <div id="pricingOptions" class="space-y-6">
                            @foreach($product->pricingOptions as $option)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $option->option_name }}
                                </label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($option->choices as $index => $choice)
                                    <label class="relative">
                                        <input type="radio" 
                                               name="option_{{ $option->id }}" 
                                               value="{{ $index }}" 
                                               class="peer sr-only"
                                               data-option-id="{{ $option->id }}"
                                               data-option-index="{{ $index }}"
                                               data-option-price="{{ $option->prices[$index] ?? 0 }}"
                                               @if($index === 0) checked @endif
                                               required>
                                        <div class="px-4 py-2 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-700 peer-checked:bg-blue-50 hover:border-gray-300 transition">
                                            <span class="font-medium">{{ $choice }}</span>
                                            @if(isset($option->prices[$index]) && $option->prices[$index] > 0)
                                            <span class="text-sm text-gray-500 ml-1">+${{ number_format($option->prices[$index], 2) }}</span>
                                            @endif
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-8 p-4 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-lg font-medium text-gray-700">Total Price:</span>
                                <span id="totalPrice" class="text-3xl font-bold text-blue-700">${{ number_format($product->base_price ?? 0, 2) }}</span>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                                </div>
                                <button type="submit" class="flex-1 py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-semibold">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </form>
                    @else
                    <div class="mb-6">
                        <span class="text-3xl font-bold text-gray-900">{{ $product->formatted_price }}</span>
                    </div>
                    
                    <form action="/cart/add/{{ $product->slug }}" method="POST">
                        @csrf
                        <div class="flex items-center gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                <input type="number" name="quantity" value="1" min="1" class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                            </div>
                            <button type="submit" class="flex-1 py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-semibold">
                                Add to Cart
                            </button>
                        </div>
                    </form>
                    @endif

                    @if($product->sku)
                        <p class="text-sm text-gray-500 mt-4">SKU: {{ $product->sku }}</p>
                    @endif
                </div>
            </div>

            @if($product->description)
            <div class="mt-12">
                <h2 class="text-2xl font-bold mb-4">Product Description</h2>
                <div class="prose max-w-none text-gray-600">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>
            @endif
        </div>

        @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Related Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <a href="/shop/product/{{ $related->slug }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ $related->primary_image }}" alt="{{ $related->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-2">{{ $related->name }}</h3>
                        <p class="text-lg font-bold text-gray-900">{{ $related->formatted_price }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
@if($product->pricingOptions->count() > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    const basePrice = {{ $product->base_price ?? 0 }};
    const quantityInput = document.getElementById('quantity');
    const totalPriceEl = document.getElementById('totalPrice');
    const pricingForm = document.getElementById('pricingForm');
    
    function calculatePrice() {
        let totalPrice = basePrice;
        
        document.querySelectorAll('#pricingOptions input[type="radio"]:checked').forEach(radio => {
            totalPrice += parseFloat(radio.dataset.optionPrice || 0);
        });
        
        const quantity = parseInt(quantityInput.value) || 1;
        totalPrice = totalPrice * quantity;
        
        totalPriceEl.textContent = '$' + totalPrice.toFixed(2);
    }
    
    document.querySelectorAll('#pricingOptions input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', calculatePrice);
    });
    
    quantityInput.addEventListener('input', calculatePrice);
    
    calculatePrice();
});
</script>
@endif
@endpush