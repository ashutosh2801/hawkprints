@extends('admin.layout')

@section('page-title', 'Shipping Methods - Five Rivers Print')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Shipping Methods</h1>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Est. Days</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($methods as $method)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $method->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $method->description ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">${{ number_format($method->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $method->estimated_days ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.shipping-methods.toggle', $method) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="relative inline-flex items-center h-6 w-11 rounded-full transition-colors focus:outline-none {{ $method->is_active ? 'bg-green-500' : 'bg-gray-300' }}">
                                        <span class="inline-block h-4 w-4 rounded-full bg-white shadow transform transition-transform {{ $method->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex items-center gap-2">
                                    <button onclick="editMethod({{ $method->id }}, '{{ addslashes($method->name) }}', '{{ addslashes($method->description ?? '') }}', {{ $method->price }}, '{{ $method->estimated_days ?? '' }}', {{ $method->min_order_amount ?? 'null' }}, {{ $method->max_order_amount ?? 'null' }}, {{ $method->sort_order }}, {{ $method->is_active ? 'true' : 'false' }})" class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form action="{{ route('admin.shipping-methods.destroy', $method) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Delete this shipping method?')" class="inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No shipping methods found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-bold mb-4">Add New Shipping Method</h2>
                <form action="{{ route('admin.shipping-methods.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="name" required class="w-full px-3 py-2 border rounded-lg" placeholder="Standard Shipping">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <input type="text" name="description" class="w-full px-3 py-2 border rounded-lg" placeholder="Optional description">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                            <input type="number" name="price" step="0.01" min="0" required class="w-full px-3 py-2 border rounded-lg" placeholder="9.99">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Days</label>
                            <input type="text" name="estimated_days" class="w-full px-3 py-2 border rounded-lg" placeholder="5-7 days">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Min Order Amount</label>
                            <input type="number" name="min_order_amount" step="0.01" min="0" class="w-full px-3 py-2 border rounded-lg" placeholder="Optional">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Max Order Amount</label>
                            <input type="number" name="max_order_amount" step="0.01" min="0" class="w-full px-3 py-2 border rounded-lg" placeholder="Optional">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                            <input type="number" name="sort_order" min="0" class="w-full px-3 py-2 border rounded-lg" placeholder="0">
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1" checked class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
                        </div>
                        <button type="submit" class="w-full py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-medium">Add Shipping Method</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
        <h3 class="text-lg font-bold mb-4">Edit Shipping Method</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" id="edit-name" readonly class="w-full px-3 py-2 border rounded-lg bg-gray-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <input type="text" id="edit-description" name="description" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                    <input type="number" id="edit-price" name="price" step="0.01" min="0" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Days</label>
                    <input type="text" id="edit-days" name="estimated_days" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Min Order Amount</label>
                    <input type="number" id="edit-min" name="min_order_amount" step="0.01" min="0" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Order Amount</label>
                    <input type="number" id="edit-max" name="max_order_amount" step="0.01" min="0" class="w-full px-3 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                    <input type="number" id="edit-sort" name="sort_order" min="0" class="w-full px-3 py-2 border rounded-lg">
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
function editMethod(id, name, description, price, days, minOrder, maxOrder, sort, active) {
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-description').value = description;
    document.getElementById('edit-price').value = price;
    document.getElementById('edit-days').value = days;
    document.getElementById('edit-min').value = minOrder || '';
    document.getElementById('edit-max').value = maxOrder || '';
    document.getElementById('edit-sort').value = sort || 0;
    document.getElementById('edit-active').checked = active;
    document.getElementById('editForm').action = '/admin/shipping-methods/' + id;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
@endpush