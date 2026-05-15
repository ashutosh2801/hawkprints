@php
        $sliders = \App\Models\Slider::where('is_active', true)->orderBy('sort_order')->get();
        if($sliders->isEmpty()) {
            $sliders = collect([
                (object)['image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1920&h=600&fit=crop&q=80', 'title' => 'Premium Business Cards', 'content' => 'Make a lasting impression', 'button_text' => 'Shop Now', 'link' => route('shop.category', 'business-cards')],
                (object)['image' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?w=1920&h=600&fit=crop&q=80', 'title' => 'Marketing Materials', 'content' => 'Grow your business', 'button_text' => 'View Products', 'link' => route('shop.category', 'marketing')],
                (object)['image' => 'https://images.unsplash.com/photo-1562564055-71e051d33c19?w=1920&h=600&fit=crop&q=80', 'title' => 'Large Format Printing', 'content' => 'Eye-catching displays', 'button_text' => 'Explore', 'link' => route('shop.category', 'large-format')],
            ]);
        }
$slideCount = count($sliders);
$lastSlideIndex = max(0, $slideCount - 1);
$autoPlayEnabled = !isset($auto_play) || $auto_play;
@endphp

<section class="relative overflow-hidden" x-data="{ activeSlide: 0, autoPlay: {{ $autoPlayEnabled ? 'true' : 'false' }}, interval: null }" x-init="if (autoPlay) { interval = setInterval(() => { activeSlide = activeSlide === {{ $lastSlideIndex }} ? 0 : activeSlide + 1 }, 5000) }" @mouseenter="if (interval) clearInterval(interval)" @mouseleave="if (autoPlay) { interval = setInterval(() => { activeSlide = activeSlide === {{ $lastSlideIndex }} ? 0 : activeSlide + 1 }, 5000) }">
    <div class="flex transition-transform duration-700 ease-in-out" :style="'transform: translateX(-' + (activeSlide * 100) + '%)'">
        @foreach($sliders as $index => $slider)
            <div class="w-full flex-shrink-0">
                <div class="relative h-[320px] md:h-[384px] lg:h-[448px]">
                    <img src="{{ $slider->image }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/40 to-transparent"></div>
                    <div class="absolute inset-0 flex items-center">
                        <div class="container mx-auto px-4">
                            <div class="max-w-2xl">
                                <span class="inline-block px-4 py-1.5 bg-white/20 backdrop-blur-sm text-white text-sm font-medium rounded-full mb-6 border border-white/30">Premium Printing Services</span>
                                <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold mb-6 text-white leading-tight">{{ $slider->title }}</h1>
                                <p class="text-lg md:text-xl lg:text-2xl mb-8 text-gray-200 font-light">{{ $slider->content }}</p>
                                @if($slider->button_text)
                                    <a href="{{ $slider->link ?? route('shop') }}" class="group inline-flex items-center gap-3 px-8 py-4 bg-white text-gray-900 rounded-full font-semibold hover:bg-gray-100 transition-all duration-300 shadow-lg hover:shadow-xl">
                                        {{ $slider->button_text }}
                                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button @click="activeSlide = activeSlide === 0 ? {{ $lastSlideIndex }} : activeSlide - 1; if (interval) { clearInterval(interval); if (autoPlay) { interval = setInterval(() => { activeSlide = activeSlide === {{ $lastSlideIndex }} ? 0 : activeSlide + 1 }, 5000) } }" class="absolute left-6 top-1/2 -translate-y-1/2 w-14 h-14 bg-white/20 backdrop-blur-sm hover:bg-white/40 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 border border-white/30">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    <button @click="activeSlide = activeSlide === {{ $lastSlideIndex }} ? 0 : activeSlide + 1; if (interval) { clearInterval(interval); if (autoPlay) { interval = setInterval(() => { activeSlide = activeSlide === {{ $lastSlideIndex }} ? 0 : activeSlide + 1 }, 5000) } }" class="absolute right-6 top-1/2 -translate-y-1/2 w-14 h-14 bg-white/20 backdrop-blur-sm hover:bg-white/40 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 border border-white/30">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3">
        @foreach($sliders as $index => $slider)
            <button @click="activeSlide = {{ $index }}; if (interval) { clearInterval(interval); if (autoPlay) { interval = setInterval(() => { activeSlide = activeSlide === {{ $lastSlideIndex }} ? 0 : activeSlide + 1 }, 5000) } }" class="transition-all duration-300 rounded-full" :class="activeSlide === {{ $index }} ? 'w-8 h-2 bg-white' : 'w-2 h-2 bg-white/50 hover:bg-white/70'"></button>
        @endforeach
    </div>
</section>
