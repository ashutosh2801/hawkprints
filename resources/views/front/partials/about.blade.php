<section class="py-20 bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-10 right-10 w-72 h-72 bg-blue-400 rounded-full filter blur-3xl"></div>
        <div class="absolute bottom-10 left-10 w-72 h-72 bg-purple-400 rounded-full filter blur-3xl"></div>
    </div>
    <div class="container mx-auto px-4 relative">
        <div class="text-center mb-16 max-w-3xl mx-auto">
            <span class="inline-block px-4 py-1.5 bg-white/10 text-white text-sm font-medium rounded-full mb-4 border border-white/20">Why Choose Us</span>
            <h2 class="text-3xl md:text-4xl font-bold mb-6">{{ $heading ?? 'Five Rivers Print: Your printing partner' }}</h2>
            @if(!empty($text))
            <p class="text-lg text-gray-300">{{ $text }}</p>
            @else
            <p class="text-lg text-gray-300">
                Helping businesses and individuals create stunning custom designs and professional marketing materials. If you can dream it, we'll make it happen.
            </p>
            @endif
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
            <div class="group text-center p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-500">
                <div class="w-14 h-14 mx-auto mb-5 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Competitive Pricing</h3>
                <p class="text-sm text-gray-400">Best value without compromising quality</p>
            </div>

            <div class="group text-center p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-500">
                <div class="w-14 h-14 mx-auto mb-5 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Fast Turnaround</h3>
                <p class="text-sm text-gray-400">Same-day service available</p>
            </div>

            <div class="group text-center p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-500">
                <div class="w-14 h-14 mx-auto mb-5 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.357-1.739-1-2.375l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Creative Designs</h3>
                <p class="text-sm text-gray-400">Unique and eye-catching work</p>
            </div>

            <div class="group text-center p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-500">
                <div class="w-14 h-14 mx-auto mb-5 bg-gradient-to-br from-amber-400 to-amber-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Premium Quality</h3>
                <p class="text-sm text-gray-400">Exceeding expectations every time</p>
            </div>

            <div class="group text-center p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-500">
                <div class="w-14 h-14 mx-auto mb-5 bg-gradient-to-br from-pink-400 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold mb-2">Happy Clients</h3>
                <p class="text-sm text-gray-400">Your satisfaction matters most</p>
            </div>
        </div>
    </div>
</section>
