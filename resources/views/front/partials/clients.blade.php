<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Our Clients and Partners</h2>
        <div class="flex flex-wrap justify-center items-center gap-8">
            @php
            $clients = [
                'Artboard 4' => 'https://hawkprints.ca/wp-content/uploads/2023/03/Artboard-4.png',
                'logo-stoke' => 'https://hawkprints.ca/wp-content/uploads/2023/03/logo-stoke-300x200.png',
                'DOS' => 'https://hawkprints.ca/wp-content/uploads/2023/03/DOS.png',
                'Fedex' => 'https://hawkprints.ca/wp-content/uploads/2023/03/Fedex.png',
                'MS' => 'https://hawkprints.ca/wp-content/uploads/2023/03/MS.png',
                'Remax' => 'https://hawkprints.ca/wp-content/uploads/2023/03/Remax.png',
                'Royalle' => 'https://hawkprints.ca/wp-content/uploads/2023/03/Royalle.png',
                'UPS' => 'https://hawkprints.ca/wp-content/uploads/2023/03/UPS.png',
                'Xerox' => 'https://hawkprints.ca/wp-content/uploads/2023/03/Xerox.png',
                'Creekside' => 'https://hawkprints.ca/wp-content/uploads/2023/03/Creekside.png',
            ];
            @endphp

            @foreach($clients as $name => $image)
                <div class="w-32 h-20 flex items-center justify-center">
                    <img src="{{ $image }}" alt="{{ $name }}" class="max-w-full max-h-full object-contain grayscale hover:grayscale-0 transition-all">
                </div>
            @endforeach
        </div>
    </div>
</section>