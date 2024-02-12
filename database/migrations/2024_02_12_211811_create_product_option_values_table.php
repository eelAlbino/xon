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
        Schema::create('product_option_values', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('value')->comment('Значение');
            $table->string('code')->index()->comment('Символьный код');
            $table->unsignedBigInteger('option_id')->index()->comment('ID опции');
            $table->foreign('option_id')->references('id')->on('product_options')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_option_values');
    }
};
