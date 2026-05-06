<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-14">
            <span class="inline-block px-4 py-1.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-full mb-4">Testimonials</span>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900">What our clients say</h2>
            <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto">Real feedback from real customers who trust us with their printing needs</p>
        </div>
        <div class="relative">
            <div class="overflow-hidden" id="testimonial-slider">
                <div class="flex transition-transform duration-500" id="testimonial-track">
                    @php
                    $testimonialLimit = $limit ?? 6;
                    $testimonials = \App\Models\Testimonial::where('is_active', true)
                        ->orderBy('created_at', 'desc')
                        ->take($testimonialLimit)
                        ->get();

                    if($testimonials->isEmpty()) {
                        $testimonials = collect([
                            (object)['name' => 'Jashandeep Rai', 'company' => 'Customer', 'message' => 'Great printing shop in Brampton. Reasonable price. Friendly staff.', 'rating' => 5],
                            (object)['name' => 'Nathan.rr14', 'company' => 'Customer', 'message' => 'Very respectful people easy communication and fast work', 'rating' => 5],
                            (object)['name' => 'Alina Art', 'company' => 'Customer', 'message' => 'Friendly staff and good quality services available here.', 'rating' => 5],
                            (object)['name' => 'Sukhpal Brar', 'company' => 'Customer', 'message' => 'Professional service at reasonable price.', 'rating' => 5],
                            (object)['name' => 'Aqib Khan', 'company' => 'Customer', 'message' => 'Exactly what I was looking for at a decent price!', 'rating' => 5],
                            (object)['name' => 'Seema Kumari', 'company' => 'Customer', 'message' => 'Exceptional customer services at reasonable prices.', 'rating' => 5],
                        ]);
                    }
                    @endphp

                    @foreach($testimonials as $testimonial)
                        <div class="flex-shrink-0 w-full md:w-1/2 lg:w-1/3 px-3">
                            <div class="bg-gray-50 p-8 rounded-2xl h-full border border-gray-100 hover:shadow-lg transition-all duration-300">
                                <div class="flex gap-1 mb-4">
                                    @for($i = 0; $i < ($testimonial->rating ?? 5); $i++)
                                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <p class="text-gray-600 mb-6 leading-relaxed">"{{ $testimonial->message }}"</p>
                                <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-lg shadow-md">
                                        {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">{{ $testimonial->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $testimonial->company ?? 'Customer' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <button id="testimonial-prev" class="absolute -left-5 top-1/2 -translate-y-1/2 w-12 h-12 bg-white shadow-lg rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors border border-gray-200">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button id="testimonial-next" class="absolute -right-5 top-1/2 -translate-y-1/2 w-12 h-12 bg-white shadow-lg rounded-full flex items-center justify-center hover:bg-gray-50 transition-colors border border-gray-200">
                <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>
        <div class="flex justify-center gap-2 mt-8" id="testimonial-dots"></div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('testimonial-track');
    const prevBtn = document.getElementById('testimonial-prev');
    const nextBtn = document.getElementById('testimonial-next');
    const dotsContainer = document.getElementById('testimonial-dots');
    const slides = track.children;
    const slidesPerView = window.innerWidth >= 1024 ? 3 : window.innerWidth >= 768 ? 2 : 1;
    const totalSlides = slides.length;
    const totalDots = Math.ceil(totalSlides / slidesPerView);
    let currentIndex = 0;

    for (let i = 0; i < totalDots; i++) {
        const dot = document.createElement('button');
        dot.className = 'w-2 h-2 rounded-full transition-all duration-300 ' + (i === 0 ? 'bg-blue-600 w-6' : 'bg-gray-300');
        dot.onclick = () => goToSlide(i);
        dotsContainer.appendChild(dot);
    }

    function updateSlider() {
        const slideWidth = 100 / slidesPerView;
        track.style.transform = `translateX(-${currentIndex * slideWidth}%)`;
        Array.from(dotsContainer.children).forEach((dot, i) => {
            dot.className = 'w-2 h-2 rounded-full transition-all duration-300 ' + (i === currentIndex ? 'bg-blue-600 w-6' : 'bg-gray-300');
        });
    }

    function goToSlide(index) {
        currentIndex = Math.max(0, Math.min(index, totalDots - 1));
        updateSlider();
    }

    prevBtn.onclick = () => goToSlide(currentIndex - 1);
    nextBtn.onclick = () => goToSlide(currentIndex + 1);

    let touchStartX = 0;
    track.ontouchstart = e => touchStartX = e.touches[0].clientX;
    track.ontouchend = e => {
        if (touchStartX - e.changedTouches[0].clientX > 50) goToSlide(currentIndex + 1);
        if (e.changedTouches[0].clientX - touchStartX > 50) goToSlide(currentIndex - 1);
    };
});
</script>
@endpush
