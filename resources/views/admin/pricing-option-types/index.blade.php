@extends('admin.layout')

@section('page-title', 'Pricing Option Types')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <!-- <h1 class="text-2xl font-bold">Pricing Option Types</h1> -->
        <form action="{{ route('admin.pricing-option-types.store') }}" method="POST" class="flex gap-2">
            @csrf
            <input type="text" name="name" placeholder="Type name (e.g., Quantity, Size)" required 
                   class="px-4 py-2 border border-gray-300 rounded-lg">
            <input type="text" name="icon" placeholder="Icon class (optional)" 
                   class="px-4 py-2 border border-gray-300 rounded-lg w-32">
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Type
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($types as $type)
                <tr>
                    <td class="px-6 py-4 text-gray-500">{{ $type->sort_order }}</td>
                    <td class="px-6 py-4 font-medium">{{ $type->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $type->slug }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $type->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $type->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <button onclick="editType({{ $type->id }}, '{{ $type->name }}', '{{ $type->icon }}')" 
                                    class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('admin.pricing-option-types.toggle', $type->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition" title="{{ $type->is_active ? 'Disable' : 'Enable' }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </form>
                            <form action="{{ route('admin.pricing-option-types.destroy', $type->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this type?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        No types yet. Add your first type above.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 bg-blue-50 rounded-lg p-4">
        <h3 class="font-semibold mb-2">Available Types</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm text-gray-600">
            <span class="bg-white px-2 py-1 rounded">Quantity</span>
            <span class="bg-white px-2 py-1 rounded">Size</span>
            <span class="bg-white px-2 py-1 rounded">Paper Type</span>
            <span class="bg-white px-2 py-1 rounded">Sided</span>
            <span class="bg-white px-2 py-1 rounded">Finishing</span>
            <span class="bg-white px-2 py-1 rounded">Binding</span>
            <span class="bg-white px-2 py-1 rounded">Lamination</span>
            <span class="bg-white px-2 py-1 rounded">Turnaround</span>
        </div>
    </div>
</div>

<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-bold mb-4">Edit Type</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" id="editName" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Icon (optional)</label>
                <input type="text" name="icon" id="editIcon" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function editType(id, name, icon) {
    document.getElementById('editName').value = name;
    document.getElementById('editIcon').value = icon || '';
    document.getElementById('editForm').action = `/admin/pricing-option-types/${id}`;
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}
</script>
@endpush
@endsection