<?php

namespace Database\Seeders;

use App\Models\ShippingMethod;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'name' => 'Standard Shipping',
                'description' => '5-7 business days',
                'price' => 9.99,
                'estimated_days' => '5-7 days',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Express Shipping',
                'description' => '2-3 business days',
                'price' => 19.99,
                'estimated_days' => '2-3 days',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Rush Shipping',
                'description' => 'Next business day',
                'price' => 29.99,
                'estimated_days' => 'Next day',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Local Pickup',
                'description' => 'Pick up from our Brampton location',
                'price' => 0,
                'estimated_days' => 'Same day',
                'is_active' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($methods as $method) {
            ShippingMethod::create($method);
        }
    }
}