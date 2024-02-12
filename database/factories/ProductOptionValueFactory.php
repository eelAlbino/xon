<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ProductOption;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductOptionValue>
 */
class ProductOptionValueFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => $this->faker->word,
            'code' => $this->faker->unique()->word,
            'option_id' => function () {
                return ProductOption::factory()->create()->id;
            }
        ];
    }
}
