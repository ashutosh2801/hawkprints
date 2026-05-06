<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'type' => 'percentage',
                'value' => 10,
                'is_active' => true,
            ],
            [
                'code' => 'SAVE20',
                'type' => 'percentage',
                'value' => 20,
                'min_order_amount' => 50,
                'is_active' => true,
            ],
            [
                'code' => 'FLAT5',
                'type' => 'fixed',
                'value' => 5,
                'is_active' => true,
            ],
            [
                'code' => 'FLAT15',
                'type' => 'fixed',
                'value' => 15,
                'min_order_amount' => 75,
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}