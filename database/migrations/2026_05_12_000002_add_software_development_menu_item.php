<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $exists = DB::table('menu_items')->where('slug', '/software-development')->exists();
        if (!$exists) {
            $maxOrder = DB::table('menu_items')->whereNull('parent_id')->max('sort_order') ?? 0;
            DB::table('menu_items')->insert([
                'name' => 'Software Development',
                'slug' => '/software-development',
                'type' => 'custom',
                'reference_id' => null,
                'parent_id' => null,
                'sort_order' => $maxOrder + 1,
                'is_active' => true,
                'location' => 'header',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('menu_items')->where('slug', '/software-development')->delete();
    }
};
