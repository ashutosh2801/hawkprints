@extends('layouts.app')

@section('title', 'Checkout - Hawk Prints')

@section('content')
<div class="bg-gray-100 py-8">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-8">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold mb-4">Contact Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                <input type="text" name="customer_name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" name="customer_email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="text" name="customer_phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold mb-4">Billing Address</h2>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <textarea name="billing_address" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700"></textarea>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-xl font-bold mb-4">Order Notes</h2>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Special Instructions</label>
                            <textarea name="notes" rows="3" placeholder="Any special instructions for your order..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-700"></textarea>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="bg-white rounded-lg shadow-lg p-6 sticky top-24">
                        <h2 class="text-xl font-bold mb-4">Order Summary</h2>

                        <div class="space-y-4 mb-6">
                            @foreach($cart as $key => $item)
                                <div class="flex gap-4">
                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded">
                                    <div class="flex-1">
                                        <h3 class="font-medium text-sm">{{ $item['name'] }}</h3>
                                        @if($item['variant_name'])
                                            <p class="text-xs text-gray-500">{{ $item['variant_name'] }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                    </div>
                                    <p class="font-medium">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax (13%)</span>
                                <span class="font-medium">${{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium">Free</span>
                            </div>
                            <hr>
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <button type="submit" class="mt-6 w-full py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-semibold">
                            Place Order
                        </button>

                        <p class="mt-4 text-xs text-gray-500 text-center">
                            By placing this order, you agree to our Terms & Conditions.
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection