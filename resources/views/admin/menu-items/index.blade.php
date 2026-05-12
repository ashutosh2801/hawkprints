@extends('admin.layout')

@section('page-title', 'Menu Items')

@section('content')
<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="p-6">
        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold">Manage Menu Items</h2>
        </div>

        <form method="POST" action="{{ route('admin.menu-items.store') }}" class="mb-8 p-4 bg-gray-50 rounded-lg">
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
                        @php $topItems = App\Models\MenuItem::whereNull('parent_id')->orderBy('name')->get(); @endphp
                        @foreach($topItems as $top)
                        <option value="{{ $top->id }}">{{ $top->name }}</option>
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

function renderMenuItems() {
    var tbody = document.getElementById('menu-items-tbody');
    
    // Separate parent items and child items
    var parents = allItems.filter(function(x) { return !x.parent_id; });
    var children = allItems.filter(function(x) { return x.parent_id; });
    
    if (allItems.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">No menu items found. Add one above.</td></tr>';
        return;
    }
    
    var html = '';
    
    // Sort parents by sort_order
    parents.sort(function(a, b) { return a.sort_order - b.sort_order; });
    
    parents.forEach(function(parent) {
        var status = parent.is_active ? '<span class="text-green-600">Active</span>' : '<span class="text-gray-400">Inactive</span>';
        var toggleText = parent.is_active ? 'Disable' : 'Enable';
        var displayName = getDisplayName(parent);
        var typeLabel = parent.type === 'category' ? 'Category' : (parent.type === 'product' ? 'Product' : 'Custom');
        
        var locationLabel = parent.location === 'header' ? '<span class="text-blue-600">Header</span>' : (parent.location === 'footer' ? '<span class="text-green-600">Footer</span>' : '<span class="text-gray-400">—</span>');
        
        html += '<tr class="bg-blue-50">' +
            '<td class="px-6 py-3 font-bold text-blue-700">' + displayName + '</td>' +
            '<td class="px-6 py-3 text-gray-500">' + typeLabel + '</td>' +
            '<td class="px-6 py-3">' + locationLabel + '</td>' +
            '<td class="px-6 py-3 text-gray-500 text-sm">' + (parent.slug || '-') + '</td>' +
            '<td class="px-6 py-3">' + parent.sort_order + '</td>' +
            '<td class="px-6 py-3">' + status + '</td>' +
            '<td class="px-6 py-3">' +
                '<div class="flex items-center gap-2">' +
                    '<a href="/admin/menu-items/' + parent.id + '/edit" class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition" title="Edit">' +
                        '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>' +
                    '</a>' +
                    '<a href="/admin/menu-items/' + parent.id + '/toggle" class="inline-flex items-center justify-center w-8 h-8 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition" title="' + toggleText + '">' +
                        '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>' +
                    '</a>' +
                    '<form action="/admin/menu-items/' + parent.id + '" method="POST" onsubmit="return confirm(\'Delete this item?\')">' +
                        '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                        '<input type="hidden" name="_method" value="DELETE">' +
                        '<button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Delete">' +
                            '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>' +
                        '</button>' +
                    '</form>' +
                '</div>' +
            '</td>' +
        '</tr>';
        
        // Render children
        var parentChildren = children.filter(function(x) { return x.parent_id === parent.id; });
        parentChildren.sort(function(a, b) { return a.sort_order - b.sort_order; });
        
        parentChildren.forEach(function(child) {
            var cstatus = child.is_active ? '<span class="text-green-600">Active</span>' : '<span class="text-gray-400">Inactive</span>';
            var ctoggleText = child.is_active ? 'Disable' : 'Enable';
            var cdisplayName = getDisplayName(child);
            var ctypeLabel = child.type === 'category' ? 'Category' : (child.type === 'product' ? 'Product' : 'Custom');
            
            var clocationLabel = child.location === 'header' ? '<span class="text-blue-600">Header</span>' : (child.location === 'footer' ? '<span class="text-green-600">Footer</span>' : '<span class="text-gray-400">—</span>');
            
            html += '<tr>' +
                '<td class="px-6 py-2 pl-10 text-gray-600">↳ ' + cdisplayName + '</td>' +
                '<td class="px-6 py-2 text-gray-500">' + ctypeLabel + '</td>' +
                '<td class="px-6 py-2">' + clocationLabel + '</td>' +
                '<td class="px-6 py-2 text-gray-500 text-sm">' + (child.slug || '-') + '</td>' +
                '<td class="px-6 py-2">' + child.sort_order + '</td>' +
                '<td class="px-6 py-2">' + cstatus + '</td>' +
                '<td class="px-6 py-2">' +
                    '<div class="flex items-center gap-2">' +
                        '<a href="/admin/menu-items/' + child.id + '/edit" class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition" title="Edit">' +
                            '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>' +
                        '</a>' +
                        '<a href="/admin/menu-items/' + child.id + '/toggle" class="inline-flex items-center justify-center w-8 h-8 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition" title="' + ctoggleText + '">' +
                            '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>' +
                        '</a>' +
                        '<form action="/admin/menu-items/' + child.id + '" method="POST" onsubmit="return confirm(\'Delete this item?\')">' +
                            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
                            '<input type="hidden" name="_method" value="DELETE">' +
                            '<button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Delete">' +
                                '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>' +
                            '</button>' +
                        '</form>' +
                    '</div>' +
                '</td>' +
            '</tr>';
        });
        
        if (parentChildren.length === 0) {
            html += '<tr><td colspan="7" class="px-6 py-2 pl-10 text-gray-400 text-sm italic">No sub-items</td></tr>';
        }
    });
    
    tbody.innerHTML = html;
}

renderMenuItems();
</script>
@endsection