<!-- Media Library Modal -->
<div id="media-library-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeMediaLibrary()"></div>

    <div class="absolute inset-4 bg-white rounded-lg shadow-xl flex flex-col">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b">
            <h2 class="text-lg font-semibold">Media Library</h2>
            <div class="flex items-center gap-4">
                <input type="text" id="media-search" placeholder="Search images..." class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm w-64" oninput="debounceSearchMedia()">
                <button onclick="closeMediaLibrary()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Toolbar -->
        <div class="flex items-center justify-between p-3 bg-gray-50 border-b">
            <div class="flex items-center gap-3">
                <button onclick="document.getElementById('media-upload-input').click()" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                    Upload Files
                </button>
                <input type="file" id="media-upload-input" multiple accept="image/*" class="hidden" onchange="handleMediaUpload(this.files)">
                <span id="media-count" class="text-sm text-gray-500"></span>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="toggleMediaView('grid')" id="btn-grid-view" class="p-2 rounded bg-gray-200 text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                </button>
            </div>
        </div>

        <!-- Upload Progress -->
        <div id="media-upload-progress" class="hidden px-4 py-3 bg-blue-50 border-b">
            <div class="flex items-center gap-3">
                <svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                <span class="text-sm text-blue-700">Uploading...</span>
            </div>
        </div>

        <!-- Image Grid -->
        <div id="media-grid" class="flex-1 overflow-y-auto p-4">
            <div id="media-grid-content" class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
                <!-- Images loaded dynamically -->
            </div>
            <div id="media-loading" class="hidden py-8 text-center">
                <svg class="animate-spin h-8 w-8 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
            </div>
            <div id="media-empty" class="hidden py-12 text-center text-gray-500">
                <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-lg font-medium">No images found</p>
                <p class="text-sm mt-1">Upload images to get started</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="flex items-center justify-between p-4 border-t bg-gray-50">
            <div id="selected-info" class="text-sm text-gray-600">
                <span id="selected-count">0</span> image(s) selected
            </div>
            <div class="flex gap-3">
                <button onclick="closeMediaLibrary()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">Cancel</button>
                <button id="media-insert-btn" onclick="insertSelectedImages()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Insert Selected
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Image Modal -->
<div id="edit-image-modal" class="fixed inset-0 z-[70] hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeEditImageModal()"></div>
    <div class="absolute inset-8 md:inset-24 bg-white rounded-lg shadow-xl flex flex-col overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="text-lg font-semibold">Edit Image</h3>
            <button onclick="closeEditImageModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="rounded-lg overflow-hidden bg-gray-100 mb-4">
                        <img id="edit-image-preview" src="" alt="" class="w-full h-auto object-contain max-h-[300px]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Replace Image</label>
                        <div id="edit-replace-drop-zone" class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-colors">
                            <input type="file" id="edit-replace-file" accept="image/*" class="hidden" onchange="handleReplacePreview(this.files)">
                            <div id="edit-replace-content">
                                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-sm text-gray-500 mt-1">Click or drag to replace</p>
                            </div>
                            <div id="edit-replace-preview" class="hidden">
                                <img id="edit-replace-img" src="" class="max-h-20 mx-auto rounded">
                                <p class="text-sm text-green-600 mt-1" id="edit-replace-name"></p>
                                <p class="text-xs text-gray-400 mt-1">Click to change again</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alt Text</label>
                        <input type="text" id="edit-image-alt" placeholder="Describe the image for accessibility" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Used for accessibility and SEO</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" id="edit-image-title" placeholder="Image title" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Shown on hover</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg text-xs text-gray-500 space-y-1">
                        <p><strong>File:</strong> <span id="edit-image-url"></span></p>
                        <p><strong>Added:</strong> <span id="edit-image-date"></span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-4 border-t bg-gray-50 flex justify-end gap-3">
            <button onclick="closeEditImageModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">Cancel</button>
            <button onclick="saveImageDetails()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Save Changes</button>
        </div>
    </div>
</div>

<!-- Selected Images Preview (for drag-and-drop style) -->
<div id="media-preview-panel" class="hidden fixed right-0 top-0 h-full w-64 bg-white shadow-xl border-l z-50 flex flex-col">
    <div class="p-4 border-b flex items-center justify-between">
        <h3 class="font-medium">Selected</h3>
        <button onclick="closeMediaLibrary()" class="text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <div id="media-selected-list" class="flex-1 overflow-y-auto p-3 space-y-2"></div>
</div>

<script>
// Media Library State
let mediaLibraryState = {
    selected: new Set(),
    allImages: [],
    callback: null,
    mode: 'single',
    currentProductId: null,
    attachProductId: null,
    searchTimeout: null,
    editingImageId: null,
    replaceFile: null,
};

function openMediaLibrary(options = {}) {
    const modal = document.getElementById('media-library-modal');
    mediaLibraryState.callback = options.callback || null;
    mediaLibraryState.mode = options.mode || 'single';
    mediaLibraryState.currentProductId = options.productId || null;
    mediaLibraryState.attachProductId = options.attachProductId || options.productId || null;
    mediaLibraryState.selected = new Set(options.selected || []);

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';

    loadMediaLibrary();
}

function closeMediaLibrary() {
    const modal = document.getElementById('media-library-modal');
    modal.classList.add('hidden');
    document.body.style.overflow = '';
    mediaLibraryState.selected.clear();
    updateSelectedUI();
}

function loadMediaLibrary() {
    const grid = document.getElementById('media-grid-content');
    const loading = document.getElementById('media-loading');
    const empty = document.getElementById('media-empty');

    grid.innerHTML = '';
    loading.classList.remove('hidden');
    empty.classList.add('hidden');

    const params = new URLSearchParams();
    const searchTerm = document.getElementById('media-search')?.value || '';
    if (searchTerm) params.set('search', searchTerm);

    fetch('/admin/media-library/api/list?' + params.toString())
        .then(res => res.json())
        .then(data => {
            loading.classList.add('hidden');
            mediaLibraryState.allImages = data.images || [];

            if (mediaLibraryState.allImages.length === 0) {
                empty.classList.remove('hidden');
                document.getElementById('media-count').textContent = '0 images';
                return;
            }

            document.getElementById('media-count').textContent = mediaLibraryState.allImages.length + ' image(s)';

            mediaLibraryState.allImages.forEach(img => {
                const div = document.createElement('div');
                div.className = 'relative group cursor-pointer rounded-lg overflow-hidden border-2 ' +
                    (mediaLibraryState.selected.has(img.id) ? 'border-blue-500 ring-2 ring-blue-200' : 'border-transparent hover:border-gray-300');
                div.setAttribute('data-id', img.id);
                div.onclick = (e) => toggleMediaSelection(img.id, e);

                const altText = img.alt ? `<p class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-70 text-white text-[10px] px-1 truncate">${img.alt}</p>` : '';

                div.innerHTML = `
                    <img src="${img.thumbnail}" alt="${img.alt || ''}" title="${img.title || ''}" class="w-full h-24 object-cover" loading="lazy">
                    ${altText}
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all flex items-center justify-center pointer-events-none">
                        <div class="hidden group-hover:flex gap-1 pointer-events-auto">
                            <button onclick="event.stopPropagation(); previewImage('${img.url}')" class="p-1 bg-white rounded shadow hover:bg-gray-100" title="View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <button onclick="event.stopPropagation(); openEditImageModal(${img.id})" class="p-1 bg-white rounded shadow hover:bg-gray-100" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            ${img.product_id ? `<button onclick="event.stopPropagation(); setAsPrimary(${img.id})" class="p-1 bg-white rounded shadow hover:bg-gray-100 ${img.is_primary ? 'text-yellow-500' : ''}" title="${img.is_primary ? 'Primary' : 'Set as primary'}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            </button>` : ''}
                            <button onclick="event.stopPropagation(); deleteMediaImage(${img.id})" class="p-1 bg-white rounded shadow hover:bg-red-50 text-red-500" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                    ${mediaLibraryState.selected.has(img.id) ? '<div class="absolute top-1 right-1 w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center"><svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></div>' : ''}
                `;

                grid.appendChild(div);
            });
        })
        .catch(err => {
            loading.classList.add('hidden');
            empty.classList.remove('hidden');
            console.error('Failed to load media:', err);
        });
}

function toggleMediaSelection(imageId, event) {
    if (event?.ctrlKey || event?.metaKey || mediaLibraryState.mode === 'multiple') {
        if (mediaLibraryState.selected.has(imageId)) {
            mediaLibraryState.selected.delete(imageId);
        } else {
            mediaLibraryState.selected.add(imageId);
        }
    } else {
        mediaLibraryState.selected.clear();
        mediaLibraryState.selected.add(imageId);
    }

    document.querySelectorAll('#media-grid-content > div').forEach(div => {
        const id = parseInt(div.getAttribute('data-id'));
        const isSelected = mediaLibraryState.selected.has(id);
        div.className = 'relative group cursor-pointer rounded-lg overflow-hidden border-2 ' +
            (isSelected ? 'border-blue-500 ring-2 ring-blue-200' : 'border-transparent hover:border-gray-300');

        const existingCheck = div.querySelector('.absolute.top-1.right-1');
        if (existingCheck) existingCheck.remove();
        if (isSelected) {
            const check = document.createElement('div');
            check.className = 'absolute top-1 right-1 w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center';
            check.innerHTML = '<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>';
            div.appendChild(check);
        }
    });

    updateSelectedUI();
}

function updateSelectedUI() {
    const count = mediaLibraryState.selected.size;
    document.getElementById('selected-count').textContent = count;
    const insertBtn = document.getElementById('media-insert-btn');
    insertBtn.disabled = count === 0;
}

function handleMediaUpload(files) {
    if (!files || files.length === 0) return;

    const formData = new FormData();
    Array.from(files).forEach(file => {
        formData.append('files[]', file);
    });
    if (mediaLibraryState.attachProductId) {
        formData.append('product_id', mediaLibraryState.attachProductId);
    }

    document.getElementById('media-upload-progress').classList.remove('hidden');
    document.getElementById('media-upload-input').value = '';

    fetch('/admin/media-library/upload', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
        body: formData,
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('media-upload-progress').classList.add('hidden');
        if (data.success) {
            if (mediaLibraryState.attachProductId) {
                closeMediaLibrary();
                location.reload();
            } else {
                loadMediaLibrary();
            }
        }
    })
    .catch(err => {
        document.getElementById('media-upload-progress').classList.add('hidden');
        console.error('Upload failed:', err);
    });
}

function openEditImageModal(imageId) {
    const image = mediaLibraryState.allImages.find(img => img.id === imageId);
    if (!image) return;

    mediaLibraryState.editingImageId = imageId;
    mediaLibraryState.replaceFile = null;

    document.getElementById('edit-image-preview').src = image.url;
    document.getElementById('edit-image-alt').value = image.alt || '';
    document.getElementById('edit-image-title').value = image.title || '';
    document.getElementById('edit-image-url').textContent = image.url.split('/').pop();
    document.getElementById('edit-image-date').textContent = image.created_at;

    document.getElementById('edit-replace-file').value = '';
    document.getElementById('edit-replace-content').classList.remove('hidden');
    document.getElementById('edit-replace-preview').classList.add('hidden');

    document.getElementById('edit-image-modal').classList.remove('hidden');
}

function closeEditImageModal() {
    document.getElementById('edit-image-modal').classList.add('hidden');
    mediaLibraryState.editingImageId = null;
    mediaLibraryState.replaceFile = null;
}

function handleReplacePreview(files) {
    if (!files || files.length === 0) return;

    const file = files[0];
    mediaLibraryState.replaceFile = file;

    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('edit-replace-img').src = e.target.result;
        document.getElementById('edit-replace-name').textContent = file.name;
        document.getElementById('edit-replace-content').classList.add('hidden');
        document.getElementById('edit-replace-preview').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

function saveImageDetails() {
    if (!mediaLibraryState.editingImageId) return;

    const formData = new FormData();
    formData.append('alt', document.getElementById('edit-image-alt').value);
    formData.append('title', document.getElementById('edit-image-title').value);
    formData.append('_method', 'PUT');

    if (mediaLibraryState.replaceFile) {
        formData.append('replace_file', mediaLibraryState.replaceFile);
    }

    fetch('/admin/media-library/' + mediaLibraryState.editingImageId, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
        body: formData,
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeEditImageModal();
            loadMediaLibrary();
        }
    })
    .catch(err => console.error('Save failed:', err));
}

function deleteMediaImage(imageId) {
    if (!confirm('Delete this image?')) return;

    fetch('/admin/media-library/' + imageId, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            mediaLibraryState.selected.delete(imageId);
            loadMediaLibrary();
            updateSelectedUI();
        }
    });
}

function setAsPrimary(imageId) {
    fetch('/admin/media-library/' + imageId + '/primary', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'Content-Type': 'application/json',
        },
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            loadMediaLibrary();
        }
    });
}

function previewImage(url) {
    const overlay = document.createElement('div');
    overlay.className = 'fixed inset-0 z-[60] bg-black bg-opacity-80 flex items-center justify-center cursor-pointer';
    overlay.onclick = () => overlay.remove();
    overlay.innerHTML = `<img src="${url}" class="max-w-[90vw] max-h-[90vh] object-contain">`;
    document.body.appendChild(overlay);
}

function insertSelectedImages() {
    const selectedIds = Array.from(mediaLibraryState.selected);

    if (selectedIds.length === 0) return;

    if (mediaLibraryState.callback) {
        mediaLibraryState.callback(selectedIds);
        closeMediaLibrary();
        return;
    }

    if (!mediaLibraryState.attachProductId) {
        closeMediaLibrary();
        return;
    }

    const formData = new FormData();
    formData.append('product_id', mediaLibraryState.attachProductId);
    selectedIds.forEach(id => {
        formData.append('image_ids[]', id);
    });

    fetch('/admin/products/' + mediaLibraryState.attachProductId + '/attach-images', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
        body: formData,
    })
    .then(res => {
        if (!res.ok) throw new Error('Attach failed: ' + res.status);
        return res.json();
    })
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(err => {
        console.error('Attach error:', err);
        alert('Failed to attach images. Please try again.');
    });
}

function debounceSearchMedia() {
    clearTimeout(mediaLibraryState.searchTimeout);
    mediaLibraryState.searchTimeout = setTimeout(() => {
        loadMediaLibrary();
    }, 300);
}

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('media-library-modal');
    if (!modal) return;

    modal.addEventListener('dragover', (e) => {
        e.preventDefault();
        modal.querySelector('.absolute.inset-4').classList.add('ring-4', 'ring-blue-400');
    });

    modal.addEventListener('dragleave', () => {
        modal.querySelector('.absolute.inset-4').classList.remove('ring-4', 'ring-blue-400');
    });

    modal.addEventListener('drop', (e) => {
        e.preventDefault();
        modal.querySelector('.absolute.inset-4').classList.remove('ring-4', 'ring-blue-400');
        if (e.dataTransfer.files.length > 0) {
            handleMediaUpload(e.dataTransfer.files);
        }
    });

    const replaceZone = document.getElementById('edit-replace-drop-zone');
    if (replaceZone) {
        replaceZone.addEventListener('click', () => document.getElementById('edit-replace-file').click());

        replaceZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            replaceZone.classList.add('border-blue-500', 'bg-blue-50');
        });

        replaceZone.addEventListener('dragleave', () => {
            replaceZone.classList.remove('border-blue-500', 'bg-blue-50');
        });

        replaceZone.addEventListener('drop', (e) => {
            e.preventDefault();
            replaceZone.classList.remove('border-blue-500', 'bg-blue-50');
            if (e.dataTransfer.files.length > 0) {
                handleReplacePreview(e.dataTransfer.files);
            }
        });
    }
});
</script>
