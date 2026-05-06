<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('allow_artwork_upload')->default(true)->after('is_active');
            $table->text('artwork_instructions')->nullable()->after('allow_artwork_upload');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['allow_artwork_upload', 'artwork_instructions']);
        });
    }
};