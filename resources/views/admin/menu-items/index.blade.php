@extends('admin.layout')

@section('page-title', 'Menu Items')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
        @endif

        <div x-data="{ showForm: false }">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Manage Menu Items</h2>
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('admin.menu-items') }}" class="flex items-center gap-2">
                    <label class="text-sm text-gray-600">Filter:</label>
                    <select name="location" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="header" {{ $currentLocation === 'header' ? 'selected' : '' }}>Header Navigation</option>
                        <option value="footer" {{ $currentLocation === 'footer' ? 'selected' : '' }}>Footer</option>
                    </select>
                </form>
                <button @click="showForm = !showForm" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium transition" x-text="showForm ? 'Cancel' : '+ Add New Menu'"></button>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.menu-items.store') }}" x-show="showForm" x-cloak class="mb-8 p-4 bg-gray-50 rounded-lg">
            @csrf
            <h3 class="font-medium mb-4">Add New Menu Item</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Type</label>
                    <select name="type" id="linkType" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" onchange="toggleLinkFields()">
                        <option value="custom">Custom URL</option>
                        <option value="category">Category</option>
                        <option value="product">Product</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <select name="location" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Select --</option>
                        <option value="header">Header Navigation</option>
                        <option value="footer">Footer</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Parent Menu Item</label>
                    <select name="parent_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">-- None (Top Level) --</option>
                        @php
                            function renderParentOption($item, $allHeaderItems, $depth = 0) {
                                $prefix = str_repeat('↳ ', $depth);
                                echo '<option value="' . $item->id . '">' . $prefix . e($item->name) . '</option>';
                                $children = $allHeaderItems->where('parent_id', $item->id);
                                foreach ($children as $child) {
                                    renderParentOption($child, $allHeaderItems, $depth + 1);
                                }
                            }
                            $topHeaderItems = $allHeaderItems->whereNull('parent_id');
                        @endphp
                        @foreach($topHeaderItems as $parent)
                            @php renderParentOption($parent, $allHeaderItems, 0); @endphp
                        @endforeach
                    </select>
                </div>
            </div>

            <div id="customFields" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Custom Label</label>
                    <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="Menu Label">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Custom URL</label>
                    <input type="text" name="slug" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="/about, /contact, etc.">
                </div>
            </div>

            <div id="categoryFields" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Categories (multiple allowed)</label>
                <div class="max-h-48 overflow-y-auto border border-gray-300 rounded-lg p-3 space-y-2">
                    @forelse($categories as $cat)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="reference_ids[]" value="{{ $cat->id }}" class="w-4 h-4 text-blue-600 rounded">
                        <span>{{ $cat->name }}</span>
                        <span class="text-xs text-gray-400">({{ $cat->products_count ?? 0 }} products)</span>
                    </label>
                    @empty
                    <p class="text-gray-500 text-sm">No categories found.</p>
                    @endforelse
                </div>
            </div>

            <div id="productFields" class="mb-4 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">Select Products (multiple allowed)</label>
                <div class="max-h-48 overflow-y-auto border border-gray-300 rounded-lg p-3 space-y-2">
                    @forelse($products as $prod)
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="reference_ids[]" value="{{ $prod->id }}" class="w-4 h-4 text-blue-600 rounded">
                        <span>{{ $prod->name }}</span>
                        <span class="text-xs text-gray-400">${{ number_format($prod->base_price, 2) }}</span>
                    </label>
                    @empty
                    <p class="text-gray-500 text-sm">No products found.</p>
                    @endforelse
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                    <input type="number" name="sort_order" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" placeholder="0">
                </div>
                <div class="flex items-center gap-2 mt-6">
                    <input type="checkbox" name="is_active" value="1" id="is_active" class="w-4 h-4 text-blue-600 rounded">
                    <label for="is_active" class="text-sm text-gray-700">Active</label>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Item
                    </button>
                </div>
            </div>
        </form>
        </div>

<div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Label</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Location</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">URL</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="menu-items-tbody">
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function toggleLinkFields() {
    var type = document.getElementById('linkType').value;
    document.getElementById('customFields').classList.toggle('hidden', type !== 'custom');
    document.getElementById('categoryFields').classList.toggle('hidden', type !== 'category');
    document.getElementById('productFields').classList.toggle('hidden', type !== 'product');

    var nameInput = document.querySelector('input[name="name"]');
    if (type === 'custom') {
        nameInput.setAttribute('required', 'required');
    } else {
        nameInput.removeAttribute('required');
    }
}

var allItems = @json($allItems);
var categories = @json($categories);
var products = @json($products);

function getNameById(items, id) {
    var found = items.find(function(x) { return x.id === id; });
    return found ? found.name : null;
}

function getDisplayName(item) {
    if (item.type === 'category' && item.reference_id) {
        return getNameById(categories, item.reference_id) || item.name;
    } else if (item.type === 'product' && item.reference_id) {
        return getNameById(products, item.reference_id) || item.name;
    }
    return item.name;
}

function renderTree(parentId, depth) {
    var items = allItems.filter(function(x) { return x.parent_id === parentId; });
    items.sort(function(a, b) { return a.sort_order - b.sort_order; });

    var html = '';
    items.forEach(function(item) {
        var indent = 24 + depth * 20;
        var isTop = depth === 0;
        var rowClass = isTop ? 'bg-blue-50' : '';
        var nameClass = isTop ? 'font-bold text-blue-700' : 'text-gray-600';
        var status = item.is_active ? '<span class="text-green-600">Active</span>' : '<span class="text-gray-400">Inactive</span>';
        var toggleText = item.is_active ? 'Disable' : 'Enable';
        var displayName = getDisplayName(item);
        var typeLabel = item.type === 'category' ? 'Category' : (item.type === 'product' ? 'Product' : 'Custom');
        var locationLabel = item.location === 'header' ? '<span class="text-blue-600">Header</span>' : (item.location === 'footer' ? '<span class="text-green-600">Footer</span>' : '<span class="text-gray-400">—</span>');
        var prefix = depth > 0 ? '↳ ' : '';

        html += '<tr class="' + rowClass + '">' +
            '<td class="px-6 py-3" style="padding-left: ' + indent + 'px;"><span class="' + nameClass + '">' + prefix + displayName + '</span></td>' +
            '<td class="px-6 py-3 text-gray-500 text-sm">' + typeLabel + '</td>' +
            '<td class="px-6 py-3 text-sm">' + locationLabel + '</td>' +
            '<td class="px-6 py-3 text-gray-500 text-sm">' + (item.slug || '-') + '</td>' +
            '<td class="px-6 py-3 text-sm">' + item.sort_order + '</td>' +
            '<td class="px-6 py-3 text-sm">' + status + '</td>' +
            '<td class="px-6 py-3">' +
                '<div class="flex items-center gap-2">' +
                    '<a href="/admin/menu-items/' + item.id + '/edit" class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition" title="Edit">' +
                        '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>' +
                    '</a>' +
                    '<a href="/admin/menu-items/' + item.id + '/toggle" class="inline-flex items-center justify-center w-8 h-8 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition" title="' + toggleText + '">' +
                        '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>' +
                    '</a>' +
                    '<form action="/admin/menu-items/' + item.id + '" method="POST" onsubmit="return confirm(\'Delete this item?\')">' +
                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                        '<input type="hidden" name="_method" value="DELETE">' +
                        '<button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Delete">' +
                            '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>' +
                        '</button>' +
                    '</form>' +
                '</div>' +
            '</td>' +
        '</tr>';

        html += renderTree(item.id, depth + 1);
    });

    return html;
}

function renderMenuItems() {
    var tbody = document.getElementById('menu-items-tbody');

    if (allItems.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">No menu items found.</td></tr>';
        return;
    }

    tbody.innerHTML = renderTree(null, 0);
}

renderMenuItems();
</script>
@endsection