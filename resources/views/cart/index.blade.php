@extends('layouts.app')

@section('title', 'Shopping Cart - Five Rivers Print')
@section('robots', 'noindex, nofollow')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-blue-100 text-blue-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Product</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Quantity</th>
                                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-700">Price</th>
                                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-700">Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($cart as $key => $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded">
                                                <div>
                                                    <h3 class="font-medium text-gray-900">{{ $item['name'] }}</h3>
                                                    @if($item['variant_name'])
                                                        <p class="text-sm text-gray-500">{{ $item['variant_name'] }}</p>
                                                    @endif
                                                    @if(!empty($item['pricing_options']))
                                                        @php
                                                            $formattedOptions = App\Services\CartService::getFormattedPricingOptionsFromItem($item['pricing_options']);
                                                        @endphp
                                                        @foreach($formattedOptions as $option)
                                                            <p class="text-sm text-gray-500">{{ $option }}</p>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <button onclick="updateQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})" class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded">-</button>
                                                <input type="number" value="{{ $item['quantity'] }}" min="1" class="w-16 text-center border rounded" onchange="updateQuantity('{{ $key }}', this.value)">
                                                <button onclick="updateQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})" class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded">+</button>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">${{ number_format($item['price'], 2) }}</td>
                                        <td id="line-total-{{ $key }}" class="px-6 py-4 text-right font-medium">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                        <td class="px-6 py-4 text-right">
                                            <button onclick="removeItem('{{ $key }}')" class="text-blue-600 hover:text-blue-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m4-4V7m0 4H4m0 0h16"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold mb-4">Order Summary</h2>

                        <div class="mb-4">
                            <form id="coupon-form" class="flex gap-2">
                                @csrf
                                <input type="text" id="coupon-code" name="code" placeholder="Enter coupon code" class="flex-1 px-3 py-2 border rounded-lg text-sm @if($coupon) bg-gray-100 @endif" @if($coupon) readonly @endif>
                                @if($coupon)
                                    <button type="button" onclick="removeCoupon()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm">Remove</button>
                                @else
                                    <button type="submit" class="px-4 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg text-sm">Apply</button>
                                @endif
                            </form>
                            <p id="coupon-message" class="mt-2 text-sm"></p>
                        </div>

                        <div class="mb-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Shipping Method</h3>
                            <div id="shipping-options" class="space-y-2">
                                @forelse($shippingMethods as $method)
                                <label class="flex items-center justify-between p-3 border rounded-lg cursor-pointer hover:bg-gray-50 shipping-option {{ $selectedShipping && $selectedShipping->name === $method['name'] ? 'border-blue-500 bg-blue-50' : '' }}">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="shipping" value="{{ $method['name'] }}" class="shipping-radio" {{ $selectedShipping && $selectedShipping->name === $method['name'] ? 'checked' : '' }}>
                                        <div>
                                            <span class="font-medium">{{ $method['name'] }}</span>
                                            @if($method['estimated_days'])
                                                <span class="text-sm text-gray-500 ml-2">({{ $method['estimated_days'] }})</span>
                                            @endif
                                            @if($method['description'])
                                                <p class="text-sm text-gray-500">{{ $method['description'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="font-medium">${{ number_format($method['price'], 2) }}</span>
                                </label>
                                @empty
                                <p class="text-sm text-gray-500">No shipping methods available</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span id="cart-subtotal" class="font-medium">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            @if($discount > 0)
                            <div class="flex justify-between text-green-600">
                                <span>Discount</span>
                                <span id="cart-discount" class="font-medium">-${{ number_format($discount, 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span id="shipping-cost" class="font-medium">${{ number_format($shippingCost, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax ({{ number_format($taxRateDisplay, 1) }}%)</span>
                                <span id="cart-tax" class="font-medium">${{ number_format($tax, 2) }}</span>
                            </div>
                            <hr>
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span id="cart-total">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="mt-6 block w-full py-3 bg-blue-700 hover:bg-blue-800 text-white text-center rounded-lg font-semibold">
                            Proceed to Checkout
                        </a>
                        <a href="{{ route('shop') }}" class="mt-4 block text-center text-blue-700 hover:underline">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-700 mb-2">Your cart is empty</h2>
                <p class="text-gray-500 mb-6">Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('shop') }}" class="inline-block px-6 py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-semibold">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function formatPrice(value) {
    return value.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

function updateQuantity(itemKey, quantity) {
    if (quantity < 1) return;

    fetch(`/cart/update/${itemKey}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('cart-subtotal').textContent = '$' + formatPrice(data.subtotal);
            document.getElementById('cart-tax').textContent = '$' + formatPrice(data.tax);
            document.getElementById('cart-total').textContent = '$' + formatPrice(data.total);
            const lineTotalEl = document.getElementById('line-total-' + data.item_key);
            if (lineTotalEl) lineTotalEl.textContent = '$' + formatPrice(data.item_total);
            const discountEl = document.getElementById('cart-discount');
            if (discountEl) discountEl.textContent = '-$' + formatPrice(data.discount);
        }
    });
}

function removeItem(itemKey) {
    if (!confirm('Are you sure you want to remove this item?')) return;

    fetch(`/cart/remove/${itemKey}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

document.getElementById('coupon-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const code = document.getElementById('coupon-code').value.trim();
    if (!code) return;

    fetch('/cart/apply-coupon', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ code: code })
    })
    .then(response => response.json())
    .then(data => {
        const messageEl = document.getElementById('coupon-message');
        if (data.success) {
            messageEl.className = 'mt-2 text-sm text-green-600';
            messageEl.textContent = 'Coupon applied successfully!';
            location.reload();
        } else {
            messageEl.className = 'mt-2 text-sm text-red-600';
            messageEl.textContent = data.message || 'Invalid coupon';
        }
    });
});

function removeCoupon() {
    fetch('/cart/remove-coupon', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

document.querySelectorAll('.shipping-option input[type="radio"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        const method = this.value;
        
        document.querySelectorAll('.shipping-option').forEach(function(el) {
            el.classList.remove('border-blue-500', 'bg-blue-50');
        });
        this.closest('.shipping-option').classList.add('border-blue-500', 'bg-blue-50');

        fetch('/cart/set-shipping', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ method: method })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('cart-subtotal').textContent = '$' + formatPrice(data.subtotal);
                document.getElementById('shipping-cost').textContent = '$' + formatPrice(data.shipping_cost);
                document.getElementById('cart-tax').textContent = '$' + formatPrice(data.tax);
                document.getElementById('cart-total').textContent = '$' + formatPrice(data.total);
            }
        });
    });
});
</script>
@endpush