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
            <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ $category->description }}</textarea>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category Image</label>
            @if($category->image)
            <div class="mb-2">
                <img src="{{ $category->image }}" alt="" class="w-24 h-24 object-cover rounded-lg">
            </div>
            @endif
            <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Active</label>
            <input type="checkbox" name="is_active" value="1" {{ $category->is_active ? 'checked' : '' }} class="w-4 h-4">
        </div>
    </div>
    
    <div class="mt-6 flex gap-4">
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update Category</button>
        <a href="/admin/categories" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</a>
    </div>
</form>
@endsection