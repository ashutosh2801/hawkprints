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
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
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

<div class="mt-6">
    <a href="/admin/orders" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Back to Orders</a>
</div>
@endsection