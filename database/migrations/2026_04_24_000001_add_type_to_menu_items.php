<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->enum('type', ['custom', 'category', 'product'])->default('custom')->after('slug');
            $table->unsignedBigInteger('reference_id')->nullable()->after('type');
            $table->index(['type', 'reference_id']);
        });
    }

    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn(['type', 'reference_id']);
        });
    }
};