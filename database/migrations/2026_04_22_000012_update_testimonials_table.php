<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('company')->nullable()->after('name');
            $table->renameColumn('content', 'message');
            $table->renameColumn('title', 'position');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->renameColumn('message', 'content');
            $table->renameColumn('position', 'title');
        });
    }
};