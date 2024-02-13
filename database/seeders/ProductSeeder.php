<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Добавление 150 товаров
     */
    public function run(): void
    {
        Product::factory(150)->create();
    }
}
