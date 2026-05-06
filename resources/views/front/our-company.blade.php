@extends('layouts.app')

@section('title', 'Our Company - Hawk Prints')

@section('content')
<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-blue-700 text-white py-12 px-8">
                    <h1 class="text-4xl font-bold mb-4">Our Company</h1>
                    <p class="text-blue-100 text-lg">Quality printing solutions since 2015</p>
                </div>

                <div class="p-8 lg:p-12">
                    <div class="prose prose-lg max-w-none text-gray-700">
                        <p class="text-lg leading-relaxed mb-6">
                            Hawk Prints has been helping business owners, professionals, entrepreneurs, and individuals create custom designs and professional marketing materials since 2015. Based in Brampton, Ontario, we are proud to serve clients across Canada with high-quality printing products and services.
                        </p>

                        <p class="text-lg leading-relaxed mb-6">
                            We believe that quality shouldn't come at an unreasonable price. While we may not be the cheapest option in the market, we pride ourselves on delivering the best quality products that help your business stand out. Every order is handled with care and attention to detail.
                        </p>

                        <h2 class="text-2xl font-bold mt-10 mb-4">Our Mission</h2>
                        <p class="leading-relaxed mb-6">
                            To provide businesses and individuals with premium printing solutions that help them make lasting impressions. We are committed to combining cutting-edge technology with exceptional customer service to deliver products that exceed expectations.
                        </p>

                        <h2 class="text-2xl font-bold mt-10 mb-4">What We Offer</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Business Cards</h4>
                                    <p class="text-sm text-gray-500">Professional cards in various finishes</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Banners & Signs</h4>
                                    <p class="text-sm text-gray-500">Indoor and outdoor displays</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Marketing Materials</h4>
                                    <p class="text-sm text-gray-500">Flyers, brochures, and more</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-semibold">Apparel Printing</h4>
                                    <p class="text-sm text-gray-500">Custom t-shirts and sublimation</p>
                                </div>
                            </div>
                        </div>

                        <h2 class="text-2xl font-bold mt-10 mb-4">Our Values</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 my-8">
                            <div class="text-center p-6 bg-gray-50 rounded-lg">
                                <div class="w-14 h-14 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-7 h-7 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold mb-2">Quality First</h3>
                                <p class="text-sm text-gray-600">Every product meets our high standards</p>
                            </div>
                            <div class="text-center p-6 bg-gray-50 rounded-lg">
                                <div class="w-14 h-14 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-7 h-7 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold mb-2">Customer Focus</h3>
                                <p class="text-sm text-gray-600">Your satisfaction is our priority</p>
                            </div>
                            <div class="text-center p-6 bg-gray-50 rounded-lg">
                                <div class="w-14 h-14 mx-auto bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-7 h-7 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold mb-2">Fast Delivery</h3>
                                <p class="text-sm text-gray-600">Quick turnaround without compromise</p>
                            </div>
                        </div>

                        <h2 class="text-2xl font-bold mt-10 mb-4">Get in Touch</h2>
                        <p class="leading-relaxed mb-4">
                            Ready to start your next project? We'd love to hear from you. Reach out to us for a custom quote or to discuss your printing needs.
                        </p>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                            <div>
                                <p class="font-semibold text-blue-900">Contact us today</p>
                                <p class="text-sm text-blue-700">info@hawkprints.ca | 905-744-0013</p>
                            </div>
                            <a href="/contact" class="px-6 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-semibold transition">
                                Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
