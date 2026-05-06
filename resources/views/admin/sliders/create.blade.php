@extends('admin.layout')

@section('page-title', 'Add Slider')

@section('content')
<form action="/admin/sliders" method="POST" enctype="multipart/form-data" class="max-w-2xl">
    @csrf

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
            <input type="text" name="subtitle" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Link URL</label>
            <input type="url" name="link_url" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
            <input type="text" name="button_text" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
            <div class="flex items-start gap-4">
                <div id="slider-image-preview" class="w-48 h-32 border-2 border-dashed border-gray-300 rounded-lg overflow-hidden flex items-center justify-center bg-gray-50">
                    <span class="text-gray-400 text-sm">No image</span>
                </div>
                <div class="space-y-2">
                    <button type="button" onclick="selectFromLibrary('slider')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                        Choose from Library
                    </button>
                    <input type="hidden" name="image_url" id="slider-image-url" value="">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Active</label>
            <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4">
        </div>
    </div>

    <div class="mt-6 flex gap-4">
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create</button>
        <a href="/admin/sliders" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</a>
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
