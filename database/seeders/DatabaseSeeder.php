<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\PricingOption;
use App\Models\Testimonial;
use App\Models\Slider;
use App\Models\Coupon;
use App\Models\ShippingMethod;
use App\Models\HomePageSection;
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
        ProductImage::truncate();
        Testimonial::truncate();
        Slider::truncate();
        Coupon::truncate();
        HomePageSection::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Coupon::create([
            'code' => 'WELCOME10',
            'type' => 'percentage',
            'value' => 10,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'SAVE20',
            'type' => 'percentage',
            'value' => 20,
            'min_order_amount' => 50,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'FLAT5',
            'type' => 'fixed',
            'value' => 5,
            'is_active' => true,
        ]);

        Coupon::create([
            'code' => 'FLAT15',
            'type' => 'fixed',
            'value' => 15,
            'min_order_amount' => 75,
            'is_active' => true,
        ]);

        ShippingMethod::create([
            'name' => 'Standard Shipping',
            'description' => '5-7 business days',
            'price' => 9.99,
            'estimated_days' => '5-7 days',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        ShippingMethod::create([
            'name' => 'Express Shipping',
            'description' => '2-3 business days',
            'price' => 19.99,
            'estimated_days' => '2-3 days',
            'is_active' => true,
            'sort_order' => 2,
        ]);

        ShippingMethod::create([
            'name' => 'Rush Shipping',
            'description' => 'Next business day',
            'price' => 29.99,
            'estimated_days' => 'Next day',
            'is_active' => true,
            'sort_order' => 3,
        ]);

        ShippingMethod::create([
            'name' => 'Local Pickup',
            'description' => 'Pick up from our Brampton location',
            'price' => 0,
            'estimated_days' => 'Same day',
            'is_active' => true,
            'sort_order' => 4,
        ]);

        User::updateOrCreate(
            ['email' => 'admin@hawkprints.ca'],
            [
                'name' => 'Admin',
                'email' => 'admin@hawkprints.ca',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
            ]
        );

        // === Image helper - Using Unsplash images appropriate for printing products ===
        $im = fn($id) => "https://images.unsplash.com/{$id}?w=600&h=600&fit=crop&q=80";
        $imlg = fn($id) => "https://images.unsplash.com/{$id}?w=1920&h=800&fit=crop&q=80";

        // === Categories ===
        $businessCards = Category::create([
            'name' => 'Business Cards',
            'slug' => 'business-cards',
            'description' => 'Professional business cards in various styles',
            'image' => $im('photo-1589829085413-56de8ae18c73'),
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $marketing = Category::create([
            'name' => 'Marketing',
            'slug' => 'marketing',
            'description' => 'Marketing materials like flyers, brochures, postcards',
            'image' => $im('photo-1557804506-669a67965ba0'),
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $largeFormat = Category::create([
            'name' => 'Large Format',
            'slug' => 'large-format',
            'description' => 'Banners, signs, posters and large prints',
            'image' => $im('photo-1562564055-71e051d33c19'),
            'is_active' => true,
            'sort_order' => 3,
        ]);

        $apparel = Category::create([
            'name' => 'Apparels',
            'slug' => 'apparels',
            'description' => 'Custom printed apparel',
            'image' => $im('photo-1521572163474-6864f9cf17ab'),
            'is_active' => true,
            'sort_order' => 4,
        ]);

        $sublimation = Category::create([
            'name' => 'Sublimation',
            'slug' => 'sublimation',
            'description' => 'Sublimation printing on various products',
            'image' => $im('photo-1514228742587-6b1558fcca3d'),
            'is_active' => true,
            'sort_order' => 5,
        ]);

        $stationery = Category::create([
            'name' => 'Stationery',
            'slug' => 'stationery',
            'description' => 'Letterheads, notepads, NCR forms',
            'image' => $im('photo-1586075010923-2dd4570fb338'),
            'is_active' => true,
            'sort_order' => 6,
        ]);

        // === 12pt Business Cards - 1 Sided ===
        $bc12 = Product::create([
            'name' => '12pt Business Cards - 1 Sided',
            'slug' => '12pt-business-cards-1-sided',
            'category_id' => $businessCards->id,
            'description' => 'Standard 12pt business cards, single-sided printing. Premium quality cardstock with glossy finish.',
            'short_description' => 'Professional 12pt business cards with single-sided printing.',
            'base_price' => 24.99,
            'image' => $im('photo-1556742049-0cfed4f6a45d'),
            'is_featured' => true,
            'in_stock' => true,
        ]);
        $this->addImages($bc12, [
            $im('photo-1556742049-0cfed4f6a45d'),
            $im('photo-1589829085413-56de8ae18c73'),
            $im('photo-1572099388302-937c407e2e75'),
        ]);
        $this->addPricing($bc12, 'Select Quantity', 'quantity', 'dropdown', true,
            ['500 qty', '1000 qty', '2500 qty', '5000 qty'], [24.99, 39.99, 79.99, 119.99]);
        $this->addPricing($bc12, 'Card Type', 'paper', 'dropdown', true,
            ['12pt Standard', '14pt Premium', '16pt Deluxe', '18pt Ultra'], [0, 10, 20, 35]);
        $this->addPricing($bc12, 'Finish', 'finishing', 'dropdown', true,
            ['Matte', 'Glossy Both Sides', 'Soft Touch', 'Spot UV'], [0, 5, 15, 25]);

        // === 12pt Business Cards - 2 Sided ===
        $bc12_2 = Product::create([
            'name' => '12pt Business Cards - 2 Sided',
            'slug' => '12pt-business-cards-2-sided',
            'category_id' => $businessCards->id,
            'description' => 'Standard 12pt business cards, double-sided printing.',
            'short_description' => 'Professional 12pt business cards with double-sided printing.',
            'base_price' => 29.99,
            'image' => $im('photo-1589829085413-56de8ae18c73'),
            'is_featured' => true,
            'in_stock' => true,
        ]);
        $this->addImages($bc12_2, [
            $im('photo-1589829085413-56de8ae18c73'),
            $im('photo-1556742049-0cfed4f6a45d'),
            $im('photo-1572099388302-937c407e2e75'),
        ]);
        $this->addPricing($bc12_2, 'Select Quantity', 'quantity', 'dropdown', true,
            ['500 qty', '1000 qty', '2500 qty', '5000 qty'], [29.99, 49.99, 99.99, 149.99]);
        $this->addPricing($bc12_2, 'Card Type', 'paper', 'dropdown', true,
            ['12pt Standard', '14pt Premium', '16pt Deluxe', '18pt Ultra'], [0, 12, 25, 40]);

        // === 14pt Premium Business Cards ===
        $bc14 = Product::create([
            'name' => '14pt Premium Business Cards',
            'slug' => '14pt-business-cards',
            'category_id' => $businessCards->id,
            'description' => 'Premium 14pt business cards for a more professional look.',
            'short_description' => 'Premium 14pt business cards.',
            'base_price' => 34.99,
            'image' => $im('photo-1572099388302-937c407e2e75'),
            'in_stock' => true,
        ]);
        $this->addImages($bc14, [
            $im('photo-1572099388302-937c407e2e75'),
            $im('photo-1556742049-0cfed4f6a45d'),
        ]);
        $this->addPricing($bc14, 'Select Quantity', 'quantity', 'dropdown', true,
            ['500 qty', '1000 qty', '2500 qty', '5000 qty'], [34.99, 54.99, 109.99, 169.99]);
        $this->addPricing($bc14, 'Printing Sides', 'sided', 'dropdown', true,
            ['1 Sided', '2 Sided'], [0, 10]);

        // === 16pt Premium Business Cards ===
        $bc16 = Product::create([
            'name' => '16pt Premium Business Cards',
            'slug' => '16pt-premium-business-cards',
            'category_id' => $businessCards->id,
            'description' => 'Luxurious 16pt premium business cards with matte finish.',
            'short_description' => 'Luxurious 16pt premium business cards.',
            'base_price' => 49.99,
            'image' => $im('photo-1611532736597-de71486e3c97'),
            'is_featured' => true,
            'in_stock' => true,
        ]);
        $this->addImages($bc16, [
            $im('photo-1611532736597-de71486e3c97'),
            $im('photo-1556742049-0cfed4f6a45d'),
            $im('photo-1572099388302-937c407e2e75'),
        ]);
        $this->addPricing($bc16, 'Select Quantity', 'quantity', 'dropdown', true,
            ['500 qty', '1000 qty', '2500 qty', '5000 qty'], [49.99, 79.99, 159.99, 249.99]);
        $this->addPricing($bc16, 'Lamination', 'finishing', 'dropdown', true,
            ['No Lamination', 'Gloss Lamination', 'Soft Touch', 'Uncoated'], [0, 15, 25, 0]);

        // === Flyers - 1 Side ===
        $flyer1 = Product::create([
            'name' => 'Flyers - 1 Side',
            'slug' => 'flyers-1-side',
            'category_id' => $marketing->id,
            'description' => 'Marketing flyers single-sided. Available in various sizes.',
            'short_description' => 'Single-sided marketing flyers.',
            'base_price' => 39.99,
            'image' => $im('photo-1586717791821-3f44a35283b4'),
            'in_stock' => true,
        ]);
        $this->addImages($flyer1, [
            $im('photo-1586717791821-3f44a35283b4'),
            $im('photo-1544716278-ca5e3f4abd8c'),
        ]);
        $this->addPricing($flyer1, 'Select Quantity', 'quantity', 'dropdown', true,
            ['100 qty', '500 qty', '1000 qty', '5000 qty'], [39.99, 89.99, 149.99, 299.99]);
        $this->addPricing($flyer1, 'Paper', 'paper', 'dropdown', true,
            ['80lb Gloss', '100lb Gloss', '14pt Cardstock'], [0, 15, 25]);
        $this->addPricing($flyer1, 'Size', 'size', 'dropdown', true,
            ['4x6', '5x7', '8.5x11', '11x17'], [0, 10, 20, 40]);

        // === Tri-Fold Brochures ===
        $brochure = Product::create([
            'name' => 'Tri-Fold Brochures',
            'slug' => 'brochures',
            'category_id' => $marketing->id,
            'description' => 'Tri-fold brochures for your marketing needs.',
            'short_description' => 'Professional tri-fold brochures.',
            'base_price' => 79.99,
            'image' => $im('photo-1544716278-ca5e3f4abd8c'),
            'is_featured' => true,
            'in_stock' => true,
        ]);
        $this->addImages($brochure, [
            $im('photo-1544716278-ca5e3f4abd8c'),
            $im('photo-1586717791821-3f44a35283b4'),
            $im('photo-1557804506-669a67965ba0'),
        ]);
        $this->addPricing($brochure, 'Select Quantity', 'quantity', 'dropdown', true,
            ['100 qty', '500 qty', '1000 qty', '2500 qty'], [79.99, 149.99, 249.99, 499.99]);
        $this->addPricing($brochure, 'Paper', 'paper', 'dropdown', true,
            ['80lb Gloss', '100lb Gloss', '100lb Matte'], [0, 20, 25]);

        // === Postcards ===
        $postcard = Product::create([
            'name' => 'Postcards',
            'slug' => 'postcards',
            'category_id' => $marketing->id,
            'description' => 'Custom postcards for direct mail marketing.',
            'short_description' => 'Custom marketing postcards.',
            'base_price' => 29.99,
            'image' => $im('photo-1602171162685-4f5e53e266d3'),
            'in_stock' => true,
        ]);
        $this->addImages($postcard, [
            $im('photo-1602171162685-4f5e53e266d3'),
            $im('photo-1557804506-669a67965ba0'),
        ]);
        $this->addPricing($postcard, 'Select Quantity', 'quantity', 'dropdown', true,
            ['250 qty', '500 qty', '1000 qty', '5000 qty'], [29.99, 49.99, 89.99, 199.99]);
        $this->addPricing($postcard, 'Printing', 'sided', 'dropdown', true,
            ['1 Sided', '2 Sided'], [0, 15]);

        // === Vinyl Banner ===
        $banner = Product::create([
            'name' => 'Vinyl Banner',
            'slug' => 'vinyl-banner',
            'category_id' => $largeFormat->id,
            'description' => 'Weather-resistant vinyl banners for outdoor use.',
            'short_description' => 'Durable outdoor vinyl banner.',
            'base_price' => 89.99,
            'image' => $im('photo-1585250003006-6b7e9c64a934'),
            'in_stock' => true,
        ]);
        $this->addImages($banner, [
            $im('photo-1585250003006-6b7e9c64a934'),
            $im('photo-1562564055-71e051d33c19'),
        ]);
        $this->addPricing($banner, 'Select Size', 'size', 'dropdown', true,
            ['2x4', '3x6', '4x8', '6x12'], [89.99, 129.99, 179.99, 299.99]);
        $this->addPricing($banner, 'Grommets', 'finishing', 'dropdown', true,
            ['No Grommets', 'Corners Only', 'All Sides'], [0, 15, 25]);

        // === Roll Up Banner ===
        $rollup = Product::create([
            'name' => 'Roll Up Banner',
            'slug' => 'roll-up-banner',
            'category_id' => $largeFormat->id,
            'description' => 'Retractable roll-up banner for trade shows and events.',
            'short_description' => 'Retractable banner stand.',
            'base_price' => 149.99,
            'image' => $im('photo-1559136555-9303baea8ebd'),
            'is_featured' => true,
            'in_stock' => true,
        ]);
        $this->addImages($rollup, [
            $im('photo-1559136555-9303baea8ebd'),
            $im('photo-1562564055-71e051d33c19'),
            $im('photo-1585250003006-6b7e9c64a934'),
        ]);
        $this->addPricing($rollup, 'Select Size', 'size', 'dropdown', true,
            ['33x80', '36x80', '48x80'], [149.99, 179.99, 249.99]);
        $this->addPricing($rollup, 'Stand Type', 'finishing', 'dropdown', true,
            ['Silver Stand', 'Black Stand', 'With LED Light'], [0, 25, 75]);

        // === Custom T-Shirts ===
        $tshirt = Product::create([
            'name' => 'Custom T-Shirts',
            'slug' => 'custom-t-shirts',
            'category_id' => $apparel->id,
            'description' => 'Custom printed t-shirts with your design.',
            'short_description' => 'Custom printed t-shirts.',
            'base_price' => 19.99,
            'image' => $im('photo-1521572163474-6864f9cf17ab'),
            'in_stock' => true,
        ]);
        $this->addImages($tshirt, [
            $im('photo-1521572163474-6864f9cf17ab'),
            $im('photo-1556821840-3a632b4e6c57'),
            $im('photo-1529374255400-481c8e34e168'),
        ]);
        $this->addPricing($tshirt, 'Select Size', 'size', 'dropdown', true,
            ['S - M - L', 'XL - XXL', 'XXXL+'], [0, 3, 6]);
        $this->addPricing($tshirt, 'Quantity', 'quantity', 'dropdown', true,
            ['1-5', '6-24', '25-99', '100+'], [19.99, 16.99, 13.99, 9.99]);

        // === Photo Mugs ===
        $mug = Product::create([
            'name' => 'Photo Mugs',
            'slug' => 'photo-mugs',
            'category_id' => $sublimation->id,
            'description' => 'Full color photo mugs with your design.',
            'short_description' => 'Custom photo mugs.',
            'base_price' => 14.99,
            'image' => $im('photo-1514228742587-6b1558fcca3d'),
            'in_stock' => true,
        ]);
        $this->addImages($mug, [
            $im('photo-1514228742587-6b1558fcca3d'),
            $im('photo-1495474472287-4d71bcdd2085'),
            $im('photo-1585386959984-a4155224a1ad'),
        ]);
        $this->addPricing($mug, 'Quantity', 'quantity', 'dropdown', true,
            ['1 mug', '3 mugs', '6 mugs', '12 mugs'], [14.99, 12.99, 10.99, 8.99]);

        // === Letterhead ===
        $letterhead = Product::create([
            'name' => 'Letterhead',
            'slug' => 'letterhead',
            'category_id' => $stationery->id,
            'description' => 'Professional letterhead printing.',
            'short_description' => 'Professional letterhead.',
            'base_price' => 34.99,
            'image' => $im('photo-1586075010923-2dd4570fb338'),
            'in_stock' => true,
        ]);
        $this->addImages($letterhead, [
            $im('photo-1586075010923-2dd4570fb338'),
            $im('photo-1568205631780-4a6b08d3e53d'),
        ]);
        $this->addPricing($letterhead, 'Quantity', 'quantity', 'dropdown', true,
            ['50 sheets', '100 sheets', '250 sheets', '500 sheets'], [34.99, 54.99, 99.99, 149.99]);

        // === Notepads ===
        $notepad = Product::create([
            'name' => 'Notepads',
            'slug' => 'notepads',
            'category_id' => $stationery->id,
            'description' => 'Custom notepads for your business.',
            'short_description' => 'Custom branded notepads.',
            'base_price' => 24.99,
            'image' => $im('photo-1531346878377-a5be20880e47'),
            'in_stock' => true,
        ]);
        $this->addImages($notepad, [
            $im('photo-1531346878377-a5be20880e47'),
            $im('photo-1586075010923-2dd4570fb338'),
        ]);
        $this->addPricing($notepad, 'Quantity', 'quantity', 'dropdown', true,
            ['25 pads', '50 pads', '100 pads'], [24.99, 39.99, 69.99]);
        $this->addPricing($notepad, 'Size', 'size', 'dropdown', true,
            ['4x5.5', '5.5x8.5', '8.5x11'], [0, 10, 20]);

        // === Window Clings ===
        $window = Product::create([
            'name' => 'Window Clings',
            'slug' => 'window-clings',
            'category_id' => $largeFormat->id,
            'description' => 'Custom window clings for storefronts and vehicles.',
            'short_description' => 'Custom window clings.',
            'base_price' => 49.99,
            'image' => $im('photo-1562617819-9f5e41236769'),
            'in_stock' => true,
        ]);
        $this->addImages($window, [
            $im('photo-1562617819-9f5e41236769'),
            $im('photo-1585250003006-6b7e9c64a934'),
        ]);
        $this->addPricing($window, 'Select Size', 'size', 'dropdown', true,
            ['12x12', '24x36', '36x48', '48x72'], [49.99, 89.99, 149.99, 249.99]);

        // === Yard Signs ===
        $yard = Product::create([
            'name' => 'Yard Signs',
            'slug' => 'yard-signs',
            'category_id' => $largeFormat->id,
            'description' => 'Durable outdoor yard signs on corrugated plastic.',
            'short_description' => 'Durable yard signs.',
            'base_price' => 19.99,
            'image' => $im('photo-1596464716127-f2a8e5235637'),
            'in_stock' => true,
        ]);
        $this->addImages($yard, [
            $im('photo-1596464716127-f2a8e5235637'),
            $im('photo-1562564055-71e051d33c19'),
        ]);
        $this->addPricing($yard, 'Quantity', 'quantity', 'dropdown', true,
            ['1 sign', '5 signs', '10 signs', '25 signs'], [19.99, 79.99, 139.99, 299.99]);

        // === Stickers ===
        $stickers = Product::create([
            'name' => 'Custom Stickers',
            'slug' => 'custom-stickers',
            'category_id' => $marketing->id,
            'description' => 'Die-cut custom stickers in any shape or size.',
            'short_description' => 'Custom die-cut stickers.',
            'base_price' => 29.99,
            'image' => $im('photo-1572295636264-76e5b4075c89'),
            'in_stock' => true,
        ]);
        $this->addImages($stickers, [
            $im('photo-1572295636264-76e5b4075c89'),
            $im('photo-1557804506-669a67965ba0'),
        ]);
        $this->addPricing($stickers, 'Quantity', 'quantity', 'dropdown', true,
            ['50 stickers', '100 stickers', '500 stickers', '1000 stickers'], [29.99, 49.99, 149.99, 249.99]);

        // === Phone Cases ===
        $phone = Product::create([
            'name' => 'Custom Phone Cases',
            'slug' => 'custom-phone-cases',
            'category_id' => $sublimation->id,
            'description' => 'Full color custom phone cases for iPhone and Samsung.',
            'short_description' => 'Custom phone cases.',
            'base_price' => 12.99,
            'image' => $im('photo-1585386959984-a4155224a1ad'),
            'in_stock' => true,
        ]);
        $this->addImages($phone, [
            $im('photo-1585386959984-a4155224a1ad'),
            $im('photo-1514228742587-6b1558fcca3d'),
        ]);
        $this->addPricing($phone, 'Phone Model', 'size', 'dropdown', true,
            ['iPhone 14', 'iPhone 14 Pro', 'iPhone 15', 'iPhone 15 Pro', 'Samsung S24'], [0, 2, 0, 2, 2]);

        // === Mouse Pads ===
        $mousepad = Product::create([
            'name' => 'Custom Mouse Pads',
            'slug' => 'custom-mouse-pads',
            'category_id' => $sublimation->id,
            'description' => 'Full color custom mouse pads with non-slip rubber base.',
            'short_description' => 'Custom mouse pads.',
            'base_price' => 7.99,
            'image' => $im('photo-1527864550417-7fd91fc51a46'),
            'in_stock' => true,
        ]);
        $this->addImages($mousepad, [
            $im('photo-1527864550417-7fd91fc51a46'),
            $im('photo-1585386959984-a4155224a1ad'),
        ]);
        $this->addPricing($mousepad, 'Quantity', 'quantity', 'dropdown', true,
            ['1 pad', '5 pads', '10 pads', '25 pads'], [7.99, 6.99, 5.99, 4.99]);

        // === Hoodies ===
        $hoodie = Product::create([
            'name' => 'Custom Hoodies',
            'slug' => 'custom-hoodies',
            'category_id' => $apparel->id,
            'description' => 'Custom printed hoodies with your design.',
            'short_description' => 'Custom printed hoodies.',
            'base_price' => 34.99,
            'image' => $im('photo-1556821840-3a632b4e6c57'),
            'in_stock' => true,
        ]);
        $this->addImages($hoodie, [
            $im('photo-1556821840-3a632b4e6c57'),
            $im('photo-1521572163474-6864f9cf17ab'),
            $im('photo-1529374255400-481c8e34e168'),
        ]);
        $this->addPricing($hoodie, 'Select Size', 'size', 'dropdown', true,
            ['S - M - L', 'XL - XXL', 'XXXL+'], [0, 5, 10]);
        $this->addPricing($hoodie, 'Quantity', 'quantity', 'dropdown', true,
            ['1-5', '6-24', '25-99', '100+'], [34.99, 29.99, 24.99, 19.99]);

        // === Caps & Hats ===
        $caps = Product::create([
            'name' => 'Custom Caps & Hats',
            'slug' => 'custom-caps',
            'category_id' => $apparel->id,
            'description' => 'Embroidered or printed custom caps and hats.',
            'short_description' => 'Custom caps and hats.',
            'base_price' => 9.99,
            'image' => $im('photo-1588850561407-ed78c282e89b'),
            'in_stock' => true,
        ]);
        $this->addImages($caps, [
            $im('photo-1588850561407-ed78c282e89b'),
            $im('photo-1529374255400-481c8e34e168'),
        ]);
        $this->addPricing($caps, 'Quantity', 'quantity', 'dropdown', true,
            ['1-11', '12-47', '48-99', '100+'], [9.99, 7.99, 6.99, 5.99]);
        $this->addPricing($caps, 'Style', 'finishing', 'dropdown', true,
            ['Unstructured', 'Structured', 'Trucker'], [0, 1, 2]);

        // === Posters ===
        $posters = Product::create([
            'name' => 'Custom Posters',
            'slug' => 'custom-posters',
            'category_id' => $largeFormat->id,
            'description' => 'High-quality poster printing on premium paper.',
            'short_description' => 'Custom poster printing.',
            'base_price' => 14.99,
            'image' => $im('photo-1513364776144-60967b26f890'),
            'in_stock' => true,
        ]);
        $this->addImages($posters, [
            $im('photo-1513364776144-60967b26f890'),
            $im('photo-1596464716127-f2a8e5235637'),
            $im('photo-1562564055-71e051d33c19'),
        ]);
        $this->addPricing($posters, 'Select Size', 'size', 'dropdown', true,
            ['11x17', '18x24', '24x36', '27x40'], [14.99, 24.99, 34.99, 49.99]);
        $this->addPricing($posters, 'Paper', 'paper', 'dropdown', true,
            ['100lb Gloss', '100lb Matte', '130lb Gloss'], [0, 5, 10]);

        // === Envelopes ===
        $envelopes = Product::create([
            'name' => 'Custom Envelopes',
            'slug' => 'custom-envelopes',
            'category_id' => $stationery->id,
            'description' => 'Professional custom printed envelopes.',
            'short_description' => 'Custom printed envelopes.',
            'base_price' => 39.99,
            'image' => $im('photo-1568205631780-4a6b08d3e53d'),
            'in_stock' => true,
        ]);
        $this->addImages($envelopes, [
            $im('photo-1568205631780-4a6b08d3e53d'),
            $im('photo-1586075010923-2dd4570fb338'),
        ]);
        $this->addPricing($envelopes, 'Quantity', 'quantity', 'dropdown', true,
            ['100 envelopes', '250 envelopes', '500 envelopes', '1000 envelopes'], [39.99, 79.99, 129.99, 199.99]);
        $this->addPricing($envelopes, 'Size', 'size', 'dropdown', true,
            ['#10 Standard', '9x12', '10x13', '12x15'], [0, 20, 25, 35]);

        // Testimonials
        foreach ([
            ['name' => 'Jashandeep Rai', 'company' => 'Customer', 'message' => 'Great printing shop in Brampton. Reasonable price. Friendly staff.', 'is_active' => true],
            ['name' => 'Nathan.rr14', 'company' => 'Customer', 'message' => 'Very respectful people easy communication and fast work', 'is_active' => true],
            ['name' => 'Alina Art', 'company' => 'Customer', 'message' => 'Friendly staff and good quality services available here.', 'is_active' => true],
            ['name' => 'Sukhpal Brar', 'company' => 'Customer', 'message' => 'Professional service at reasonable price.', 'is_active' => true],
            ['name' => 'Aqib Khan', 'company' => 'Customer', 'message' => 'Exactly what I was looking for at a decent price!', 'is_active' => true],
            ['name' => 'Seema Kumari', 'company' => 'Customer', 'message' => 'Exceptional customer services at reasonable prices.', 'is_active' => true],
        ] as $t) {
            Testimonial::create($t);
        }

        // Sliders
        foreach ([
            [
                'title' => 'Premium Business Cards',
                'subtitle' => 'Make a lasting impression with our premium business cards',
                'image' => $imlg('photo-1556742049-0cfed4f6a45d'),
                'button_text' => 'Shop Now',
                'link_url' => '/shop/category/business-cards',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Marketing Materials',
                'subtitle' => 'Grow your business with professional marketing materials',
                'image' => $imlg('photo-1557804506-669a67965ba0'),
                'button_text' => 'View Products',
                'link_url' => '/shop/category/marketing',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Large Format Printing',
                'subtitle' => 'Eye-catching displays and banners',
                'image' => $imlg('photo-1562564055-71e051d33c19'),
                'button_text' => 'Explore',
                'link_url' => '/shop/category/large-format',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ] as $s) {
            Slider::create($s);
        }

        // Home Page Sections
        foreach ([
            ['key' => 'hero', 'title' => 'Hero Slider', 'description' => 'Main banner slider at the top of the page', 'sort_order' => 0],
            ['key' => 'categories', 'title' => 'Shop Favourites', 'description' => 'Grid of popular product categories', 'sort_order' => 1],
            ['key' => 'featured-products', 'title' => 'Featured Products', 'description' => 'Showcase featured products', 'sort_order' => 2],
            ['key' => 'explore-categories', 'title' => 'Explore Categories', 'description' => 'Browse all product categories', 'sort_order' => 3],
            ['key' => 'all-categories', 'title' => 'All Categories', 'description' => 'Full list of product categories', 'sort_order' => 4],
            ['key' => 'new-arrivals', 'title' => 'New Arrivals', 'description' => 'Latest products section', 'sort_order' => 5],
            ['key' => 'about', 'title' => 'About Us', 'description' => 'About section with company info', 'sort_order' => 6],
            ['key' => 'testimonials', 'title' => 'Testimonials', 'description' => 'Customer testimonials carousel', 'sort_order' => 7],
            ['key' => 'clients', 'title' => 'Our Clients', 'description' => 'Client logos and brand showcase', 'sort_order' => 8],
        ] as $section) {
            HomePageSection::create($section);
        }

        echo "Database seeded with images!\n";
    }

    protected function addImages(Product $product, array $urls): void
    {
        $imageNames = [
            'photo-1556742049-0cfed4f6a45d' => 'Business card printing',
            'photo-1589829085413-56de8ae18c73' => 'Professional business cards',
            'photo-1572099388302-937c407e2e75' => 'Premium card stock',
            'photo-1611532736597-de71486e3c97' => 'Luxury business cards',
            'photo-1586717791821-3f44a35283b4' => 'Marketing flyers',
            'photo-1544716278-ca5e3f4abd8c' => 'Tri-fold brochures',
            'photo-1602171162685-4f5e53e266d3' => 'Marketing postcards',
            'photo-1585250003006-6b7e9c64a934' => 'Vinyl banner printing',
            'photo-1559136555-9303baea8ebd' => 'Roll up banner display',
            'photo-1521572163474-6864f9cf17ab' => 'Custom t-shirt',
            'photo-1556821840-3a632b4e6c57' => 'Custom hoodie',
            'photo-1529374255400-481c8e34e168' => 'Custom apparel',
            'photo-1514228742587-6b1558fcca3d' => 'Photo mug',
            'photo-1495474472287-4d71bcdd2085' => 'Custom coffee mug',
            'photo-1585386959984-a4155224a1ad' => 'Custom phone case',
            'photo-1586075010923-2dd4570fb338' => 'Letterhead stationery',
            'photo-1531346878377-a5be20880e47' => 'Custom notepads',
            'photo-1562617819-9f5e41236769' => 'Window cling decals',
            'photo-1596464716127-f2a8e5235637' => 'Yard sign display',
            'photo-1572295636264-76e5b4075c89' => 'Custom stickers',
            'photo-1527864550417-7fd91fc51a46' => 'Custom mouse pad',
            'photo-1588850561407-ed78c282e89b' => 'Custom cap',
            'photo-1513364776144-60967b26f890' => 'Poster printing',
            'photo-1568205631780-4a6b08d3e53d' => 'Custom envelopes',
            'photo-1557804506-669a67965ba0' => 'Marketing materials',
            'photo-1562564055-71e051d33c19' => 'Large format printing',
        ];

        foreach ($urls as $i => $url) {
            $seedMatch = [];
            preg_match('/photo-[^?]+/', $url, $seedMatch);
            $seed = $seedMatch[0] ?? '';
            $alt = $imageNames[$seed] ?? $product->name;

            ProductImage::create([
                'product_id' => $product->id,
                'image' => $url,
                'sort_order' => $i,
                'is_primary' => $i === 0,
                'alt' => $i === 0 ? $product->name : $alt,
                'title' => $i === 0 ? $product->name : $alt,
            ]);
        }
    }

    protected function addPricing(Product $product, string $name, string $type, string $inputType, bool $required, array $choices, array $prices): void
    {
        PricingOption::create([
            'product_id' => $product->id,
            'option_name' => $name,
            'option_type' => $type,
            'input_type' => $inputType,
            'choices' => $choices,
            'prices' => $prices,
            'is_required' => $required,
            'sort_order' => ($product->pricingOptions()->max('sort_order') ?? 0) + 1,
        ]);
    }
}
