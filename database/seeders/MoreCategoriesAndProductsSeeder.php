<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MoreCategoriesAndProductsSeeder extends Seeder
{
    public function run(): void
    {
        $categoriesAndProducts = [
            'Booklets' => [
                ['Saddle-Stitched Booklet 8.5x11', 2.99],
                ['Perfect Bound Booklet', 4.99],
                ['Mini Booklet 5.5x8.5', 1.99],
                ['Square Booklet 8x8', 3.49],
                ['Wire-O Bound Booklet', 5.99],
                ['Spiral Bound Booklet', 4.49],
            ],
            'Calendars' => [
                ['Wall Calendar 12x12', 14.99],
                ['Desk Calendar - Triangular', 12.99],
                ['Mini Calendar 4x6 (50pk)', 24.99],
                ['Planning Calendar 18x24', 9.99],
                ['Custom Photo Calendar', 19.99],
                ['Appointment Calendar Pads', 16.99],
            ],
            'Catalogs' => [
                ['Product Catalog - Glossy', 3.99],
                ['Fashion Lookbook', 6.99],
                ['Menu Catalog - Restaurant', 4.49],
                ['Annual Report Booklet', 8.99],
                ['Trade Show Catalog', 5.99],
            ],
            'Certificates' => [
                ['Certificate of Achievement (50pk)', 24.99],
                ['Award Certificate - Gold Foil', 29.99],
                ['Completion Certificate', 19.99],
                ['Training Certificate', 22.99],
                ['Custom Diploma', 34.99],
            ],
            'Door Hangers' => [
                ['Standard Door Hanger (100pk)', 29.99],
                ['Double-Sided Door Hanger', 39.99],
                ['Premium Cardstock Door Hanger', 34.99],
                ['Perforated Door Hanger', 32.99],
            ],
            'Event Tickets' => [
                ['Raffle Tickets (500pk)', 14.99],
                ['Concert Tickets - Numbered', 19.99],
                ['Admission Tickets - Perforated', 12.99],
                ['VIP Event Tickets', 24.99],
                ['Wristband Event Tickets (100pk)', 29.99],
            ],
            'Forms' => [
                ['Carbonless Forms - 2 Part', 24.99],
                ['Carbonless Forms - 3 Part', 34.99],
                ['Invoice Books', 14.99],
                ['Receipt Books - Custom', 12.99],
                ['Order Form Pads', 16.99],
                ['NCR Forms - Custom Size', 29.99],
            ],
            'Invitations' => [
                ['Wedding Invitation Set', 2.49],
                ['Birthday Party Invitation (25pk)', 19.99],
                ['Baby Shower Invitation (25pk)', 17.99],
                ['Corporate Event Invitation', 1.49],
                ['Graduation Invitation', 1.99],
                ['Save The Date Cards', 1.29],
            ],
            'Letterheads' => [
                ['Custom Letterhead - 500 Sheets', 44.99],
                ['Letterhead - Recycled Paper', 39.99],
                ['Premium Cotton Letterhead', 54.99],
                ['Double-Sided Letterhead', 49.99],
                ['Linen Finish Letterhead', 47.99],
            ],
            'Menus' => [
                ['Restaurant Menu - Laminated', 8.99],
                ['Bi-Fold Menu Card', 2.49],
                ['Tri-Fold Menu Card', 1.99],
                ['Daily Special Board', 24.99],
                ['Wine List Menu', 3.49],
                ['Plastic Menu Cover + Inserts', 14.99],
            ],
            'Notepads' => [
                ['Custom Notepad 5.5x8.5', 12.99],
                ['Notepad 8.5x11 - Glue Bound', 16.99],
                ['Magnetic Notepad 4x6', 9.99],
                ['Sticky Notes - Custom Print', 14.99],
                ['Legal Pad - Yellow', 8.99],
            ],
            'Photographs' => [
                ['Glossy Photo Prints 4x6 (100pk)', 19.99],
                ['Matte Photo Prints 5x7 (50pk)', 24.99],
                ['Canvas Photo Print 12x16', 34.99],
                ['Photo Mounts 8x10 (25pk)', 14.99],
                ['Panoramic Photo Print', 29.99],
            ],
            'Table Tents' => [
                ['Table Tent Cards 4x9 (50pk)', 19.99],
                ['Triangular Table Tent (25pk)', 24.99],
                ['Double-Sided Table Tent', 29.99],
                ['A-Frame Table Display', 34.99],
            ],
            'Thank You Cards' => [
                ['Thank You Cards 4x6 (50pk)', 14.99],
                ['Thank You Cards - Gold Foil', 24.99],
                ['Custom Thank You Postcards', 19.99],
                ['Packaging Thank You Inserts', 9.99],
            ],
            'Vouchers' => [
                ['Gift Vouchers - Numbered', 24.99],
                ['Discount Coupon Cards (100pk)', 14.99],
                ['Loyalty Cards', 19.99],
                ['Punch Cards (50pk)', 12.99],
                ['VIP Pass Vouchers', 29.99],
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

        echo "\nDone!\n";
    }
}
