<section class="py-16 bg-gray-900 text-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Explore More</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @php
            $exploreItems = [
                ['image' => 'https://hawkprints.ca/wp-content/uploads/2023/01/Letterhead.jpg', 'name' => 'Letterhead', 'slug' => 'letterhead'],
                ['image' => 'https://hawkprints.ca/wp-content/uploads/2023/01/NCR-Forms.jpg', 'name' => 'NCR Forms', 'slug' => 'ncr-forms'],
                ['image' => 'https://hawkprints.ca/wp-content/uploads/2023/01/small-note-pad-49.jpg', 'name' => 'Notepads', 'slug' => 'notepads'],
                ['image' => 'https://hawkprints.ca/wp-content/uploads/2023/01/Presentation-Folders.jpg', 'name' => 'Presentation Folders', 'slug' => 'presentation-folders'],
            ];
            @endphp

            @foreach($exploreItems as $item)
                <a href="{{ route('shop.category', $item['slug']) }}" class="group">
                    <div class="rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                        <div class="p-4 bg-gray-800 text-center">
                            <h3 class="font-semibold group-hover:text-blue-500">{{ $item['name'] }}</h3>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>