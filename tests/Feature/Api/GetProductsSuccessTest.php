<?php
namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;

/**
 * Положительные тесты получения списка продуктов
 */
class GetProductsSuccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Успешное получение продуктов с проверкой пагинации
     *
     * @return void
     */
    public function testGetProducts()
    {
        // Создание 50 товаров
        $productCount = 50;
        Product::factory($productCount)->create();
        // Запрос на получение продуктов
        $response = $this->json('GET', '/api/products');
        // Проверка ответа
        $response->assertStatus(200);
        // Проверка структуры данных в ответе
        $response->assertJsonStructure([
            'success',
            'payload' => [
                'items',
                'total'
            ]
        ]);
        // Проверка содержимого с пагинацией
        $pageLimit = 40;
        $response->assertJson([
            'success' => true,
            'payload' => [
                'total' => $productCount,
                'items' => Product::query()->limit($pageLimit)->get()->toArray()
            ]
        ]);
    }

    /**
     * Применение фильтрации к запросу получения списка товаров
     *
     * @return void
     */
    public function testFilteringProducts()
    {
        // Тестовые продукты без опций
        Product::factory(10)->create();
        // Тестовые значения опций без привязки к товарам
        ProductOptionValue::factory(10)->create();
        // Несколько товаров, привязанных к значениям опции, не вошедшей в фильтр
        Product::factory(10)->create()->each(function($item) {
            $item->optionValues()->attach(ProductOptionValue::factory()->create()->id);
        });
        // Тестовые опции со значениями. Одна опция с тремя значениями и одна с одним
        $option1 = ProductOption::factory()->create();
        $option1Value1 = ProductOptionValue::factory()->create([
            'option_id' => $option1->id
        ]);
        $option1Value2 = ProductOptionValue::factory()->create([
            'option_id' => $option1->id
        ]);
        $option1Value3 = ProductOptionValue::factory()->create([
            'option_id' => $option1->id
        ]);
        $option2 = ProductOption::factory()->create();
        $option2Value1 = ProductOptionValue::factory()->create([
            'option_id' => $option2->id
        ]);
        // Тестовые товары для фильтрации
        $product1 = Product::factory()->create();
        $product1->optionValues()->attach([$option1Value1->id, $option2Value1->id]);
        $product2 = Product::factory()->create();
        $product2->optionValues()->attach([$option1Value2->id, $option2Value1->id]);
        // Этот товар имеет значение 3 опции 1, не вошедшее в фильтр
        Product::factory()->create()->optionValues()->attach([$option1Value3->id]);
        // Этот товар не имеет привязки к значению 1 опции 2
        Product::factory()->create()->optionValues()->attach([$option1Value1->id]);
        // Отправляем запрос на получение продуктов с фильтром по опции и значению
        $response = $this->json('GET', '/api/products', [
            'properties' => [
                $option1->code => [
                    $option1Value1->code,
                    $option1Value2->code,
                ],
                $option2->code => [
                    $option2Value1->code
                ],
            ]
        ]);
        // Проверка ответа
        $response->assertStatus(200);
        // Проверяем, что возвращаемый список содержит только продукты, удовлетворяющие фильтру
        $response->assertJson([
            'success' => true,
            'payload' => [
                'total' => 2,
                'items' => [
                    $product1->toArray(),
                    $product2->toArray()
                ]
            ]
        ]);
    }
}
