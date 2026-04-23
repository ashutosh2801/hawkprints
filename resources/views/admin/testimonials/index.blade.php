@extends('admin.layout')

@section('page-title', 'Testimonials')

@section('content')
<div class="mb-6">
    <a href="/admin/testimonials/create" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">+ Add Testimonial</a>
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
            <a href="/admin/testimonials/{{ $testimonial->id }}/edit" class="text-blue-600 hover:underline">Edit</a>
            <form action="/admin/testimonials/{{ $testimonial->id }}" method="POST" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="text-blue-600 hover:underline" onclick="return confirm('Delete?')">Delete</button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-4">{{ $testimonials->links() }}
@endsection