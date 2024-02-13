<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Создание товаров
            ProductSeeder::class,
            // Создание опций
            ProductOptionSeeder::class,
            // Создание значений опций
            ProductOptionValueSeeder::class,
            // Добавление привязки товара к зн-ям опций
            ProductOptionValuePivotSeeder::class
        ]);
        
    }
}
