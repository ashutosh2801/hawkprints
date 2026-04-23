@extends('admin.layout')

@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Products</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['products'] }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
        <a href="/admin/products" class="text-sm text-blue-600 hover:underline mt-2 inline-block">View Products →</a>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Categories</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['categories'] }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>
            </div>
        </div>
        <a href="/admin/categories" class="text-sm text-green-600 hover:underline mt-2 inline-block">View Categories →</a>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Orders</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['orders'] }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
        <a href="/admin/orders" class="text-sm text-purple-600 hover:underline mt-2 inline-block">View Orders →</a>
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Pending Orders</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['ordersPending'] }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <a href="/admin/orders?status=pending" class="text-sm text-yellow-600 hover:underline mt-2 inline-block">View Pending →</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Recent Orders</h2>
        @if($recentOrders->count() > 0)
        <div class="space-y-3">
            @foreach($recentOrders as $order)
            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                <div>
                    <p class="font-medium">{{ $order->order_number }}</p>
                    <p class="text-sm text-gray-500">{{ $order->customer_name }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold">${{ number_format($order->total, 2) }}</p>
                    <span class="text-xs px-2 py-1 rounded @if($order->status == 'pending') bg-yellow-100 text-yellow-700 @elseif($order->status == 'completed') bg-green-100 text-green-700 @else bg-gray-100 text-gray-700 @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        <a href="/admin/orders" class="block text-center text-sm text-blue-600 hover:underline mt-4">View All Orders →</a>
        @else
        <p class="text-gray-500">No orders yet.</p>
        @endif
    </div>
    
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-bold mb-4">Featured Products</h2>
        @if($featuredProducts->count() > 0)
        <div class="grid grid-cols-2 gap-3">
            @foreach($featuredProducts as $product)
            <div class="text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-lg mx-auto mb-2 flex items-center justify-center">
                    <span class="text-xs text-gray-400">No Image</span>
                </div>
                <p class="text-sm font-medium truncate">{{ $product->name }}</p>
                <p class="text-sm text-blue-600">${{ number_format($product->base_price, 2) }}</p>
            </div>
            @endforeach
        </div>
        <a href="/admin/products" class="block text-center text-sm text-blue-600 hover:underline mt-4">Manage Products →</a>
        @else
        <p class="text-gray-500">No featured products.</p>
        @endif
    </div>
</div>
@endsection