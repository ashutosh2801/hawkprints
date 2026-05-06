@extends('admin.layout')

@section('page-title', 'Sliders')

@section('content')
<div class="mb-6">
    <a href="/admin/sliders/create" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Slider
    </a>
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
                <a href="/admin/sliders/{{ $slider->id }}/edit" class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition" title="Edit">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </a>
                <form action="/admin/sliders/{{ $slider->id }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Delete" onclick="return confirm('Delete?')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-4">{{ $sliders->links() }}
@endsection