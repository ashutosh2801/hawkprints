@extends('layouts.app')

@section('title', 'About Us - Five Rivers Print')
@section('meta_description', 'Learn about Five Rivers Print - your trusted partner for quality printing services. Discover our story, mission, and commitment to excellence.')

@section('content')
<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-center mb-8">About Five Rivers Print</h1>
        <div class="max-w-3xl mx-auto text-center">
            <p class="text-lg text-gray-700 mb-6">
                Five Rivers Print has been helping business owners, professionals, entrepreneurs, and individuals create their custom designs and professional marketing through our products since 2015.
            </p>
            <p class="text-lg text-gray-700 mb-6">
                If you can dream about it, we're going to make it happen. Our products let you add your personal touch to any part of your life.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Competitively Priced</h3>
                <p class="text-gray-600">To offer competitively priced products without compromising on quality.</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Quick Turnaround</h3>
                <p class="text-gray-600">No compromise with quality even for one-day services.</p>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="w-16 h-16 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.357-1.739-1-2.375l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Creative Excellence</h3>
                <p class="text-gray-600">Putting more and more efforts in creating work that's unique and interesting.</p>
            </div>
        </div>
    </div>
</div>
@endsection