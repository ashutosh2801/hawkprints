@extends('admin.layout')

@section('page-title', 'Testimonials')

@section('content')
<div class="mb-6">
    <a href="/admin/testimonials/create" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Testimonial
    </a>
</div>

<div class="grid grid-cols-3 gap-6">
    @foreach($testimonials as $testimonial)
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center mb-4">
            @if($testimonial->avatar)
            <img src="{{ $testimonial->avatar }}" alt="" class="w-12 h-12 rounded-full object-cover mr-4">
            @endif
            <div>
                <p class="font-medium">{{ $testimonial->name }}</p>
                <p class="text-sm text-gray-500">{{ $testimonial->company }}</p>
            </div>
        </div>
        <p class="text-gray-600 mb-4">"{{ $testimonial->message }}"</p>
        <div class="flex gap-2">
            <a href="/admin/testimonials/{{ $testimonial->id }}/edit" class="inline-flex items-center justify-center w-8 h-8 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition" title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </a>
            <form action="/admin/testimonials/{{ $testimonial->id }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Delete" onclick="return confirm('Delete?')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-4">{{ $testimonials->links() }}
@endsection