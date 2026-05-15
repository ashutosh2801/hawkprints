<section class="py-12 bg-gray-50 border-t border-gray-200 relative overflow-hidden">
    <!-- Decorative background icons -->
    <div class="absolute inset-0 pointer-events-none select-none">
        <svg class="absolute top-4 left-8 w-8 h-8 text-blue-200/40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        <svg class="absolute top-12 right-12 w-6 h-6 text-blue-300/30" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        <svg class="absolute bottom-8 left-16 w-5 h-5 text-blue-200/30" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        <svg class="absolute bottom-12 right-24 w-7 h-7 text-blue-300/25" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
        <svg class="absolute top-1/3 right-8 w-4 h-4 text-blue-200/25" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg>
        <svg class="absolute top-2/3 left-12 w-4 h-4 text-blue-300/25" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2z"/></svg>
    </div>

    <div class="container mx-auto px-4 relative">
        <div class="text-center mb-8">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-full mb-4">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                Trusted By
            </span>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $heading ?? 'Our clients and partners' }}</h2>
        </div>
        <div class="relative overflow-hidden rounded-2xl bg-white/50 backdrop-blur-sm border border-gray-100 py-8">
            <!-- Left fade overlay -->
            <div class="absolute left-0 top-0 bottom-0 w-16 bg-gradient-to-r from-white/80 to-transparent z-10 pointer-events-none"></div>
            <!-- Right fade overlay -->
            <div class="absolute right-0 top-0 bottom-0 w-16 bg-gradient-to-l from-white/80 to-transparent z-10 pointer-events-none"></div>

            <div class="flex animate-scroll">
                @php
                $hasCustomClients = isset($clients) && is_array($clients) && count($clients) > 0 && isset($clients[0]['name']);
                if (!$hasCustomClients):
                    $fallbackClients = [
                        'Artboard 4' => '<svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8"/><path d="M12 17v4"/></svg>',
                        'logo-stoke' => '<svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/></svg>',
                        'DOS' => '<svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>',
                        'Fedex' => '<svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>',
                        'MS' => '<svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><rect x="2" y="2" width="8" height="8" rx="1"/><rect x="14" y="2" width="8" height="8" rx="1"/><rect x="2" y="14" width="8" height="8" rx="1"/><rect x="14" y="14" width="8" height="8" rx="1"/></svg>',
                        'Remax' => '<svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                        'Royalle' => '<svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>',
                        'UPS' => '<svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 002 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/><circle cx="12" cy="12" r="3"/></svg>',
                        'Xerox' => '<svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M4 7V4h16v3"/><path d="M9 20h6"/><path d="M12 4v16"/></svg>',
                        'Creekside' => '<svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M3 21h18"/><path d="M3 10h18"/><path d="M5 6l7-3 7 3"/><path d="M4 10v11"/><path d="M20 10v11"/><path d="M8 14v.01"/><path d="M12 14v.01"/><path d="M16 14v.01"/></svg>',
                    ];
                endif;
                $items = $hasCustomClients ? $clients : $fallbackClients;
                @endphp

                @foreach($items as $key => $item)
                    @php
                        $cName = $hasCustomClients ? ($item['name'] ?? 'Client') : $key;
                        $cImage = $hasCustomClients ? ($item['image'] ?? '') : '';
                    @endphp
                    <div class="flex-shrink-0 w-40 px-6 flex flex-col items-center gap-2 group">
                        <div class="h-16 flex items-center justify-center grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                            @if($hasCustomClients && $cImage)
                                <img src="{{ $cImage }}" alt="{{ $cName }}" class="max-w-full max-h-full object-contain">
                            @elseif(!$hasCustomClients)
                                <div class="text-gray-400 group-hover:text-blue-600 transition-colors duration-300">
                                    {!! $item !!}
                                </div>
                            @else
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-300">
                                    <span class="text-xl font-bold text-gray-400 group-hover:text-blue-600">{{ substr($cName, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <span class="text-xs font-medium text-gray-400 group-hover:text-blue-600 transition-colors duration-300">{{ $cName }}</span>
                        <svg class="w-4 h-4 text-blue-300/50 group-hover:text-blue-500 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                    </div>
                @endforeach
                @foreach($items as $key => $item)
                    @php
                        $cName = $hasCustomClients ? ($item['name'] ?? 'Client') : $key;
                        $cImage = $hasCustomClients ? ($item['image'] ?? '') : '';
                    @endphp
                    <div class="flex-shrink-0 w-40 px-6 flex flex-col items-center gap-2 group">
                        <div class="h-16 flex items-center justify-center grayscale opacity-60 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-300">
                            @if($hasCustomClients && $cImage)
                                <img src="{{ $cImage }}" alt="{{ $cName }}" class="max-w-full max-h-full object-contain">
                            @elseif(!$hasCustomClients)
                                <div class="text-gray-400 group-hover:text-blue-600 transition-colors duration-300">
                                    {!! $item !!}
                                </div>
                            @else
                                <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-300">
                                    <span class="text-xl font-bold text-gray-400 group-hover:text-blue-600">{{ substr($cName, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <span class="text-xs font-medium text-gray-400 group-hover:text-blue-600 transition-colors duration-300">{{ $cName }}</span>
                        <svg class="w-4 h-4 text-blue-300/50 group-hover:text-blue-500 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('scripts')
<style>
@keyframes scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.animate-scroll {
    animation: scroll 30s linear infinite;
}
.animate-scroll:hover {
    animation-play-state: paused;
}
</style>
@endpush
