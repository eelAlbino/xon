<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product_option_value_product', function (Blueprint $table) {
            $table->unique(['product_id', 'product_option_value_id'], 'product_id_value_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_option_value_product', function (Blueprint $table) {
            $table->dropUnique('product_id_value_id_unique');
        });
    }
};
