@extends('admin.layout')

@section('page-title', 'Add Testimonial')

@section('content')
<form action="/admin/testimonials" method="POST" enctype="multipart/form-data" class="max-w-2xl">
    @csrf
    
    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
            <input type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
            <input type="text" name="company" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
            <textarea name="message" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Avatar</label>
            <input type="file" name="avatar" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Active</label>
            <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4">
        </div>
    </div>
    
    <div class="mt-6 flex gap-4">
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Create</button>
        <a href="/admin/testimonials" class="px-6 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</a>
    </div>
</form>
@endsection