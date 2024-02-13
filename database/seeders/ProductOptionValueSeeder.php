<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\ProductOptionValue;
use App\Models\ProductOption;
use Faker;

class ProductOptionValueSeeder extends Seeder
{

    /**
     * Добавление значений для ранее созданных опций
     */
    public function run(): void
    {
        // 50 тестовых значений для опции Производитель
        $manufacturerOption = ProductOption::where('code', 'manufacturer')->first();
        ProductOptionValue::factory(50)->create([
            'option_id' => $manufacturerOption->id
        ]);
        // 30 тестовый значений для опции Страна, с использованием Faker
        $faker = Faker\Factory::create()->unique();
        $countryOption = ProductOption::where('code', 'country')->first();
        for ($i = 0; $i < 30; $i++) {
            $country = $faker->country;
            ProductOptionValue::create([
                'value' => $country,
                'code' => Str::slug($country),
                'option_id' => $countryOption->id
            ]);
        }
    }
}
