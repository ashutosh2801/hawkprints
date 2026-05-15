@extends('admin.layout')

@section('page-title', 'Categories')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <form action="/admin/categories" method="GET" class="flex gap-4 items-end">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..." class="px-4 py-2 border border-gray-300 rounded-lg">
        <select name="has_image" class="px-4 py-2 border border-gray-300 rounded-lg">
            <option value="">All Categories</option>
            <option value="yes" {{ request('has_image') == 'yes' ? 'selected' : '' }}>With Image</option>
            <option value="no" {{ request('has_image') == 'no' ? 'selected' : '' }}>Without Image</option>
        </select>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Per page</label>
            <select name="per_page" class="px-3 py-2 border border-gray-300 rounded-lg text-sm" onchange="this.form.submit()">
                <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>20</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                <option value="200" {{ request('per_page') == 200 ? 'selected' : '' }}>200</option>
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">Filter</button>
    </form>
    <div class="flex items-center gap-3">
        <button id="bulk-delete-btn" class="hidden px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm" onclick="bulkDelete()">
            Delete Selected (<span id="selected-count">0</span>)
        </button>
        <a href="/admin/categories/create" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Add Category
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase w-12">
                    <input type="checkbox" id="select-all" class="w-4 h-4 rounded border-gray-300" onclick="toggleAll(this)">
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($categories as $category)
            <tr>
                <td class="px-6 py-4">
                    <input type="checkbox" value="{{ $category->id }}" class="category-checkbox w-4 h-4 rounded border-gray-300" onchange="updateBulkDeleteBtn()">
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        @if($category->image)
                        <img src="{{ $category->image }}" alt="" class="w-12 h-12 object-cover rounded-lg mr-4">
                        @else
                        <div class="w-12 h-12 bg-gray-100 rounded-lg mr-4"></div>
                        @endif
                        <div>
                            <p class="font-medium">{{ $category->name }}</p>
                            <p class="text-sm text-gray-500">{{ $category->slug }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $category->products_count ?? 0 }}</td>
                <td class="px-6 py-4">
                    @if($category->is_active)
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-green-50 text-green-700 text-xs font-medium rounded-full">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Active
                    </span>
                    @else
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Inactive
                    </span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="/admin/categories/{{ $category->id }}/edit" class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="/admin/categories/{{ $category->id }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Delete" onclick="return confirm('Delete this category?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<form id="bulk-delete-form" action="/admin/categories/bulk-delete" method="POST" class="hidden">@csrf</form>

<div class="mt-4">{{ $categories->links() }}</div>

<script>
function toggleAll(source) {
    document.querySelectorAll('.category-checkbox').forEach(cb => cb.checked = source.checked);
    updateBulkDeleteBtn();
}
function updateBulkDeleteBtn() {
    const checked = document.querySelectorAll('.category-checkbox:checked').length;
    document.getElementById('bulk-delete-btn').classList.toggle('hidden', checked === 0);
    document.getElementById('selected-count').textContent = checked;
}
function bulkDelete() {
    const checked = document.querySelectorAll('.category-checkbox:checked');
    if (checked.length === 0) return;
    if (!confirm('Delete ' + checked.length + ' selected categories? This cannot be undone.')) return;
    const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const form = document.getElementById('bulk-delete-form');
    form.innerHTML = '<input type="hidden" name="_token" value="' + token + '">';
    checked.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'category_ids[]';
        input.value = cb.value;
        form.appendChild(input);
    });
    form.submit();
}
</script>
@endsection