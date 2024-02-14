<?php
namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Models\Product;
use Exception;

/**
 * Отрицательные тесты получения списка продуктов
 */
class GetProductsFailedTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Передан некорректный url
     *
     * @return void
     */
    public function testIncorrectUrl()
    {
        $response = $this->json('GET', '/api/product');
        $response->assertStatus(404);
    }

    /**
     * Переданны некорректные параметры
     *
     * @return void
     */
    public function testIncorrectInputParameters()
    {
        // properties не как массив
        $response = $this->json('GET', '/api/products', [
            'properties' => 'invalid_value'
        ]);
        $response->assertStatus(422);

        // page не как число
        $response = $this->json('GET', '/api/products', [
            'page' => 'invalid_value'
        ]);
        $response->assertStatus(422);
    }

    /**
     * Отправка запроса POST методом вместо GET.
     *
     * @return void
     */
    public function testUnsupportedHttpMethod()
    {
        $response = $this->json('POST', '/api/products');
        $response->assertStatus(405);
    }
}