<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductOption;

class ProductOptionSeeder extends Seeder
{
    /**
     * Добавление двух опций: Производитель и Страна
     */
    public function run(): void
    {
        ProductOption::create(['name' => 'Производитель', 'code' => 'manufacturer']);
        ProductOption::create(['name' => 'Страна', 'code' => 'country']);
    }
}
