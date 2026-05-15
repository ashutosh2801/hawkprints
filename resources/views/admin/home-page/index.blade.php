@extends('admin.layout')

@section('page-title', 'Manage Home Page')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold">Home Page Sections</h2>
            <p class="text-sm text-gray-500 mt-1">Drag and drop to reorder. Click Edit to configure section content.</p>
        </div>

        <div id="sections-list" class="divide-y">
            @forelse($sections as $section)
            <div class="flex items-center gap-4 p-4 hover:bg-gray-50 transition-colors" data-id="{{ $section->id }}" data-settings='@json($section->settings ?? [])' draggable="true">
                <div class="cursor-move text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                    </svg>
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <h3 class="font-medium text-gray-900">{{ $section->title }}</h3>
                        @if($section->is_active)
                        <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded">Active</span>
                        @else
                        <span class="px-2 py-0.5 bg-gray-100 text-gray-500 text-xs rounded">Hidden</span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 truncate">{{ $section->description }}</p>
                    <div class="mt-1 text-xs text-blue-600">
                        @php
                            $settings = $section->settings ?? [];
                            $info = '';
                            if ($section->key === 'categories' || $section->key === 'explore-categories') {
                                $catIds = $settings['category_ids'] ?? [];
                                $count = count($catIds);
                                $info = $count . ' categories selected';
                            } elseif ($section->key === 'featured-products') {
                                $prodIds = $settings['product_ids'] ?? [];
                                $info = count($prodIds) . ' products selected';
                                $info .= isset($settings['limit']) ? ' (limit: ' . $settings['limit'] . ')' : '';
                            } elseif ($section->key === 'new-arrivals') {
                                $prodIds = $settings['product_ids'] ?? [];
                                $catIds = $settings['category_ids'] ?? [];
                                if (count($prodIds)) $info = count($prodIds) . ' products selected';
                                if (count($catIds)) $info .= ($info ? ' | ' : '') . count($catIds) . ' categories';
                                $info .= isset($settings['limit']) ? ' (limit: ' . $settings['limit'] . ')' : '';
                                if (!$info) $info = 'Newest products';
                            } elseif ($section->key === 'testimonials') {
                                $info = isset($settings['limit']) ? 'Limit: ' . $settings['limit'] : 'Show all';
                            }
                        @endphp
                        @if($info){{ $info }}@endif
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button onclick="openEditModal('{{ $section->id }}', '{{ $section->key }}')" class="px-3 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                        Edit
                    </button>

                    <form action="{{ route('admin.home-page.toggle', $section->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors {{ $section->is_active ? 'bg-blue-600' : 'bg-gray-300' }}">
                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $section->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                        </button>
                    </form>

                    <form action="{{ route('admin.home-page.remove', $section->id) }}" method="POST" onsubmit="return confirm('Remove this section?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500">No sections configured. Add sections below.</div>
            @endforelse
        </div>
    </div>

    @if(!empty($missing))
    <div class="bg-white rounded-lg shadow mt-6">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold">Available Sections</h2>
            <p class="text-sm text-gray-500 mt-1">Click to add a section to your home page</p>
        </div>
        <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($missing as $key => $info)
            <div class="flex items-center justify-between p-3 border rounded-lg hover:bg-gray-50">
                <div>
                    <h4 class="font-medium text-sm">{{ $info['title'] }}</h4>
                    <p class="text-xs text-gray-500">{{ $info['description'] }}</p>
                </div>
                <form action="{{ route('admin.home-page.add', $key) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">Add</button>
                </form>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Edit Modal -->
<div id="edit-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeEditModal()"></div>
    <div class="absolute inset-8 md:inset-16 bg-white rounded-lg shadow-xl flex flex-col overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 id="edit-modal-title" class="text-lg font-semibold">Edit Section</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-6" id="edit-modal-body"></div>
        <div class="p-4 border-t bg-gray-50 flex justify-end gap-3">
            <button onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Cancel</button>
            <button onclick="saveSectionSettings()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Save</button>
        </div>
    </div>
</div>

<script>
const allCategories = @json($categories);
const allProducts = @json($products);
let currentSectionId = null;
let currentSectionKey = null;

function openEditModal(id, key) {
    currentSectionId = id;
    currentSectionKey = key;
    const modal = document.getElementById('edit-modal');
    const body = document.getElementById('edit-modal-body');
    const title = document.getElementById('edit-modal-title');

    const section = document.querySelector(`[data-id="${id}"]`);
    const settingsText = section?.querySelector('.text-blue-600')?.textContent || '';

    let html = '';

    if (key === 'categories') {
        title.textContent = 'Configure Shop Favourites';
        const selected = getSelected('category_ids', id);
        html = `
            <p class="text-sm text-gray-600 mb-4">Select categories to display in the Shop Favourites section</p>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                ${allCategories.map(c => `
                    <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-blue-50 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                        <input type="checkbox" class="section-category w-4 h-4" value="${c.id}" ${selected.includes(c.id) ? 'checked' : ''}>
                        <span class="text-sm">${c.name}</span>
                    </label>
                `).join('')}
            </div>
        `;
    } else if (key === 'featured-products') {
        title.textContent = 'Configure Featured Products';
        const selected = getSelected('product_ids', id);
        const limit = getSetting('limit', id, 6);
        html = `
            <p class="text-sm text-gray-600 mb-4">Select products to feature on the home page</p>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Display Limit</label>
                <input type="number" id="section-limit" value="${limit}" min="1" max="20" class="w-24 px-3 py-2 border rounded-lg">
            </div>
            <div class="space-y-2 max-h-96 overflow-y-auto border rounded-lg p-3">
                ${allProducts.map(p => `
                    <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-50 has-[:checked]:bg-blue-50">
                        <input type="checkbox" class="section-product w-4 h-4" value="${p.id}" ${selected.includes(p.id) ? 'checked' : ''}>
                        <img src="${p.image || ''}" alt="" class="w-8 h-8 object-cover rounded">
                        <div class="flex-1 min-w-0">
                            <span class="text-sm font-medium truncate block">${p.name}</span>
                            <span class="text-xs text-gray-500">${p.category || 'No category'}</span>
                        </div>
                    </label>
                `).join('')}
            </div>
        `;
    } else if (key === 'explore-categories') {
        title.textContent = 'Configure Explore More';
        const selected = getSelected('category_ids', id);
        html = `
            <p class="text-sm text-gray-600 mb-4">Select categories to display in the Explore More section</p>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                ${allCategories.map(c => `
                    <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:bg-blue-50 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                        <input type="checkbox" class="section-category w-4 h-4" value="${c.id}" ${selected.includes(c.id) ? 'checked' : ''}>
                        <span class="text-sm">${c.name}</span>
                    </label>
                `).join('')}
            </div>
        `;
    } else if (key === 'new-arrivals') {
        title.textContent = 'Configure New Arrivals';
        const selected = getSelected('product_ids', id);
        const selectedCats = getSelected('category_ids', id);
        const limit = getSetting('limit', id, 4);
        html = `
            <p class="text-sm text-gray-600 mb-4">Select products or filter by categories for the New Arrivals section</p>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Display Limit</label>
                <input type="number" id="section-limit" value="${limit}" min="1" max="20" class="w-24 px-3 py-2 border rounded-lg">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Category (optional)</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    ${allCategories.map(c => `
                        <label class="flex items-center gap-2 p-2 border rounded-lg cursor-pointer hover:bg-blue-50 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                            <input type="checkbox" class="section-category w-4 h-4" value="${c.id}" ${selectedCats.includes(c.id) ? 'checked' : ''}>
                            <span class="text-sm">${c.name}</span>
                        </label>
                    `).join('')}
                </div>
            </div>
            <div class="space-y-2 max-h-96 overflow-y-auto border rounded-lg p-3">
                ${allProducts.map(p => `
                    <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-50 has-[:checked]:bg-blue-50">
                        <input type="checkbox" class="section-product w-4 h-4" value="${p.id}" ${selected.includes(p.id) ? 'checked' : ''}>
                        <img src="${p.image || ''}" alt="" class="w-8 h-8 object-cover rounded">
                        <div class="flex-1 min-w-0">
                            <span class="text-sm font-medium truncate block">${p.name}</span>
                            <span class="text-xs text-gray-500">${p.category || 'No category'}</span>
                        </div>
                    </label>
                `).join('')}
            </div>
        `;
    } else if (key === 'testimonials') {
        title.textContent = 'Configure Testimonials';
        const limit = getSetting('limit', id, 6);
        html = `
            <p class="text-sm text-gray-600 mb-4">Set how many testimonials to display</p>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Display Limit</label>
                <input type="number" id="section-limit" value="${limit}" min="1" max="20" class="w-24 px-3 py-2 border rounded-lg">
            </div>
        `;
    } else if (key === 'about') {
        title.textContent = 'Configure About Section';
        const heading = getSetting('heading', id, 'Why Choose Five Rivers Print?');
        const text = getSetting('text', id, '');
        html = `
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Section Heading</label>
                    <input type="text" id="section-heading" value="${heading}" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Section Text</label>
                    <textarea id="section-text" rows="4" class="w-full px-4 py-2 border rounded-lg">${text}</textarea>
                </div>
            </div>
        `;
    } else if (key === 'clients') {
        title.textContent = 'Configure Clients Section';
        const heading = getSetting('heading', id, 'Trusted by Leading Brands');
        const clientsList = getSetting('clients', id, []);
        html = `
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Section Heading</label>
                    <input type="text" id="section-heading" value="${heading}" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Client Logos</label>
                    <p class="text-sm text-gray-500 mb-3">Add client/partner logos to display in the scrolling carousel.</p>
                    <div id="clients-list" class="space-y-2">
                        ${clientsList.length === 0 ? '<p class="text-sm text-gray-400 italic p-3">No clients added yet. Click "Add Client" below.</p>' : ''}
                    </div>
                    <button type="button" onclick="addClientRow()" class="mt-3 px-4 py-2 bg-gray-100 text-gray-700 text-sm rounded-lg hover:bg-gray-200 border border-gray-300">
                        + Add Client
                    </button>
                </div>
            </div>
        `;
        // Render existing clients after modal opens
        setTimeout(() => {
            clientsList.forEach((c, i) => addClientRow(c.name, c.image, i));
        }, 50);
    } else if (key === 'all-categories') {
        title.textContent = 'Configure All Categories';
        const heading = getSetting('heading', id, 'All Categories');
        const limit = getSetting('limit', id, 0);
        html = `
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Section Heading</label>
                    <input type="text" id="section-heading" value="${heading}" class="w-full px-4 py-2 border rounded-lg">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Limit (0 = show all)</label>
                    <input type="number" id="section-limit" value="${limit}" min="0" max="50" class="w-24 px-3 py-2 border rounded-lg">
                </div>
            </div>
        `;
    } else if (key === 'hero') {
        title.textContent = 'Configure Hero Slider';
        const auto = getSetting('auto_play', id, true);
        html = `
            <div class="space-y-4">
                <label class="flex items-center gap-3">
                    <input type="checkbox" id="section-auto-play" ${auto ? 'checked' : ''} class="w-5 h-5">
                    <span class="font-medium">Auto-play slider</span>
                </label>
                <p class="text-sm text-gray-500">Slider content is managed in the Sliders section</p>
            </div>
        `;
    }

    body.innerHTML = html;
    modal.classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('edit-modal').classList.add('hidden');
    currentSectionId = null;
    currentSectionKey = null;
}

function getSelected(type, sectionId) {
    const el = document.querySelector(`[data-id="${sectionId}"]`);
    if (!el) return [];
    const settingsStr = el.getAttribute('data-settings') || '{}';
    try {
        const settings = JSON.parse(settingsStr);
        return settings[type] || [];
    } catch {
        return [];
    }
}

function getSetting(key, sectionId, defaultVal) {
    const el = document.querySelector(`[data-id="${sectionId}"]`);
    if (!el) return defaultVal;
    const settingsStr = el.getAttribute('data-settings') || '{}';
    try {
        const settings = JSON.parse(settingsStr);
        return settings[key] !== undefined ? settings[key] : defaultVal;
    } catch {
        return defaultVal;
    }
}

let clientRowCounter = 0;

function addClientRow(name, image, index) {
    const list = document.getElementById('clients-list');
    const emptyMsg = list.querySelector('p.text-gray-400');
    if (emptyMsg) emptyMsg.remove();
    clientRowCounter++;
    const id = 'client-' + clientRowCounter;
    const div = document.createElement('div');
    div.className = 'client-row flex items-center gap-3 p-3 bg-gray-50 rounded-lg border border-gray-200';
    div.innerHTML = `
        <div class="flex-shrink-0 w-14 h-14 bg-white rounded-lg border border-gray-200 overflow-hidden flex items-center justify-center preview-slot" data-row-id="${id}">
            ${image ? `<img src="${image}" class="w-full h-full object-contain">` : '<svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>'}
        </div>
        <div class="flex-1 min-w-0">
            <input type="text" class="client-name w-full px-3 py-1.5 border border-gray-300 rounded-lg text-sm" placeholder="Client name" value="${name || ''}">
            <input type="hidden" class="client-image-url" value="${image || ''}">
        </div>
        <button type="button" onclick="openMediaLibraryForClient('${id}')" class="px-3 py-1.5 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 flex-shrink-0" title="Choose image">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </button>
        <button type="button" onclick="this.closest('.client-row').remove()" class="p-1.5 text-red-500 hover:bg-red-50 rounded flex-shrink-0" title="Remove">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </button>
    `;
    list.appendChild(div);
}

function openMediaLibraryForClient(rowId) {
    openMediaLibrary({
        mode: 'single',
        callback: function(ids) {
            const img = mediaLibraryState.allImages.find(i => i.id === ids[0]);
            if (img) {
                const preview = document.querySelector(`.preview-slot[data-row-id="${rowId}"]`);
                if (preview) {
                    preview.innerHTML = `<img src="${img.url}" class="w-full h-full object-contain">`;
                }
                const hiddenInput = preview?.closest('.client-row')?.querySelector('.client-image-url');
                if (hiddenInput) hiddenInput.value = img.url;
            }
        }
    });
}

function saveSectionSettings() {
    const settings = {};

    if (currentSectionKey === 'categories' || currentSectionKey === 'explore-categories') {
        settings.category_ids = Array.from(document.querySelectorAll('.section-category:checked')).map(cb => parseInt(cb.value));
    } else if (currentSectionKey === 'featured-products') {
        settings.product_ids = Array.from(document.querySelectorAll('.section-product:checked')).map(cb => parseInt(cb.value));
        const limit = document.getElementById('section-limit')?.value;
        if (limit) settings.limit = parseInt(limit);
    } else if (currentSectionKey === 'new-arrivals') {
        settings.product_ids = Array.from(document.querySelectorAll('.section-product:checked')).map(cb => parseInt(cb.value));
        settings.category_ids = Array.from(document.querySelectorAll('.section-category:checked')).map(cb => parseInt(cb.value));
        const limit = document.getElementById('section-limit')?.value;
        if (limit) settings.limit = parseInt(limit);
    } else if (currentSectionKey === 'testimonials') {
        const limit = document.getElementById('section-limit')?.value;
        if (limit) settings.limit = parseInt(limit);
    } else if (currentSectionKey === 'all-categories') {
        const limit = document.getElementById('section-limit')?.value;
        if (limit !== undefined) settings.limit = parseInt(limit);
        const heading = document.getElementById('section-heading')?.value;
        if (heading) settings.heading = heading;
    } else if (currentSectionKey === 'about') {
        const heading = document.getElementById('section-heading')?.value;
        const text = document.getElementById('section-text')?.value;
        if (heading) settings.heading = heading;
        if (text) settings.text = text;
    } else if (currentSectionKey === 'clients') {
        const heading = document.getElementById('section-heading')?.value;
        if (heading) settings.heading = heading;
        const rows = document.querySelectorAll('#clients-list .client-row');
        const clients = [];
        rows.forEach(row => {
            const name = row.querySelector('.client-name')?.value?.trim();
            const image = row.querySelector('.client-image-url')?.value?.trim();
            if (name || image) clients.push({ name: name || '', image: image || '' });
        });
        settings.clients = clients;
    } else if (currentSectionKey === 'hero') {
        settings.auto_play = document.getElementById('section-auto-play')?.checked ?? true;
    }

    fetch('/admin/home-page/' + currentSectionId, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ settings: settings }),
    })
    .then(res => res.json())
    .then(() => {
        closeEditModal();
        location.reload();
    })
    .catch(err => {
        console.error('Save failed:', err);
        alert('Failed to save settings');
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const list = document.getElementById('sections-list');
    let dragItem = null;

    list.addEventListener('dragstart', function(e) {
        dragItem = e.target.closest('[data-id]');
        if (dragItem) {
            dragItem.style.opacity = '0.5';
            e.dataTransfer.effectAllowed = 'move';
        }
    });

    list.addEventListener('dragend', function(e) {
        if (dragItem) {
            dragItem.style.opacity = '1';
            saveOrder();
            dragItem = null;
        }
    });

    list.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        const target = e.target.closest('[data-id]');
        if (target && target !== dragItem) {
            const rect = target.getBoundingClientRect();
            const midpoint = rect.top + rect.height / 2;
            if (e.clientY < midpoint) {
                list.insertBefore(dragItem, target);
            } else {
                list.insertBefore(dragItem, target.nextSibling);
            }
        }
    });

    function saveOrder() {
        const items = list.querySelectorAll('[data-id]');
        const order = [];
        items.forEach(item => order.push(item.getAttribute('data-id')));

        fetch('{{ route('admin.home-page.reorder') }}', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ order: order }),
        }).catch(err => console.error('Failed to save order:', err));
    }
});
</script>

@include('admin.partials.media-library')
@endsection
