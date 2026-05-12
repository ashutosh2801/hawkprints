<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        // Header Menu Items
        $businessCards = MenuItem::create([
            'name' => 'Business Cards',
            'slug' => '/shop/category/business-cards',
            'type' => 'category',
            'reference_id' => 1,
            'location' => 'header',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $marketing = MenuItem::create([
            'name' => 'Marketing',
            'slug' => '/shop/category/marketing',
            'type' => 'category',
            'reference_id' => 2,
            'location' => 'header',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'Large Format',
            'slug' => '/shop/category/large-format',
            'type' => 'category',
            'reference_id' => 3,
            'location' => 'header',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'Apparels',
            'slug' => '/shop/category/apparels',
            'type' => 'category',
            'reference_id' => 4,
            'location' => 'header',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'Sublimation',
            'slug' => '/shop/category/sublimation',
            'type' => 'category',
            'reference_id' => 5,
            'location' => 'header',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'Custom Order',
            'slug' => '/custom-quote',
            'type' => 'custom',
            'location' => 'header',
            'sort_order' => 6,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'About Us',
            'slug' => '/about',
            'type' => 'custom',
            'location' => 'header',
            'sort_order' => 7,
            'is_active' => true,
        ]);

        // Footer - Quick Links section
        $quickLinks = MenuItem::create([
            'name' => 'Quick Links',
            'slug' => '#',
            'type' => 'custom',
            'location' => 'footer',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'Shop All',
            'slug' => '/shop',
            'type' => 'custom',
            'location' => 'footer',
            'parent_id' => $quickLinks->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'About Us',
            'slug' => '/about',
            'type' => 'custom',
            'location' => 'footer',
            'parent_id' => $quickLinks->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'Contact',
            'slug' => '/contact',
            'type' => 'custom',
            'location' => 'footer',
            'parent_id' => $quickLinks->id,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'Custom Quote',
            'slug' => '/custom-quote',
            'type' => 'custom',
            'location' => 'footer',
            'parent_id' => $quickLinks->id,
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // Footer - Help section
        $help = MenuItem::create([
            'name' => 'Help',
            'slug' => '#',
            'type' => 'custom',
            'location' => 'footer',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'My Account',
            'slug' => '/login',
            'type' => 'custom',
            'location' => 'footer',
            'parent_id' => $help->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'Order Tracking',
            'slug' => '/orders',
            'type' => 'custom',
            'location' => 'footer',
            'parent_id' => $help->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'Terms & Conditions',
            'slug' => '/terms-conditions',
            'type' => 'custom',
            'location' => 'footer',
            'parent_id' => $help->id,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        MenuItem::create([
            'name' => 'Privacy Policy',
            'slug' => '/privacy-policy',
            'type' => 'custom',
            'location' => 'footer',
            'parent_id' => $help->id,
            'sort_order' => 4,
            'is_active' => true,
        ]);

        $this->command->info('Menu items seeded successfully!');
    }
}
