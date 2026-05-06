@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <aside class="lg:w-64">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b">
                        <div class="w-12 h-12 bg-blue-700 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="font-semibold">{{ auth()->user()->name }}</h3>
                            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    
                    <nav class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>
                        <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('profile') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            My Profile
                        </a>
                        <a href="{{ route('orders') }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('orders') || request()->routeIs('orders.detail') ? 'bg-blue-50 text-blue-700' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            My Orders
                        </a>
                        <form action="{{ route('customer.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </aside>

            <main class="flex-1">
                <div class="mb-6">
                    <a href="{{ route('orders') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back to Orders
                    </a>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex flex-wrap justify-between items-start gap-4 mb-6 border-b pb-6">
                        <div>
                            <h2 class="text-2xl font-bold">Order {{ $order->order_number }}</h2>
                            <p class="text-gray-500 mt-1">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'shipped' => 'bg-purple-100 text-purple-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusClasses[$order->status] ?? 'bg-gray-100' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="font-semibold mb-3">Order Details</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span>${{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax:</span>
                                    <span>${{ number_format($order->tax, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping:</span>
                                    <span>${{ number_format($order->shipping, 2) }}</span>
                                </div>
                                <div class="flex justify-between font-bold text-lg border-t pt-2 mt-2">
                                    <span>Total:</span>
                                    <span>{{ $order->formatted_total }}</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold mb-3">Contact Information</h3>
                            <div class="text-sm space-y-1">
                                <p><span class="text-gray-600">Name:</span> {{ $order->customer_name }}</p>
                                <p><span class="text-gray-600">Email:</span> {{ $order->customer_email }}</p>
                                @if($order->customer_phone)
                                    <p><span class="text-gray-600">Phone:</span> {{ $order->customer_phone }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold mb-4">Order Items</h3>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-4 border-b pb-4 last:border-0">
                            <div class="w-16 h-16 bg-gray-100 rounded flex items-center justify-center">
                                @if($item->image)
                                    <img src="{{ $item->image }}" alt="{{ $item->product_name }}" class="w-full h-full object-contain">
                                @else
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium">{{ $item->product_name }}</h4>
                                @if($item->variant_name)
                                    <p class="text-sm text-gray-500">{{ $item->variant_name }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="font-medium">${{ number_format($item->price, 2) }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                            <div class="text-right font-semibold">
                                ${{ number_format($item->subtotal, 2) }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
@endsection