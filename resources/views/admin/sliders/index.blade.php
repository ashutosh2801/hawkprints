@extends('admin.layout')

@section('page-title', 'Sliders')

@section('content')
<div class="mb-6">
    <a href="/admin/sliders/create" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Add Slider</a>
</div>

<div class="grid grid-cols-3 gap-6">
    @foreach($sliders as $slider)
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($slider->image)
        <img src="{{ $slider->image }}" alt="" class="w-full h-48 object-cover">
        @endif
        <div class="p-4">
            <h4 class="font-medium">{{ $slider->title }}</h4>
            <p class="text-sm text-gray-500">{{ $slider->subtitle }}</p>
            <div class="flex gap-2 mt-4">
                <a href="/admin/sliders/{{ $slider->id }}/edit" class="text-blue-600 hover:underline">Edit</a>
                <form action="/admin/sliders/{{ $slider->id }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-blue-600 hover:underline" onclick="return confirm('Delete?')">Delete</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-4">{{ $sliders->links() }}
@endsection