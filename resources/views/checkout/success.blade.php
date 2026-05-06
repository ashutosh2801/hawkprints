@extends('layouts.app')

@section('title', 'Order Confirmed - Hawk Prints')

@section('content')
<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-4 text-center">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">Thank You!</h1>
            <p class="text-gray-600 mb-6">Your order has been placed successfully.</p>

            <div class="bg-gray-100 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-600">Order Number</p>
                <p class="text-2xl font-bold text-gray-900">{{ $order->order_number }}</p>
            </div>

            <div class="text-left mb-6">
                <h3 class="font-semibold mb-3">Order Details</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Customer:</span>
                        <span>{{ $order->customer_name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Email:</span>
                        <span>{{ $order->customer_email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Phone:</span>
                        <span>{{ $order->customer_phone ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping Address:</span>
                        <span>{{ $order->shipping_address ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Payment Method:</span>
                        <span class="uppercase">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Credit Card' }}</span>
                    </div>
                </div>
            </div>

            <div class="text-left mb-6">
                <h3 class="font-semibold mb-3">Order Items</h3>
                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left">Product</th>
                                <th class="px-4 py-2 text-center">Qty</th>
                                <th class="px-4 py-2 text-right">Price</th>
                                <th class="px-4 py-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($order->items as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <p class="font-medium">{{ $item->product_name }}</p>
                                    @if($item->variant_name)
                                    <p class="text-xs text-gray-500">{{ $item->variant_name }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-right">${{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-3 text-right font-medium">${{ number_format($item->quantity * $item->price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right font-medium">Subtotal:</td>
                                <td class="px-4 py-3 text-right">${{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right font-medium">Tax (13%):</td>
                                <td class="px-4 py-3 text-right">${{ number_format($order->tax, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right font-medium">Shipping:</td>
                                <td class="px-4 py-3 text-right">Free</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right font-bold">Total:</td>
                                <td class="px-4 py-3 text-right font-bold">${{ number_format($order->total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <p class="text-sm text-gray-600 mb-6">
                A confirmation email has been sent to {{ $order->customer_email }}.
            </p>

            <div class="space-y-3">
                <a href="{{ route('shop') }}" class="block w-full py-3 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-semibold">
                    Continue Shopping
                </a>
                <a href="{{ route('home') }}" class="block w-full py-3 border border-gray-300 hover:bg-gray-100 rounded-lg font-semibold">
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>
@endsection