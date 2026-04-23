@extends('admin.layout')

@section('page-title', 'Categories')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <form action="/admin/categories" method="GET" class="flex gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..." class="px-4 py-2 border border-gray-300 rounded-lg">
        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700">Filter</button>
    </form>
    <a href="/admin/categories/create" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Add Category</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Products</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($categories as $category)
            <tr>
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        @if($category->image)
                        <img src="{{ $category->image }}" alt="" class="w-12 h-12 object-cover rounded-lg mr-4">
                        @else
                        <div class="w-12 h-12 bg-gray-100 rounded-lg mr-4"></div>
                        @endif
                        <div>
                            <p class="font-medium">{{ $category->name }}</p>
                            <p class="text-sm text-gray-500">{{ $category->slug }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-600">{{ $category->products_count ?? 0 }}</td>
                <td class="px-6 py-4">
                    @if($category->is_active)
                    <span class="text-green-600">Active</span>
                    @else
                    <span class="text-gray-400">Inactive</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <a href="/admin/categories/{{ $category->id }}/edit" class="text-blue-600 hover:underline mr-3">Edit</a>
                    <form action="/admin/categories/{{ $category->id }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-blue-600 hover:underline" onclick="return confirm('Delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $categories->links() }}</div>
@endsection