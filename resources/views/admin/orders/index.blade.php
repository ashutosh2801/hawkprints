@extends('admin.layout')

@section('page-title', 'Orders')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <form action="/admin/orders" method="GET" class="flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search orders..." class="px-4 py-2 border border-gray-300 rounded-lg">
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">Filter</button>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($orders as $order)
            <tr>
                <td class="px-6 py-4 font-medium">{{ $order->order_number }}</td>
                <td class="px-6 py-4">
                    <p>{{ $order->customer_name }}</p>
                    <p class="text-sm text-gray-500">{{ $order->customer_email }}</p>
                </td>
                <td class="px-6 py-4 font-medium">${{ number_format($order->total, 2) }}</td>
                <td class="px-6 py-4">
                    @php $statusClass = ['pending' => 'yellow', 'processing' => 'blue', 'completed' => 'green', 'cancelled' => 'red']; @endphp
                    <span class="px-2 py-1 text-xs rounded-full bg-{{ $statusClass[$order->status] ?? 'gray' }}-100 text-{{ $statusClass[$order->status] ?? 'gray' }}-800 capitalize">{{ $order->status }}</span>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $order->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4">
                    <a href="/admin/orders/{{ $order->id }}" class="text-blue-600 hover:underline">View</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $orders->links() }}</div>
@endsection