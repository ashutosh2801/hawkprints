@extends('admin.layout')

@section('page-title', 'Coupons - Hawk Prints')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Coupons</h1>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Min Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Uses</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($coupons as $coupon)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-mono font-bold text-blue-600">{{ $coupon->code }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded {{ $coupon->type === 'percentage' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($coupon->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                @if($coupon->type === 'percentage')
                                    {{ $coupon->value }}%
                                @else
                                    ${{ number_format($coupon->value, 2) }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                @if($coupon->min_order_amount)
                                    ${{ number_format($coupon->min_order_amount, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                {{ $coupon->uses }}@if($coupon->max_uses)/{{ $coupon->max_uses }}@endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.coupons.toggle', $coupon) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="relative inline-flex items-center h-6 w-11 rounded-full transition-colors focus:outline-none {{ $coupon->is_active ? 'bg-green-500' : 'bg-gray-300' }}">
                                        <span class="inline-block h-4 w-4 rounded-full bg-white shadow transform transition-transform {{ $coupon->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <button onclick="editCoupon({{ $coupon->id }}, '{{ $coupon->code }}', '{{ $coupon->type }}', {{ $coupon->value }}, {{ $coupon->min_order_amount ?? 'null' }}, {{ $coupon->max_uses ?? 'null' }}, '{{ $coupon->starts_at ?? '' }}', '{{ $coupon->expires_at ?? '' }}', {{ $coupon->is_active ? 'true' : 'false' }})" class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this coupon?')" class="inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">No coupons found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold mb-4">Create New Coupon</h2>
                <form action="{{ route('admin.coupons.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
                            <input type="text" name="code" required class="w-full px-3 py-2 border rounded-lg font-mono uppercase" placeholder="WELCOME10">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select name="type" required class="w-full px-3 py-2 border rounded-lg">
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed Amount ($)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                            <input type="number" name="value" step="0.01" min="0" required class="w-full px-3 py-2 border rounded-lg" placeholder="10">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Order Amount</label>
                            <input type="number" name="min_order_amount" step="0.01" min="0" class="w-full px-3 py-2 border rounded-lg" placeholder="Optional">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Uses</label>
                            <input type="number" name="max_uses" min="1" class="w-full px-3 py-2 border rounded-lg" placeholder="Optional">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                            <input type="datetime-local" name="starts_at" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                            <input type="datetime-local" name="expires_at" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
                        </div>
                        <button type="submit" class="w-full py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-medium">Create Coupon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-bold mb-4">Edit Coupon</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Code</label>
                    <input type="text" id="edit-code" readonly class="w-full px-3 py-2 border rounded-lg bg-gray-100 font-mono uppercase">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" id="edit-type" required class="w-full px-3 py-2 border rounded-lg">
                        <option value="percentage">Percentage (%)</option>
                        <option value="fixed">Fixed Amount ($)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                    <input type="number" name="value" id="edit-value" step="0.01" min="0" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Min Order Amount</label>
                    <input type="number" name="min_order_amount" id="edit-min" step="0.01" min="0" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Uses</label>
                    <input type="number" name="max_uses" id="edit-max" min="1" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="datetime-local" name="starts_at" id="edit-start" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                    <input type="datetime-local" name="expires_at" id="edit-expires" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="edit-active" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="edit-active" class="ml-2 text-sm text-gray-700">Active</label>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeEditModal()" class="flex-1 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium">Cancel</button>
                    <button type="submit" class="flex-1 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-medium">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function editCoupon(id, code, type, value, minOrder, maxUses, startsAt, expiresAt, isActive) {
    document.getElementById('edit-code').value = code;
    document.getElementById('edit-type').value = type;
    document.getElementById('edit-value').value = value;
    document.getElementById('edit-min').value = minOrder || '';
    document.getElementById('edit-max').value = maxUses || '';
    document.getElementById('edit-start').value = startsAt ? startsAt.replace(' ', 'T') : '';
    document.getElementById('edit-expires').value = expiresAt ? expiresAt.replace(' ', 'T') : '';
    document.getElementById('edit-active').checked = isActive;
    document.getElementById('editForm').action = '/admin/coupons/' + id;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
@endpush