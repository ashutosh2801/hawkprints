<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->string('small')->nullable()->after('image');
            $table->string('medium')->nullable()->after('small');
            $table->boolean('is_active')->default(true)->after('is_primary');
        });
    }

    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn(['small', 'medium', 'is_active']);
        });
    }
};