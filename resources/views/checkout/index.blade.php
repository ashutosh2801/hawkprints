@extends('layouts.app')

@section('title', 'Checkout - Hawk Prints')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm" novalidate>
            @csrf
            <input type="hidden" name="payment_intent_id" id="paymentIntentId" value="">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <p class="font-medium">Please fill in all required fields:</p>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <!-- Create Account Section (for guest users) -->
                    @guest
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg shadow-lg p-6 border border-blue-100">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h2 class="text-xl font-bold text-blue-900 mb-1">Create an Account</h2>
                                <p class="text-sm text-gray-600 mb-4">Create an account to track your orders, save your addresses, and get exclusive offers!</p>
                                
                                <label class="flex items-center gap-2 mb-4 cursor-pointer">
                                    <input type="checkbox" name="create_account" value="1" id="createAccountCheckbox" class="w-5 h-5 text-blue-700 rounded border-gray-300 focus:ring-blue-700">
                                    <span class="text-sm font-medium text-gray-700">Yes, I want to create an account</span>
                                </label>
                                
                                <div id="passwordFields" class="hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                        <input type="password" name="password" placeholder="Create a password (min 8 characters)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                        <input type="password" name="password_confirmation" placeholder="Confirm your password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex flex-wrap gap-4 text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Track your orders
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Save your addresses
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Faster checkout
                            </div>
                        </div>
                    </div>
                    @endguest

                    <!-- Already logged in -->
                    @auth
                    <div class="bg-green-50 rounded-lg shadow-lg p-4 border border-green-200">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="font-medium text-green-800">Logged in as {{ auth()->user()->email }}</span>
                        </div>
                    </div>
                    @endauth

                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold mb-4">Contact Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" name="customer_name" value="{{ auth()->user()->name ?? old('customer_name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700 @error('customer_name') border-red-500 @enderror">
                                @error('customer_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" name="customer_email" value="{{ auth()->user()->email ?? old('customer_email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700 @error('customer_email') border-red-500 @enderror">
                                @error('customer_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="(555) 123-4567" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                            </div>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold mb-4">Billing Address</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Street Address *</label>
                <input type="text" name="billing_address" id="billing_address" value="{{ old('billing_address') }}" placeholder="123 Main St" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                @error('billing_address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
<div>
                <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                <input type="text" name="billing_city" id="billing_city" value="{{ old('billing_city') }}" placeholder="Brampton" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                @error('billing_city')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Province *</label>
                <input type="text" name="billing_province" id="billing_province" value="{{ old('billing_province') }}" placeholder="Ontario" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                @error('billing_province')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code *</label>
                <input type="text" name="billing_postal" id="billing_postal" value="{{ old('billing_postal') }}" placeholder="L6P 3K9" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                @error('billing_postal')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
<div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                <select name="billing_country" id="billing_country" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                    <option value="Canada">Canada</option>
                    <option value="United States">United States</option>
                </select>
                @error('billing_country')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-bold">Shipping Address</h2>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="same_address" value="1" id="sameAddressCheckbox" class="w-4 h-4 text-blue-700 rounded border-gray-300 focus:ring-blue-700" onchange="toggleSameAddress()">
                                <span class="text-sm text-gray-600">Same as billing</span>
                            </label>
                        </div>
                        
                        <div id="shippingFields" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Street Address *</label>
                                <input type="text" name="shipping_address" id="shipping_address" value="{{ old('shipping_address') }}" placeholder="123 Main St" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                                @error('shipping_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                <input type="text" name="shipping_city" id="shipping_city" value="{{ old('shipping_city') }}" placeholder="Brampton" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Province *</label>
                                <input type="text" name="shipping_province" id="shipping_province" value="{{ old('shipping_province') }}" placeholder="Ontario" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                                @error('shipping_province')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code *</label>
                                <input type="text" name="shipping_postal" id="shipping_postal" value="{{ old('shipping_postal') }}" placeholder="L6P 3K9" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                                <select name="shipping_country" id="shipping_country" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                                    <option value="Canada">Canada</option>
                                    <option value="United States">United States</option>
                                </select>
                                @error('shipping_country')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold mb-4">Order Notes</h2>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Special Instructions</label>
                            <textarea name="notes" rows="3" placeholder="Any special instructions for your order..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div>
                    <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24">
                        <h2 class="text-xl font-bold mb-4">Order Summary</h2>

                        <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                            @foreach($cart as $key => $item)
                                <div class="flex gap-3">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-14 h-14 object-cover rounded">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-medium text-sm truncate">{{ $item['name'] }}</h3>
                                        @if($item['variant_name'])
                                            <p class="text-xs text-gray-500">{{ $item['variant_name'] }}</p>
                                        @endif
                                        @if(!empty($item['pricing_options']))
                                            @php
                                                $formattedOptions = App\Services\CartService::getFormattedPricingOptionsFromItem($item['pricing_options']);
                                            @endphp
                                            @foreach($formattedOptions as $option)
                                                <p class="text-xs text-gray-500">{{ $option }}</p>
                                            @endforeach
                                        @endif
                                        <p class="text-xs text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                    </div>
                                    <p class="font-medium text-sm">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax (13%)</span>
                                <span class="font-medium">${{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                @if($shippingCost > 0)
                                    <span class="font-medium">${{ number_format($shippingCost, 2) }}</span>
                                @else
                                    <span class="font-medium text-green-600">Free</span>
                                @endif
                            </div>
                            <hr>
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-blue-700">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        @if($stripeEnabled || $codEnabled)
                        <div class="mt-6">
                            <h3 class="font-medium text-gray-900 mb-3">Payment Method</h3>
                            <div class="space-y-3">
                                @if($codEnabled)
                                <label class="flex items-start gap-3 p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition {{ !$stripeEnabled ? 'border-blue-300 bg-blue-50' : '' }}">
                                    <input type="radio" name="payment_method" value="cod" class="w-4 h-4 mt-1 text-blue-700 border-gray-300 focus:ring-blue-700" {{ !$stripeEnabled ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <span class="font-medium text-gray-900">Cash on Delivery</span>
                                        <p class="text-sm text-gray-500">Pay when you receive your order</p>
                                    </div>
                                </label>
                                @endif
                                @if($stripeEnabled)
                                <label class="flex items-start gap-3 p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition {{ !$codEnabled ? 'border-blue-300 bg-blue-50' : '' }}">
                                    <input type="radio" name="payment_method" value="stripe" class="w-4 h-4 mt-1 text-blue-700 border-gray-300 focus:ring-blue-700" {{ !$codEnabled ? 'checked' : '' }}>
                                    <div class="flex-1">
                                        <span class="font-medium text-gray-900">Credit Card</span>
                                        <p class="text-sm text-gray-500">Pay securely with Stripe</p>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-8 h-5" viewBox="0 0 32 20"><rect width="32" height="20" rx="3" fill="#1A1F71"/><path d="M12.5 13.5h-1.8l1.1-6h1.8l-1.1 6z" fill="#fff"/><path d="M8 7.5L6.5 10l-.3-1.5H4.5l2.3 6h1.8L11 7.5H8z" fill="#F7B600"/><path d="M18.5 7.5c-.3-.1-1-.3-1.8-.3-2 0-3.4 1-3.4 2.5 0 1.1 1 1.7 1.7 2 .7.3 1 .5 1 .8 0 .4-.5.6-1 .6-.7 0-1.1-.1-1.7-.4l-.2-.1-.5 1.7c.4.2 1.2.4 2 .4 2.1 0 3.5-1 3.5-2.6 0-.9-.6-1.5-1.7-2-.7-.3-1.1-.5-1.1-.8 0-.3.4-.6 1-.6.6 0 1 .1 1.4.3l.2.1.5-1.6z" fill="#fff"/><path d="M22.5 7.5h-1.4c-.4 0-.7.1-.9.4l-2.6 6h1.9l.4-1h2.3l.2 1h1.7l-1.6-6.4zm-1.4 3.8l.7-2 .5 2h-1.2z" fill="#fff"/><path d="M26 7.5l-.8 4.4-.5-2.4c-.3-.9-.8-1.8-1.4-2.4l1.5 5.4h1.9l.8-5h-1.5z" fill="#fff"/></svg>
                                    </div>
                                </label>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($stripeEnabled)
                        <div id="stripePaymentSection" class="mt-4 p-4 border rounded-lg bg-gray-50 hidden">
                            <h4 class="font-medium text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Card Details
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Card Number</label>
                                    <div id="cardNumberElement" class="px-3 py-2 border border-gray-300 rounded-lg bg-white focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500"></div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                        <div id="cardExpiryElement" class="px-3 py-2 border border-gray-300 rounded-lg bg-white focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500"></div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">CVC</label>
                                        <div id="cardCvcElement" class="px-3 py-2 border border-gray-300 rounded-lg bg-white focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500"></div>
                                    </div>
                                </div>
                            </div>
                            <p id="cardErrors" class="text-red-500 text-sm mt-3 hidden"></p>
                        </div>
                        @endif

                        <button type="submit" id="submitBtn" class="mt-4 w-full py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-semibold flex items-center justify-center gap-2 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span id="submitBtnText">Place Order</span>
                        </button>

                        <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Secure checkout
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
const stripeEnabled = '{{ $stripeEnabled }}' === '1';
const stripePublishableKey = '{{ $stripePublishableKey }}';
let stripe = null;
let cardElement = null;
let paymentIntentClientSecret = null;
let isStripeSelected = false;

async function createPaymentIntent() {
    const response = await fetch('{{ route("checkout.create-payment-intent") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({})
    });
    const data = await response.json();
    return data.clientSecret;
}

function showCardError(message) {
    const errorEl = document.getElementById('cardErrors');
    errorEl.textContent = message;
    errorEl.classList.remove('hidden');
}

function hideCardError() {
    const errorEl = document.getElementById('cardErrors');
    errorEl.textContent = '';
    errorEl.classList.add('hidden');
}

function setLoading(loading) {
    const btn = document.getElementById('submitBtn');
    const btnText = document.getElementById('submitBtnText');
    if (loading) {
        btn.disabled = true;
        btn.classList.add('opacity-75', 'cursor-not-allowed');
        btnText.innerHTML = '<svg class="animate-spin w-5 h-5 inline mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
    } else {
        btn.disabled = false;
        btn.classList.remove('opacity-75', 'cursor-not-allowed');
        btnText.innerHTML = '<svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Place Order';
    }
}

async function initStripe() {
    if (!stripeEnabled || !stripePublishableKey) return;
    
    stripe = Stripe(stripePublishableKey);
    paymentIntentClientSecret = await createPaymentIntent();
    
    const elements = stripe.elements({
        clientSecret: paymentIntentClientSecret,
        appearance: {
            theme: 'flat',
            variables: {
                colorPrimary: '#1d4ed8',
                colorText: '#374151',
                colorDanger: '#dc2626',
                fontFamily: 'system-ui, -apple-system, sans-serif',
                spacingUnit: '4px',
                borderRadius: '8px',
            }
        }
    });
    
    const style = {
        base: {
            fontSize: '15px',
            color: '#374151',
            fontFamily: 'system-ui, -apple-system, sans-serif',
            '::placeholder': {
                color: '#9ca3af',
            },
        },
        invalid: {
            color: '#dc2626',
        },
    };
    
    cardElement = elements.create('cardNumber', { style: style, showIcon: true });
    cardElement.mount('#cardNumberElement');
    
    const expiryElement = elements.create('cardExpiry', { style: style });
    expiryElement.mount('#cardExpiryElement');
    
    const cvcElement = elements.create('cardCvc', { style: style });
    cvcElement.mount('#cardCvcElement');
    
    cardElement.on('change', function(event) {
        if (event.error) {
            showCardError(event.error.message);
        } else {
            hideCardError();
        }
    });
}

async function handleStripePayment() {
    setLoading(true);
    hideCardError();
    
    const { error, paymentIntent } = await stripe.confirmCardPayment(paymentIntentClientSecret, {
        payment_method: {
            card: cardElement,
        }
    });
    
    if (error) {
        showCardError(error.message);
        setLoading(false);
        return null;
    }
    
    if (paymentIntent && paymentIntent.status === 'succeeded') {
        return paymentIntent.id;
    }
    
    setLoading(false);
    return null;
}

document.addEventListener('DOMContentLoaded', function() {
    const checkoutForm = document.getElementById('checkoutForm');
    const stripePaymentSection = document.getElementById('stripePaymentSection');
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const sameAddressCheckbox = document.getElementById('sameAddressCheckbox');
    const shippingFields = document.getElementById('shippingFields');
    const createAccountCheckbox = document.getElementById('createAccountCheckbox');
    const passwordFields = document.getElementById('passwordFields');
    
    function updatePaymentSection() {
        const selectedRadio = document.querySelector('input[name="payment_method"]:checked');
        isStripeSelected = selectedRadio && selectedRadio.value === 'stripe';
        
        if (isStripeSelected && stripePaymentSection) {
            stripePaymentSection.classList.remove('hidden');
        } else if (stripePaymentSection) {
            stripePaymentSection.classList.add('hidden');
        }
        
        paymentRadios.forEach(radio => {
            const label = radio.closest('label');
            if (radio.checked) {
                label.classList.add('border-blue-300', 'bg-blue-50');
            } else {
                label.classList.remove('border-blue-300', 'bg-blue-50');
            }
        });
    }
    
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', updatePaymentSection);
    });
    
    updatePaymentSection();
    
    if (stripeEnabled && stripePublishableKey) {
        initStripe();
    }
    
    checkoutForm.addEventListener('submit', async function(e) {
        if (isStripeSelected && stripe) {
            e.preventDefault();
            hideCardError();
            
            const paymentIntentId = await handleStripePayment();
            
            if (paymentIntentId) {
                document.getElementById('paymentIntentId').value = paymentIntentId;
            } else {
                return;
            }
        }
        
        if (sameAddressCheckbox && sameAddressCheckbox.checked) {
            document.getElementById('shipping_address').value = document.getElementById('billing_address').value;
            document.getElementById('shipping_city').value = document.getElementById('billing_city').value;
            document.getElementById('shipping_province').value = document.getElementById('billing_province').value;
            document.getElementById('shipping_postal').value = document.getElementById('billing_postal').value;
            document.getElementById('shipping_country').value = document.getElementById('billing_country').value;
        }
    });
    
    if (createAccountCheckbox && passwordFields) {
        createAccountCheckbox.addEventListener('change', function() {
            if (this.checked) {
                passwordFields.classList.remove('hidden');
                passwordFields.querySelectorAll('input').forEach(input => input.required = true);
            } else {
                passwordFields.classList.add('hidden');
                passwordFields.querySelectorAll('input').forEach(input => {
                    input.required = false;
                    input.value = '';
                });
            }
        });
    }
    
    if (sameAddressCheckbox && shippingFields) {
        function toggleShippingFields() {
            if (sameAddressCheckbox.checked) {
                shippingFields.style.opacity = '0.5';
                shippingFields.style.pointerEvents = 'none';
                syncBillingToShipping();
            } else {
                shippingFields.style.opacity = '1';
                shippingFields.style.pointerEvents = 'auto';
            }
        }
        
        function syncBillingToShipping() {
            if (!sameAddressCheckbox.checked) return;
            document.querySelector('[name="shipping_address"]').value = document.querySelector('[name="billing_address"]').value;
            document.querySelector('[name="shipping_city"]').value = document.querySelector('[name="billing_city"]').value;
            document.querySelector('[name="shipping_province"]').value = document.querySelector('[name="billing_province"]').value;
            document.querySelector('[name="shipping_postal"]').value = document.querySelector('[name="billing_postal"]').value;
            document.querySelector('[name="shipping_country"]').value = document.querySelector('[name="billing_country"]').value;
        }
        
        sameAddressCheckbox.addEventListener('change', toggleShippingFields);
        
        if (sameAddressCheckbox.checked) {
            syncBillingToShipping();
        }
        
        const billingToShipping = {
            'billing_address': 'shipping_address',
            'billing_city': 'shipping_city',
            'billing_province': 'shipping_province',
            'billing_postal': 'shipping_postal',
            'billing_country': 'shipping_country'
        };
        
        Object.keys(billingToShipping).forEach(billingField => {
            const billingInput = document.querySelector('[name="' + billingField + '"]');
            const shippingInput = document.querySelector('[name="' + billingToShipping[billingField] + '"]');
            if (billingInput && shippingInput) {
                billingInput.addEventListener('input', syncBillingToShipping);
                billingInput.addEventListener('change', syncBillingToShipping);
            }
        });
    }
});
</script>
@endpush