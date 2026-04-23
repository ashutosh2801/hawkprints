<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">What Clients Say About Us</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $testimonials = \App\Models\Testimonial::where('is_active', true)->take(6)->get();

            if($testimonials->isEmpty()) {
                $testimonials = collect([
                    (object)['name' => 'Jashandeep Rai', 'title' => 'Customer', 'content' => 'Great printing shop in Brampton. Reasonable price. Friendly staff. They satisfied the customers need. You can get anything printed from them... highly recommended!', 'rating' => 5],
                    (object)['name' => 'Nathan.rr14', 'title' => 'Customer', 'content' => 'Very respectful people easy communication and fast work', 'rating' => 5],
                    (object)['name' => 'Alina Art', 'title' => 'Customer', 'content' => 'Friendly staff and good quality services available here. Would recommend this place for all your services!', 'rating' => 5],
                    (object)['name' => 'Sukhpal Brar', 'title' => 'Customer', 'content' => 'Provide professional service at reasonable price. If you are looking for quality work, this is the right place to visit.', 'rating' => 5],
                    (object)['name' => 'Aqib Khan', 'title' => 'Customer', 'content' => 'They had exactly what I was looking for and it was at a fairly decent price!', 'rating' => 5],
                    (object)['name' => 'Seema Kumari', 'title' => 'Customer', 'content' => 'Provide exceptional customer services in decent and disciplined environment at reasonable prices. Must visit this place!', 'rating' => 5],
                ]);
            }
            @endphp

            @foreach($testimonials as $testimonial)
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-xl font-bold text-gray-600">
                            {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-semibold">{{ $testimonial->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $testimonial->title ?? 'Customer' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-1 mb-3">
                        @for($i = 0; $i < ($testimonial->rating ?? 5); $i++)
                            <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 italic">"{{ $testimonial->content }}"</p>
                </div>
            @endforeach
        </div>
    </div>
</section>