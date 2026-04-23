<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\PricingOption;
use App\Models\Testimonial;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Category::truncate();
        Product::truncate();
        ProductVariant::truncate();
        PricingOption::truncate();
        Testimonial::truncate();
        Slider::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@hawkprints.ca'],
            [
                'name' => 'Admin',
                'email' => 'admin@hawkprints.ca',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        $businessCards = Category::create([
            'name' => 'Business Cards',
            'slug' => 'business-cards',
            'description' => 'Professional business cards in various styles',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $marketing = Category::create([
            'name' => 'Marketing',
            'slug' => 'marketing',
            'description' => 'Marketing materials like flyers, brochures, postcards',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $largeFormat = Category::create([
            'name' => 'Large Format',
            'slug' => 'large-format',
            'description' => 'Banners, signs, posters and large prints',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $apparel = Category::create([
            'name' => 'Apparels',
            'slug' => 'apparels',
            'description' => 'Custom printed apparel',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        $sublimation = Category::create([
            'name' => 'Sublimation',
            'slug' => 'sublimation',
            'description' => 'Sublimation printing on various products',
            'is_active' => true,
            'sort_order' => 5,
        ]);

        $stationery = Category::create([
            'name' => 'Stationery',
            'slug' => 'stationery',
            'description' => 'Letterheads, notepads, NCR forms',
            'is_active' => true,
            'sort_order' => 6,
        ]);

        // Business Card Product with Pricing Options
        $bc12 = Product::create([
            'name' => '12pt Business Cards - 1 Sided',
            'slug' => '12pt-business-cards-1-sided',
            'category_id' => $businessCards->id,
            'description' => 'Standard 12pt business cards, single-sided printing. Premium quality cardstock with glossy finish.',
            'short_description' => 'Professional 12pt business cards with single-sided printing.',
            'base_price' => 24.99,
            'is_featured' => true,
            'in_stock' => true,
        ]);

        // Create pricing options for business cards
        PricingOption::create([
            'product_id' => $bc12->id,
            'option_name' => 'Select Quantity',
            'option_type' => 'quantity',
            'choices' => ['500 qty', '1000 qty', '2500 qty', '5000 qty'],
            'prices' => [24.99, 39.99, 79.99, 119.99],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        PricingOption::create([
            'product_id' => $bc12->id,
            'option_name' => 'Card Type',
            'option_type' => 'paper',
            'choices' => ['12pt Standard', '14pt Premium', '16pt Deluxe', '18pt Ultra'],
            'prices' => [0, 10, 20, 35],
            'is_required' => true,
            'sort_order' => 2,
        ]);

        PricingOption::create([
            'product_id' => $bc12->id,
            'option_name' => 'Finish',
            'option_type' => 'finishing',
            'choices' => ['Matte', 'Glossy Both Sides', 'Soft Touch', 'Spot UV'],
            'prices' => [0, 5, 15, 25],
            'is_required' => true,
            'sort_order' => 3,
        ]);

        // 12pt Business Cards 2 Sided
        $bc12_2 = Product::create([
            'name' => '12pt Business Cards - 2 Sided',
            'slug' => '12pt-business-cards-2-sided',
            'category_id' => $businessCards->id,
            'description' => 'Standard 12pt business cards, double-sided printing.',
            'short_description' => 'Professional 12pt business cards with double-sided printing.',
            'base_price' => 29.99,
            'is_featured' => true,
            'in_stock' => true,
        ]);

        PricingOption::create([
            'product_id' => $bc12_2->id,
            'option_name' => 'Select Quantity',
            'option_type' => 'quantity',
            'choices' => ['500 qty', '1000 qty', '2500 qty', '5000 qty'],
            'prices' => [29.99, 49.99, 99.99, 149.99],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        PricingOption::create([
            'product_id' => $bc12_2->id,
            'option_name' => 'Card Type',
            'option_type' => 'paper',
            'choices' => ['12pt Standard', '14pt Premium', '16pt Deluxe', '18pt Ultra'],
            'prices' => [0, 12, 25, 40],
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // 14pt Business Cards
        $bc14 = Product::create([
            'name' => '14pt Premium Business Cards',
            'slug' => '14pt-business-cards',
            'category_id' => $businessCards->id,
            'description' => 'Premium 14pt business cards for a more professional look.',
            'short_description' => 'Premium 14pt business cards.',
            'base_price' => 34.99,
            'in_stock' => true,
        ]);

        PricingOption::create([
            'product_id' => $bc14->id,
            'option_name' => 'Select Quantity',
            'option_type' => 'quantity',
            'choices' => ['500 qty', '1000 qty', '2500 qty', '5000 qty'],
            'prices' => [34.99, 54.99, 109.99, 169.99],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        PricingOption::create([
            'product_id' => $bc14->id,
            'option_name' => 'Printing Sides',
            'option_type' => 'sided',
            'choices' => ['1 Sided', '2 Sided'],
            'prices' => [0, 10],
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // 16pt Premium Business Cards
        $bc16 = Product::create([
            'name' => '16pt Premium Business Cards',
            'slug' => '16pt-premium-business-cards',
            'category_id' => $businessCards->id,
            'description' => 'Luxurious 16pt premium business cards with matte finish.',
            'short_description' => 'Luxurious 16pt premium business cards.',
            'base_price' => 49.99,
            'is_featured' => true,
            'in_stock' => true,
        ]);

        PricingOption::create([
            'product_id' => $bc16->id,
            'option_name' => 'Select Quantity',
            'option_type' => 'quantity',
            'choices' => ['500 qty', '1000 qty', '2500 qty', '5000 qty'],
            'prices' => [49.99, 79.99, 159.99, 249.99],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        PricingOption::create([
            'product_id' => $bc16->id,
            'option_name' => 'Lamination',
            'option_type' => 'finishing',
            'choices' => ['No Lamination', 'Gloss Lamination', 'Soft Touch', 'Uncoated'],
            'prices' => [0, 15, 25, 0],
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Flyers
        $flyer1 = Product::create([
            'name' => 'Flyers - 1 Side',
            'slug' => 'flyers-1-side',
            'category_id' => $marketing->id,
            'description' => 'Marketing flyers single-sided. Available in various sizes.',
            'short_description' => 'Single-sided marketing flyers.',
            'base_price' => 39.99,
            'in_stock' => true,
        ]);

        PricingOption::create([
            'product_id' => $flyer1->id,
            'option_name' => 'Select Quantity',
            'option_type' => 'quantity',
            'choices' => ['100 qty', '500 qty', '1000 qty', '5000 qty'],
            'prices' => [39.99, 89.99, 149.99, 299.99],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        PricingOption::create([
            'product_id' => $flyer1->id,
            'option_name' => 'Paper',
            'option_type' => 'paper',
            'choices' => ['80lb Gloss', '100lb Gloss', '14pt Cardstock'],
            'prices' => [0, 15, 25],
            'is_required' => true,
            'sort_order' => 2,
        ]);

        PricingOption::create([
            'product_id' => $flyer1->id,
            'option_name' => 'Size',
            'option_type' => 'size',
            'choices' => ['4x6', '5x7', '8.5x11', '11x17'],
            'prices' => [0, 10, 20, 40],
            'is_required' => true,
            'sort_order' => 3,
        ]);

        // Brochures
        $brochure = Product::create([
            'name' => 'Tri-Fold Brochures',
            'slug' => 'brochures',
            'category_id' => $marketing->id,
            'description' => 'Tri-fold brochures for your marketing needs.',
            'short_description' => 'Professional tri-fold brochures.',
            'base_price' => 79.99,
            'is_featured' => true,
            'in_stock' => true,
        ]);

        PricingOption::create([
            'product_id' => $brochure->id,
            'option_name' => 'Select Quantity',
            'option_type' => 'quantity',
            'choices' => ['100 qty', '500 qty', '1000 qty', '2500 qty'],
            'prices' => [79.99, 149.99, 249.99, 499.99],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        PricingOption::create([
            'product_id' => $brochure->id,
            'option_name' => 'Paper',
            'option_type' => 'paper',
            'choices' => ['80lb Gloss', '100lb Gloss', '100lb Matte'],
            'prices' => [0, 20, 25],
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Postcards
        $postcard = Product::create([
            'name' => 'Postcards',
            'slug' => 'postcards',
            'category_id' => $marketing->id,
            'description' => 'Custom postcards for direct mail marketing.',
            'short_description' => 'Custom marketing postcards.',
            'base_price' => 29.99,
            'in_stock' => true,
        ]);

        PricingOption::create([
            'product_id' => $postcard->id,
            'option_name' => 'Select Quantity',
            'option_type' => 'quantity',
            'choices' => ['250 qty', '500 qty', '1000 qty', '5000 qty'],
            'prices' => [29.99, 49.99, 89.99, 199.99],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        PricingOption::create([
            'product_id' => $postcard->id,
            'option_name' => 'Printing',
            'option_type' => 'sided',
            'choices' => ['1 Sided', '2 Sided'],
            'prices' => [0, 15],
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Vinyl Banner
        $banner = Product::create([
            'name' => 'Vinyl Banner',
            'slug' => 'vinyl-banner',
            'category_id' => $largeFormat->id,
            'description' => 'Weather-resistant vinyl banners for outdoor use.',
            'short_description' => 'Durable outdoor vinyl banner.',
            'base_price' => 89.99,
            'in_stock' => true,
        ]);

        PricingOption::create([
            'product_id' => $banner->id,
            'option_name' => 'Select Size',
            'option_type' => 'size',
            'choices' => ['2x4', '3x6', '4x8', '6x12'],
            'prices' => [89.99, 129.99, 179.99, 299.99],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        PricingOption::create([
            'product_id' => $banner->id,
            'option_name' => 'Grommets',
            'option_type' => 'finishing',
            'choices' => ['No Grommets', 'Corners Only', 'All Sides'],
            'prices' => [0, 15, 25],
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Roll Up Banner
        $rollup = Product::create([
            'name' => 'Roll Up Banner',
            'slug' => 'roll-up-banner',
            'category_id' => $largeFormat->id,
            'description' => 'Retractable roll-up banner for trade shows and events.',
            'short_description' => 'Retractable banner stand.',
            'base_price' => 149.99,
            'is_featured' => true,
            'in_stock' => true,
        ]);

        PricingOption::create([
            'product_id' => $rollup->id,
            'option_name' => 'Select Size',
            'option_type' => 'size',
            'choices' => ['33x80', '36x80', '48x80'],
            'prices' => [149.99, 179.99, 249.99],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        PricingOption::create([
            'product_id' => $rollup->id,
            'option_name' => 'Stand Type',
            'option_type' => 'finishing',
            'choices' => ['Silver Stand', 'Black Stand', 'With LED Light'],
            'prices' => [0, 25, 75],
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Custom T-Shirts
        $tshirt = Product::create([
            'name' => 'Custom T-Shirts',
            'slug' => 'custom-t-shirts',
            'category_id' => $apparel->id,
            'description' => 'Custom printed t-shirts with your design.',
            'short_description' => 'Custom printed t-shirts.',
            'base_price' => 19.99,
            'in_stock' => true,
        ]);

        PricingOption::create([
            'product_id' => $tshirt->id,
            'option_name' => 'Select Size',
            'option_type' => 'size',
            'choices' => ['S - M - L', 'XL - XXL', 'XXXL+'],
            'prices' => [0, 3, 6],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        PricingOption::create([
            'product_id' => $tshirt->id,
            'option_name' => 'Quantity',
            'option_type' => 'quantity',
            'choices' => ['1-5', '6-24', '25-99', '100+'],
            'prices' => [19.99, 16.99, 13.99, 9.99],
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Photo Mugs
        $mug = Product::create([
            'name' => 'Photo Mugs',
            'slug' => 'photo-mugs',
            'category_id' => $sublimation->id,
            'description' => 'Full color photo mugs with your design.',
            'short_description' => 'Custom photo mugs.',
            'base_price' => 14.99,
            'in_stock' => true,
        ]);

        PricingOption::create([
            'product_id' => $mug->id,
            'option_name' => 'Quantity',
            'option_type' => 'quantity',
            'choices' => ['1 mug', '3 mugs', '6 mugs', '12 mugs'],
            'prices' => [14.99, 12.99, 10.99, 8.99],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // Letterhead
        $letterhead = Product::create([
            'name' => 'Letterhead',
            'slug' => 'letterhead',
            'category_id' => $stationery->id,
            'description' => 'Professional letterhead printing.',
            'short_description' => 'Professional letterhead.',
            'base_price' => 34.99,
            'in_stock' => true,
        ]);

        PricingOption::create([
            'product_id' => $letterhead->id,
            'option_name' => 'Quantity',
            'option_type' => 'quantity',
            'choices' => ['50 sheets', '100 sheets', '250 sheets', '500 sheets'],
            'prices' => [34.99, 54.99, 99.99, 149.99],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        // Notepads
        $notepad = Product::create([
            'name' => 'Notepads',
            'slug' => 'notepads',
            'category_id' => $stationery->id,
            'description' => 'Custom notepads for your business.',
            'short_description' => 'Custom branded notepads.',
            'base_price' => 24.99,
            'in_stock' => true,
        ]);

        PricingOption::create([
            'product_id' => $notepad->id,
            'option_name' => 'Quantity',
            'option_type' => 'quantity',
            'choices' => ['25 pads', '50 pads', '100 pads'],
            'prices' => [24.99, 39.99, 69.99],
            'is_required' => true,
            'sort_order' => 1,
        ]);

        PricingOption::create([
            'product_id' => $notepad->id,
            'option_name' => 'Size',
            'option_type' => 'size',
            'choices' => ['4x5.5', '5.5x8.5', '8.5x11'],
            'prices' => [0, 10, 20],
            'is_required' => true,
            'sort_order' => 2,
        ]);

        // Testimonials
        $testimonials = [
            ['name' => 'Jashandeep Rai', 'company' => 'Customer', 'message' => 'Great printing shop in Brampton. Reasonable price. Friendly staff.', 'is_active' => true],
            ['name' => 'Nathan.rr14', 'company' => 'Customer', 'message' => 'Very respectful people easy communication and fast work', 'is_active' => true],
            ['name' => 'Alina Art', 'company' => 'Customer', 'message' => 'Friendly staff and good quality services available here.', 'is_active' => true],
            ['name' => 'Sukhpal Brar', 'company' => 'Customer', 'message' => 'Professional service at reasonable price.', 'is_active' => true],
            ['name' => 'Aqib Khan', 'company' => 'Customer', 'message' => 'Exactly what I was looking for at a decent price!', 'is_active' => true],
            ['name' => 'Seema Kumari', 'company' => 'Customer', 'message' => 'Exceptional customer services at reasonable prices.', 'is_active' => true],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }

        // Sliders
        $sliders = [
            [
                'title' => 'Premium Business Cards',
                'subtitle' => 'Make a lasting impression with our premium business cards',
                'image' => 'https://hawkprints.ca/wp-content/uploads/2025/01/Banner-2025-01-scaled.jpg',
                'button_text' => 'Shop Now',
                'link_url' => '/shop/category/business-cards',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Marketing Materials',
                'subtitle' => 'Grow your business with professional marketing materials',
                'image' => 'https://hawkprints.ca/wp-content/uploads/2025/01/Banner-2025-02-scaled.jpg',
                'button_text' => 'View Products',
                'link_url' => '/shop/category/marketing',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Large Format Printing',
                'subtitle' => 'Eye-catching displays and banners',
                'image' => 'https://hawkprints.ca/wp-content/uploads/2025/01/Banner-2025-03-scaled.jpg',
                'button_text' => 'Explore',
                'link_url' => '/shop/category/large-format',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }

        echo "Database seeded with pricing options!\n";
    }
}