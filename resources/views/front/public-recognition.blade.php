@extends('layouts.app')

@section('title', 'Public Recognition - Five Rivers Print')
@section('meta_description', 'Discover awards, certifications, and public recognition received by Five Rivers Print for quality printing services.')

@section('content')
<div class="bg-gray-100 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-8 lg:p-12">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold mb-4">Public Recognition</h1>
                <p class="text-gray-600 text-lg">Awards, certifications, and community recognition</p>
            </div>

            <div class="prose prose-lg max-w-none text-gray-700">
                <p class="mb-6">
                    At Five Rivers Print, we take pride in the recognition we have received from our clients, industry peers, and the community. Our commitment to quality and customer satisfaction has been acknowledged through various channels.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">Industry Recognition</h2>
                <p class="mb-4">
                    Over the years, Five Rivers Print has built a reputation for excellence in the printing industry. Our dedication to using the latest technology and maintaining high production standards has earned us respect among our peers and clients alike.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 my-8">
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <div class="w-16 h-16 mx-auto bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Quality Excellence</h3>
                        <p class="text-sm text-gray-600">Recognized for consistent high-quality printing standards since 2015</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-bold text-lg mb-2">Customer Trust</h3>
                        <p class="text-sm text-gray-600">Serving hundreds of businesses across Ontario with reliable service</p>
                    </div>
                </div>

                <h2 class="text-2xl font-bold mt-8 mb-4">Community Involvement</h2>
                <p class="mb-4">
                    We believe in giving back to the community that has supported us. Five Rivers Print actively participates in local community events and supports small businesses in the Greater Toronto Area.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">Client Testimonials</h2>
                <p class="mb-6">
                    Don't just take our word for it. Here is what our clients have to say about working with Five Rivers Print:
                </p>

                <div class="space-y-6 my-8">
                    <div class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-700">
                        <p class="italic text-gray-700 mb-3">
                            "Five Rivers Print has been our go-to printer for all our business cards and marketing materials. The quality is always exceptional, and turnaround time is impressive."
                        </p>
                        <p class="font-semibold text-sm text-gray-600">— Business Owner, Brampton</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-700">
                        <p class="italic text-gray-700 mb-3">
                            "We needed custom banners for our event on short notice, and Five Rivers Print delivered beyond our expectations. Highly recommend!"
                        </p>
                        <p class="font-semibold text-sm text-gray-600">— Event Organizer, Toronto</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-700">
                        <p class="italic text-gray-700 mb-3">
                            "The sublimation work they did on our team apparel was fantastic. Great colors, durable prints, and fair pricing."
                        </p>
                        <p class="font-semibold text-sm text-gray-600">— Sports Club, Mississauga</p>
                    </div>
                </div>

                <h2 class="text-2xl font-bold mt-8 mb-4">Get in Touch</h2>
                <p class="mb-4">
                    Want to learn more about our work or discuss a project? We would love to hear from you.
                </p>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div>
                        <p class="font-semibold text-blue-900">Contact us today</p>
                        <p class="text-sm text-blue-700">info@fiveriversprint.ca | 905-744-0013</p>
                    </div>
                    <a href="/contact" class="px-6 py-2 bg-blue-700 hover:bg-blue-800 text-white rounded-lg font-semibold transition">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
