<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Requests\ProductFilterRequest;
use App\Repositories\ProductRepository;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    protected $productRepository;
    
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Получение списка товаров, отфильтрованных по опциям, с пагинацией по 40 штук
     * При успешном запросе будет возвращен список товаров с найденным всего кол-вом.
     * В случае ошибки будет возвращено описание ошибки.
     * 
     * @param ProductFilterRequest $request
     */
    public function index(ProductFilterRequest $request)
    {
        try {
            // Фильтрация по опциям. Массив формата [<код опции> => <массив кодов значений опции>]
            $optionsFilter = $request->input('properties', []);
            $pageN = (int) $request->input('page', 1);
            $products = $this->productRepository->get($optionsFilter, $pageN);
            return response()->json([
                'success' => true,
                'payload' => [
                    'items' => $products->items(),
                    'total' => $products->total()
                ]
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => [
                    $e->getMessage()
                ]
            ], 500);
        }
    }
}
