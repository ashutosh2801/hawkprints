<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Shop these customer favourites</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @php
            $favorites = [
                ['image' => 'https://hawkprints.ca/wp-content/uploads/2023/01/Brochures.jpg', 'name' => 'Brochures', 'slug' => 'brochures'],
                ['image' => 'https://hawkprints.ca/wp-content/uploads/2023/01/business-card.jpg', 'name' => 'Business Cards', 'slug' => 'business-cards'],
                ['image' => 'https://hawkprints.ca/wp-content/uploads/2023/01/calanders.jpg', 'name' => 'Calendars', 'slug' => 'calendars'],
                ['image' => 'https://hawkprints.ca/wp-content/uploads/2023/01/Custom-Greeting-Cards.jpg', 'name' => 'Custom Greeting Cards', 'slug' => 'custom-greeting-cards'],
                ['image' => 'https://hawkprints.ca/wp-content/uploads/2023/01/Flyers.jpg', 'name' => 'Flyers', 'slug' => 'flyers'],
                ['image' => 'https://hawkprints.ca/wp-content/uploads/2023/01/postcard.jpg', 'name' => 'Postcards', 'slug' => 'postcards'],
            ];
            @endphp

            @foreach($favorites as $category)
                <a href="{{ route('shop.category', $category['slug']) }}" class="group">
                    <div class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow">
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ $category['image'] }}" alt="{{ $category['name'] }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                        <div class="p-4 text-center">
                            <h3 class="font-semibold text-gray-800 group-hover:text-blue-700">{{ $category['name'] }}</h3>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>