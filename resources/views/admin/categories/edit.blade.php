@extends('admin.layout')

@section('page-title', 'Edit Category')

@section('content')
<form action="/admin/categories/{{ $category->id }}" method="POST" enctype="multipart/form-data" class="max-w-2xl">
    @csrf @method('PUT')

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
            <input type="text" name="name" value="{{ $category->name }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea name="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg wysiwyg">{{ $category->description }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category Image</label>
            <div class="flex items-start gap-4">
                <div id="category-image-preview" class="w-32 h-32 border-2 border-dashed border-gray-300 rounded-lg overflow-hidden flex items-center justify-center bg-gray-50">
                    @if($category->image)
                    <img src="{{ $category->image }}" alt="" class="w-full h-full object-cover" id="cat-img-preview">
                    @else
                    <span class="text-gray-400 text-sm">No image</span>
                    @endif
                </div>
                <div class="space-y-2">
                    <button type="button" onclick="selectFromLibrary('category')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                        Choose from Library
                    </button>
                    <input type="hidden" name="image_url" id="category-image-url" value="{{ $category->image ?? '' }}">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Active</label>
            <input type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} class="w-4 h-4">
        </div>

        <hr class="my-6">
        <h3 class="text-lg font-medium mb-4">SEO Settings</h3>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
            <input type="text" name="meta_title" value="{{ $category->meta_title }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="{{ $category->name }} - {{ \App\Models\Setting::get('company_name', 'Five Rivers Print') }}">
            <small class="text-gray-500">Recommended: 50-60 characters. Leave blank to use category name.</small>
        </div>

        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
            <textarea name="meta_description" rows="3" maxlength="160" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Brief description of this category...">{{ $category->meta_description }}</textarea>
            <small class="text-gray-500">Recommended: 150-160 characters</small>
        </div>
    </div>

    <div class="mt-6 flex gap-4">
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Category</button>
        <a href="/admin/categories" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</a>
    </div>
</form>

<script>
function selectFromLibrary(type) {
    openMediaLibrary({
        mode: 'single',
        callback: function(ids) {
            var img = mediaLibraryState.allImages.find(i => i.id === ids[0]);
            if (img) {
                document.getElementById(type + '-image-url').value = img.url;
                document.getElementById(type + '-image-preview').innerHTML = '<img src="' + img.url + '" alt="" class="w-full h-full object-cover">';
            }
        }
    });
}
</script>

@include('admin.partials.media-library')
@endsection
