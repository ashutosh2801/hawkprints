@extends('admin.layout')

@section('page-title', 'Edit Slider')

@section('content')
<form action="/admin/sliders/{{ $slider->id }}" method="POST" enctype="multipart/form-data" class="max-w-2xl">
    @csrf @method('PUT')

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
            <input type="text" name="title" value="{{ $slider->title }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
            <input type="text" name="subtitle" value="{{ $slider->subtitle }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Link URL</label>
            <input type="url" name="link_url" value="{{ $slider->link_url }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
            <input type="text" name="button_text" value="{{ $slider->button_text }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
            <div class="flex items-start gap-4">
                <div id="slider-image-preview" class="w-48 h-32 border-2 border-dashed border-gray-300 rounded-lg overflow-hidden flex items-center justify-center bg-gray-50">
                    @if($slider->image)
                    <img src="{{ $slider->image }}" alt="" class="w-full h-full object-cover">
                    @else
                    <span class="text-gray-400 text-sm">No image</span>
                    @endif
                </div>
                <div class="space-y-2">
                    <button type="button" onclick="selectFromLibrary('slider')" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                        Choose from Library
                    </button>
                    <input type="hidden" name="image_url" id="slider-image-url" value="{{ $slider->image ?? '' }}">
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Active</label>
            <input type="checkbox" name="is_active" value="1" {{ $slider->is_active ? 'checked' : '' }} class="w-4 h-4">
        </div>
    </div>

    <div class="mt-6 flex gap-4">
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
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
