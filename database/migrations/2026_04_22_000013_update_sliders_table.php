<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('subtitle')->nullable()->after('title');
            $table->renameColumn('link', 'link_url');
            $table->renameColumn('content', 'description');
        });
    }

    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->renameColumn('link_url', 'link');
            $table->renameColumn('description', 'content');
        });
    }
};