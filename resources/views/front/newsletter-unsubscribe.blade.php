@extends('layouts.app')

@section('title', 'Newsletter Unsubscribe - Hawk Prints')

@section('content')
<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8 text-center">
            @if($result['success'])
                <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h1 class="text-2xl font-bold mb-4">Unsubscribed</h1>
                <p class="text-gray-600 mb-6">{{ $result['message'] }}</p>
                <p class="text-sm text-gray-500">You can always resubscribe by entering your email on our homepage.</p>
            @else
                <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <h1 class="text-2xl font-bold mb-4">Oops!</h1>
                <p class="text-gray-600 mb-6">{{ $result['message'] }}</p>
            @endif
            <a href="/" class="inline-block mt-4 px-6 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-medium">
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
