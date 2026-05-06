<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pricing_options', function (Blueprint $table) {
            $table->json('conditions')->nullable()->after('prices');
        });
    }

    public function down(): void
    {
        Schema::table('pricing_options', function (Blueprint $table) {
            $table->dropColumn('conditions');
        });
    }
};
