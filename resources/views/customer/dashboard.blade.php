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
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-bold mb-4">Welcome, {{ auth()->user()->name }}!</h2>
                    <p class="text-gray-600">Manage your orders, update your profile, and more from your dashboard.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100">Total Orders</p>
                                <p class="text-3xl font-bold mt-1">{{ $orders->total() }}</p>
                            </div>
                            <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100">Completed</p>
                                <p class="text-3xl font-bold mt-1">{{ $orders->where('status', 'completed')->count() }}</p>
                            </div>
                            <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100">In Progress</p>
                                <p class="text-3xl font-bold mt-1">{{ $orders->whereIn('status', ['pending', 'processing'])->count() }}</p>
                            </div>
                            <svg class="w-12 h-12 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold mb-4">Recent Orders</h3>
                    @if($orders->isEmpty())
                        <p class="text-gray-500 text-center py-8">No orders yet. <a href="{{ route('shop') }}" class="text-blue-600 hover:underline">Start shopping</a></p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-3 px-4">Order #</th>
                                        <th class="text-left py-3 px-4">Date</th>
                                        <th class="text-left py-3 px-4">Status</th>
                                        <th class="text-right py-3 px-4">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders->take(5) as $order)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-4">
                                            <a href="{{ route('orders.detail', $order->order_number) }}" class="text-blue-600 hover:underline font-medium">
                                                {{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td class="py-3 px-4 text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="py-3 px-4">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'processing' => 'bg-blue-100 text-blue-800',
                                                    'shipped' => 'bg-purple-100 text-purple-800',
                                                    'completed' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                ];
                                            @endphp
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusClasses[$order->status] ?? 'bg-gray-100' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-right font-semibold">{{ $order->formatted_total }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($orders->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('orders') }}" class="text-blue-600 hover:underline">View all orders</a>
                            </div>
                        @endif
                    @endif
                </div>
            </main>
        </div>
    </div>
</div>
@endsection