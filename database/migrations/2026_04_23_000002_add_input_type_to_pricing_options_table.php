<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pricing_options', function (Blueprint $table) {
            $table->string('input_type')->default('dropdown')->after('option_type');
        });
    }

    public function down(): void
    {
        Schema::table('pricing_options', function (Blueprint $table) {
            $table->dropColumn('input_type');
        });
    }
};