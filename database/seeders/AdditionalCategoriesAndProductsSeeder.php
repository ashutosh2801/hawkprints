<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdditionalCategoriesAndProductsSeeder extends Seeder
{
    public function run(): void
    {
        $categoriesAndProducts = [
            'Accessories' => [
                ['Tote Bags', 12.99],
                ['Phone Cases Custom Print', 9.99],
                ['Mugs - Ceramic 11oz', 7.99],
                ['Keychains - Acrylic', 4.99],
                ['Laptop Sleeves', 19.99],
                ['Water Bottles Custom', 14.99],
                ['Aprons - Full Length', 16.99],
                ['Caps - Embroidered', 11.99],
                ['Stickers Pack (50pcs)', 8.99],
                ['Coasters - Cork Set of 4', 9.99],
            ],
            'Banners' => [
                ['Vinyl Banner - 2x4 ft', 29.99],
                ['Retractable Stand Banner', 89.99],
                ['Mesh Banner - Outdoor', 34.99],
                ['Fabric Banner - Indoor', 44.99],
                ['Pull-Up Banner Display', 119.99],
                ['Window Banner - Suction Cup', 24.99],
                ['Step and Repeat Backdrop', 199.99],
                ['Feather Flag Banner', 59.99],
            ],
            'Brochures' => [
                ['Tri-Fold Brochure - Glossy', 0.49],
                ['Bi-Fold Brochure - Matte', 0.39],
                ['Z-Fold Brochure', 0.55],
                ['Gatefold Brochure - Premium', 0.79],
                ['Tri-Fold - Recycled Paper', 0.59],
                ['Accordion Fold Brochure', 0.65],
                ['Die-Cut Brochure', 0.99],
            ],
            'Envelopes' => [
                ['#10 Business Envelopes (500pk)', 24.99],
                ['9x12 Catalog Envelopes (100pk)', 29.99],
                ['A7 Invitation Envelopes (50pk)', 14.99],
                ['Padded Mailers (25pk)', 19.99],
                ['Custom Printed Envelopes', 0.35],
                ['Window Envelopes #10 (500pk)', 27.99],
                ['Greeting Card Envelopes (100pk)', 12.99],
            ],
            'Flyers' => [
                ['8.5x11 Flyers - Glossy', 0.12],
                ['8.5x14 Flyers - Matte', 0.15],
                ['5.5x8.5 Half-Sheet Flyers', 0.08],
                ['11x17 Poster Flyers', 0.25],
                ['Custom Die-Cut Flyers', 0.35],
                ['Double-Sided Flyers', 0.18],
                ['Economy Flyers - Newsprint', 0.05],
                ['Premium Flyers - Silk Coated', 0.22],
            ],
            'Labels' => [
                ['Product Labels - Roll', 19.99],
                ['Shipping Labels - 4x6 (500pk)', 24.99],
                ['Round Labels - 2 inch', 14.99],
                ['Holographic Labels', 29.99],
                ['Waterproof Labels', 22.99],
                ['Clear Labels - Transparent', 18.99],
                ['Kraft Paper Labels', 12.99],
                ['Barcode Labels', 15.99],
            ],
            'Packaging' => [
                ['Custom Boxes - Small', 2.49],
                ['Custom Boxes - Medium', 3.49],
                ['Custom Boxes - Large', 4.99],
                ['Tissue Paper - Custom Print', 0.15],
                ['Product Bags - Kraft Paper', 0.25],
                ['Mailer Boxes - White', 1.99],
                ['Poly Mailers - Custom', 0.45],
                ['Gift Boxes - Custom', 3.99],
            ],
            'Postcards' => [
                ['4x6 Postcards - Glossy', 0.15],
                ['5x7 Postcards - Matte', 0.22],
                ['6x9 Postcards - Premium', 0.35],
                ['Jumbo Postcards 6x11', 0.45],
                ['Double-Sided Postcards', 0.19],
                ['Postcard Mailing Service', 0.65],
            ],
            'Signs' => [
                ['Corrugated Plastic Sign - 18x24', 19.99],
                ['Foam Board Sign - 24x36', 24.99],
                ['Yard Sign with Stakes', 14.99],
                ['A-Frame Sidewalk Sign', 49.99],
                ['Magnetic Car Signs (Pair)', 29.99],
                ['Aluminum Sign - Brushed', 39.99],
                ['Window Clings - Custom', 18.99],
                ['Real Estate Signs - 18x24', 12.99],
            ],
            'Stickers' => [
                ['Die-Cut Stickers (50pcs)', 19.99],
                ['Vinyl Stickers - Rectangle', 14.99],
                ['Bumper Stickers', 9.99],
                ['Window Decals - Static Cling', 12.99],
                ['Laser Labels - Sheets', 8.99],
                ['Kiss-Cut Stickers', 16.99],
                ['Holographic Stickers', 24.99],
                ['Chalkboard Labels', 7.99],
            ],
        ];

        foreach ($categoriesAndProducts as $categoryName => $products) {
            $slug = Str::slug($categoryName);

            if (!Category::where('slug', $slug)->exists()) {
                $category = Category::create([
                    'name' => $categoryName,
                    'slug' => $slug,
                    'description' => "High quality {$categoryName} for your business needs.",
                    'is_active' => true,
                ]);

                echo "Created category: {$categoryName}\n";
            } else {
                $category = Category::where('slug', $slug)->first();
                echo "Category exists: {$categoryName}\n";
            }

            foreach ($products as $productData) {
                [$name, $price] = $productData;
                $productSlug = Str::slug($name);

                if (!Product::where('slug', $productSlug)->exists()) {
                    Product::create([
                        'name' => $name,
                        'slug' => $productSlug,
                        'category_id' => $category->id,
                        'description' => "Premium quality {$name}. Perfect for your business needs. Custom printing available with fast turnaround.",
                        'base_price' => $price,
                        'is_active' => true,
                        'in_stock' => true,
                        'is_featured' => rand(0, 3) === 0,
                    ]);

                    echo "  - Created product: {$name}\n";
                } else {
                    echo "  - Product exists: {$name}\n";
                }
            }
        }

        echo "\nDone! All categories and products seeded.\n";
    }
}
