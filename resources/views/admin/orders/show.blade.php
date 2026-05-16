@extends('admin.layout')

@section('page-title', 'Order ' . $order->order_number)

@section('content')
<div class="grid grid-cols-2 gap-6">
    <div>
        <h3 class="text-lg font-medium mb-4">Customer Information</h3>
        <div class="bg-white rounded-lg shadow p-6">
            <p><strong>Name:</strong> {{ $order->customer_name }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer_phone ?? '-' }}</p>
            <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
        </div>
    </div>
    
    <div>
        <h3 class="text-lg font-medium mb-4">Order Status</h3>
        <div class="bg-white rounded-lg shadow p-6">
            <form action="/admin/orders/{{ $order->id }}/status" method="POST" class="flex gap-4">
                @csrf @method('PUT')
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">Update</button>
            </form>
        </div>
    </div>
</div>

<h3 class="text-lg font-medium mt-6 mb-4">Order Items</h3>
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($order->items as $item)
            <tr>
                <td class="px-6 py-4">
                    <p class="font-medium">{{ $item->product_name }}</p>
                    @if($item->options)
                    <p class="text-sm text-gray-500">{{ $item->options }}</p>
                    @endif
                </td>
                <td class="px-6 py-4">{{ $item->quantity }}</td>
                <td class="px-6 py-4">${{ number_format($item->price, 2) }}</td>
                <td class="px-6 py-4 font-medium">${{ number_format($item->quantity * $item->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot class="bg-gray-50">
            <tr>
                <td colspan="3" class="px-6 py-4 text-right font-medium">Total:</td>
                <td class="px-6 py-4 font-medium">${{ number_format($order->total, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</div>

<div class="mt-6 flex gap-4 items-center">
    <a href="/admin/orders" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Back to Orders</a>
    <a href="/admin/orders/{{ $order->id }}/invoice" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        Download Invoice
    </a>
    <form action="/admin/orders/{{ $order->id }}/send-invoice" method="POST" class="inline">
        @csrf
        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            Send Invoice to Customer
        </button>
    </form>
</div>
@endsection