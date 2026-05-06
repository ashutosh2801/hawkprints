<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('notes');
            $table->string('payment_intent_id')->nullable()->after('payment_method');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->json('pricing_options')->nullable()->after('subtotal');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_intent_id']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['pricing_options']);
        });
    }
};