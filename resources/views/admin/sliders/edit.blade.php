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
            @if($slider->image)
            <div class="mb-2">
                <img src="{{ $slider->image }}" alt="" class="w-48 h-32 object-cover rounded-lg">
            </div>
            @endif
            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
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
@endsection