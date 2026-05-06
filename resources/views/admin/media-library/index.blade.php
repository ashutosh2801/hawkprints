@extends('admin.layout')

@section('page-title', 'Media Library')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-bold">Media Library</h1>
    <button onclick="document.getElementById('ml-upload-input').click()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Upload Files
    </button>
    <input type="file" id="ml-upload-input" multiple accept="image/*" class="hidden" onchange="handlePageUpload(this.files)">
</div>

<!-- Upload Progress -->
<div id="ml-upload-progress" class="hidden mb-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <div class="flex items-center gap-3">
        <svg class="animate-spin h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
        <span class="text-sm text-blue-700">Uploading...</span>
    </div>
</div>

<!-- Filters -->
<div class="mb-4 flex items-center gap-4">
    <input type="text" id="ml-search" placeholder="Search images..." class="px-4 py-2 border border-gray-300 rounded-lg w-64" oninput="debouncePageSearch()">
    <span id="ml-count" class="text-sm text-gray-500"></span>
</div>

<!-- Image Grid -->
<div id="ml-grid" class="grid grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
    <div id="ml-loading" class="col-span-full py-12 text-center">
        <svg class="animate-spin h-8 w-8 text-gray-400 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
    </div>
</div>

<div id="ml-empty" class="hidden py-12 text-center text-gray-500">
    <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
    <p class="text-lg font-medium">No images found</p>
    <p class="text-sm mt-1">Upload images to get started</p>
</div>

<!-- Edit Image Modal -->
<div id="edit-image-modal" class="fixed inset-0 z-50 hidden">
    <div class="absolute inset-0 bg-black bg-opacity-50" onclick="closeEditModal()"></div>
    <div class="absolute inset-8 md:inset-24 bg-white rounded-lg shadow-xl flex flex-col overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b">
            <h3 class="text-lg font-semibold">Edit Image</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
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
            <button onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 text-sm">Cancel</button>
            <button onclick="saveImageEdit()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Save Changes</button>
        </div>
    </div>
</div>

<script>
let mlSearchTimeout = null;
let mlAllImages = [];
let mlEditingId = null;
let mlReplaceFile = null;

function loadMediaPage() {
    const grid = document.getElementById('ml-grid');
    const loading = document.getElementById('ml-loading');
    const empty = document.getElementById('ml-empty');

    grid.innerHTML = '';
    grid.appendChild(loading);
    loading.classList.remove('hidden');
    empty.classList.add('hidden');

    const params = new URLSearchParams();
    const searchTerm = document.getElementById('ml-search')?.value || '';
    if (searchTerm) params.set('search', searchTerm);

    fetch('/admin/media-library/api/list?' + params.toString())
        .then(res => res.json())
        .then(data => {
            loading.classList.add('hidden');
            const images = data.images || [];
            mlAllImages = images;

            if (images.length === 0) {
                empty.classList.remove('hidden');
                document.getElementById('ml-count').textContent = '0 images';
                return;
            }

            document.getElementById('ml-count').textContent = images.length + ' image(s)';

            images.forEach(img => {
                const div = document.createElement('div');
                div.className = 'group relative rounded-lg overflow-hidden border-2 border-transparent hover:border-gray-300 cursor-pointer';
                div.setAttribute('data-id', img.id);
                div.onclick = () => openEditModal(img.id);
                const altBadge = img.alt ? `<div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white text-[10px] px-1 truncate">${img.alt}</div>` : '';
                div.innerHTML = `
                    <img src="${img.thumbnail}" alt="${img.alt || ''}" title="${img.title || ''}" class="w-full h-24 object-cover" loading="lazy">
                    ${altBadge}
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all flex items-center justify-center">
                        <div class="hidden group-hover:flex gap-2">
                            <button onclick="event.stopPropagation(); previewImage('${img.url}')" class="p-1.5 bg-white rounded shadow hover:bg-gray-100" title="View">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <button onclick="event.stopPropagation(); openEditModal(${img.id})" class="p-1.5 bg-white rounded shadow hover:bg-gray-100" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <button onclick="event.stopPropagation(); copyImageUrl('${img.url}')" class="p-1.5 bg-white rounded shadow hover:bg-gray-100" title="Copy URL">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </button>
                            <button onclick="event.stopPropagation(); deletePageImage(${img.id})" class="p-1.5 bg-white rounded shadow hover:bg-red-50 text-red-500" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
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

function handlePageUpload(files) {
    if (!files || files.length === 0) return;

    const formData = new FormData();
    Array.from(files).forEach(file => formData.append('files[]', file));

    document.getElementById('ml-upload-progress').classList.remove('hidden');
    document.getElementById('ml-upload-input').value = '';

    fetch('/admin/media-library/upload', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
        body: formData,
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('ml-upload-progress').classList.add('hidden');
        if (data.success) loadMediaPage();
    })
    .catch(err => {
        document.getElementById('ml-upload-progress').classList.add('hidden');
        console.error('Upload failed:', err);
    });
}

function deletePageImage(imageId) {
    if (!confirm('Delete this image?')) return;

    fetch('/admin/media-library/' + imageId, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) loadMediaPage();
    });
}

function copyImageUrl(url) {
    navigator.clipboard.writeText(url).then(() => {
        alert('URL copied to clipboard!');
    });
}

function previewImage(url) {
    const overlay = document.createElement('div');
    overlay.className = 'fixed inset-0 z-[60] bg-black bg-opacity-80 flex items-center justify-center cursor-pointer';
    overlay.onclick = () => overlay.remove();
    overlay.innerHTML = `<img src="${url}" class="max-w-[90vw] max-h-[90vh] object-contain">`;
    document.body.appendChild(overlay);
}

function debouncePageSearch() {
    clearTimeout(mlSearchTimeout);
    mlSearchTimeout = setTimeout(loadMediaPage, 300);
}

function openEditModal(imageId) {
    const image = mlAllImages.find(img => img.id === imageId);
    if (!image) return;

    mlEditingId = imageId;
    mlReplaceFile = null;

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

function closeEditModal() {
    document.getElementById('edit-image-modal').classList.add('hidden');
    mlEditingId = null;
    mlReplaceFile = null;
}

function handleReplacePreview(files) {
    if (!files || files.length === 0) return;
    const file = files[0];
    mlReplaceFile = file;
    const reader = new FileReader();
    reader.onload = (e) => {
        document.getElementById('edit-replace-img').src = e.target.result;
        document.getElementById('edit-replace-name').textContent = file.name;
        document.getElementById('edit-replace-content').classList.add('hidden');
        document.getElementById('edit-replace-preview').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

function saveImageEdit() {
    if (!mlEditingId) return;
    const formData = new FormData();
    formData.append('alt', document.getElementById('edit-image-alt').value);
    formData.append('title', document.getElementById('edit-image-title').value);
    formData.append('_method', 'PUT');
    if (mlReplaceFile) formData.append('replace_file', mlReplaceFile);

    fetch('/admin/media-library/' + mlEditingId, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' },
        body: formData,
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeEditModal();
            loadMediaPage();
        }
    })
    .catch(err => console.error('Save failed:', err));
}

document.addEventListener('DOMContentLoaded', function() {
    loadMediaPage();

    const replaceZone = document.getElementById('edit-replace-drop-zone');
    if (replaceZone) {
        replaceZone.addEventListener('click', () => document.getElementById('edit-replace-file').click());
        replaceZone.addEventListener('dragover', (e) => { e.preventDefault(); replaceZone.classList.add('border-blue-500', 'bg-blue-50'); });
        replaceZone.addEventListener('dragleave', () => { replaceZone.classList.remove('border-blue-500', 'bg-blue-50'); });
        replaceZone.addEventListener('drop', (e) => {
            e.preventDefault();
            replaceZone.classList.remove('border-blue-500', 'bg-blue-50');
            if (e.dataTransfer.files.length > 0) handleReplacePreview(e.dataTransfer.files);
        });
    }
});
</script>
@endsection
