<section class="py-16 bg-gray-50 border-t border-gray-200">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <span class="inline-block px-4 py-1.5 bg-blue-50 text-blue-700 text-sm font-medium rounded-full mb-4">Trusted By</span>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">{{ $heading ?? 'Our clients and partners' }}</h2>
        </div>
        <div class="relative overflow-hidden">
            <div class="flex animate-scroll">
                @php
                $clients = [
                    'Artboard 4' => 'https://fiveriversprint.ca/wp-content/uploads/2023/03/Artboard-4.png',
                    'logo-stoke' => 'https://fiveriversprint.ca/wp-content/uploads/2023/03/logo-stoke-300x200.png',
                    'DOS' => 'https://fiveriversprint.ca/wp-content/uploads/2023/03/DOS.png',
                    'Fedex' => 'https://fiveriversprint.ca/wp-content/uploads/2023/03/Fedex.png',
                    'MS' => 'https://fiveriversprint.ca/wp-content/uploads/2023/03/MS.png',
                    'Remax' => 'https://fiveriversprint.ca/wp-content/uploads/2023/03/Remax.png',
                    'Royalle' => 'https://fiveriversprint.ca/wp-content/uploads/2023/03/Royalle.png',
                    'UPS' => 'https://fiveriversprint.ca/wp-content/uploads/2023/03/UPS.png',
                    'Xerox' => 'https://fiveriversprint.ca/wp-content/uploads/2023/03/Xerox.png',
                    'Creekside' => 'https://fiveriversprint.ca/wp-content/uploads/2023/03/Creekside.png',
                ];
                @endphp

                @foreach($clients as $name => $image)
                    <div class="flex-shrink-0 w-40 px-6">
                        <div class="h-16 flex items-center justify-center">
                            <img src="{{ $image }}" alt="{{ $name }}" class="max-w-full max-h-full object-contain grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        </div>
                    </div>
                @endforeach
                @foreach($clients as $name => $image)
                    <div class="flex-shrink-0 w-40 px-6">
                        <div class="h-16 flex items-center justify-center">
                            <img src="{{ $image }}" alt="{{ $name }}" class="max-w-full max-h-full object-contain grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                        </div>
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
