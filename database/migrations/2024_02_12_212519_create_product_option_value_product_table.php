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
        Schema::create('product_option_value_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index()->commit('Товар');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('product_option_value_id')->index()->commit('Значение опции товара');
            $table->foreign('product_option_value_id')->references('id')->on('product_option_values')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_option_value_product');
    }
};
