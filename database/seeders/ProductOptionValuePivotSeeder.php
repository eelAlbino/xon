<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductOptionValue;

class ProductOptionValuePivotSeeder extends Seeder
{

    /**
     * Создание привязки товара к значениям опций.
     * Часть товаров (10%) имеют привязку только к одной из опций.
     * Часть товаров (5%) не привязаны ни к одной из опций.
     */
    public function run(): void
    {
        $productOptionValues = ProductOptionValue::all();
        $products = Product::all();
        $productCount = $products->count();
        // Товары с одной заполенной опцией
        $productsWithOneOption = $products->random((int) (0.1 * $productCount));
        $productsWithOneOption->each(function ($product) use ($productOptionValues) {
            $optionValue = $productOptionValues->random();
            $product->optionValues()->attach($optionValue);
        });
        $products = $products->diff($productsWithOneOption);
        // Товары без заполненных опций
        $productsWithoutOptions = $products->random((int) (0.05 * $productCount));
        $products = $products->diff($productsWithoutOptions);
        // Остальные товары будут привязаны ко всем имеющимся опциям
        $optionValuesGroup = $productOptionValues->groupBy('option_id');
        $products->each(function ($product) use ($optionValuesGroup) {
            foreach ($optionValuesGroup as $optionValues) {
                $product->optionValues()->attach($optionValues->random());
            }
        });
    }
}
