<section class="relative overflow-hidden" x-data="{ activeSlide: 0 }">
    <div class="flex transition-transform duration-500" :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">
        @php
        $sliders = \App\Models\Slider::where('is_active', true)->orderBy('sort_order')->get();
        if($sliders->isEmpty()) {
            $sliders = collect([
                (object)['image' => 'https://hawkprints.ca/wp-content/uploads/2025/01/Banner-2025-01-scaled.jpg', 'title' => 'Premium Business Cards', 'content' => 'Make a lasting impression', 'button_text' => 'Shop Now', 'link' => route('shop.category', 'business-cards')],
                (object)['image' => 'https://hawkprints.ca/wp-content/uploads/2025/01/Banner-2025-02-scaled.jpg', 'title' => 'Marketing Materials', 'content' => 'Grow your business', 'button_text' => 'View Products', 'link' => route('shop.category', 'marketing')],
                (object)['image' => 'https://hawkprints.ca/wp-content/uploads/2025/01/Banner-2025-03-scaled.jpg', 'title' => 'Large Format Printing', 'content' => 'Eye-catching displays', 'button_text' => 'Explore', 'link' => route('shop.category', 'large-format')],
            ]);
        }
        @endphp

        @foreach($sliders as $index => $slider)
            <div class="w-full flex-shrink-0">
                <div class="relative h-[400px] md:h-[500px] lg:h-[600px]">
                    <img src="{{ $slider->image }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center">
                        <div class="container mx-auto px-4">
                            <div class="text-white max-w-lg">
                                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">{{ $slider->title }}</h1>
                                <p class="text-xl md:text-2xl mb-6">{{ $slider->content }}</p>
                                @if($slider->button_text)
                                    <a href="{{ $slider->link ?? route('shop') }}" class="inline-block px-8 py-3 bg-blue-700 hover:bg-blue-800 rounded font-semibold text-white">
                                        {{ $slider->button_text }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button @click="activeSlide = activeSlide === 0 ? {{ count($sliders) - 1 }} : activeSlide - 1" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full flex items-center justify-center shadow-lg">
        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    <button @click="activeSlide = activeSlide === {{ count($sliders) - 1 }} ? 0 : activeSlide + 1" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white bg-opacity-80 hover:bg-opacity-100 rounded-full flex items-center justify-center shadow-lg">
        <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
        @foreach($sliders as $index => $slider)
            <button @click="activeSlide = {{ $index }}" class="w-3 h-3 rounded-full transition-colors" :class="activeSlide === {{ $index }} ? 'bg-white' : 'bg-white bg-opacity-50'"></button>
        @endforeach
    </div>
</section>