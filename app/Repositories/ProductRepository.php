<?php
namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class ProductRepository
{

    /**
     * Получение элемента товаров с пагинацией.
     *
     * @param array $optionsFilter Фильтр по опциям товара.
     * @param int $page Номер страницы.
     * @param int $perPage Количество элементов на странице.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function get(array $optionsFilter, int $page = 1, int $perPage = 40): LengthAwarePaginator
    {
        $tables = [
            'products' => (new Product())->getTable(),
            'options' => (new ProductOption())->getTable(),
            'option_values' => (new ProductOptionValue())->getTable(),
            'product2value' => 'product_option_value_product'
        ];
        $query = Product::query()->select([
            $tables['products'] .'.*'
        ]);
        // Один из самых простых вариантов фильтрации через join
        if (!empty($optionsFilter)) {
            $nItem = 0;
            foreach ($optionsFilter as $optionCode => $optionValues) {
                $optionCode = Str::slug($optionCode);
                if (!$optionCode) {
                    continue;
                }
                $query->join(
                    $tables['product2value'] .' as product2value_'. $nItem,
                    $tables['products'] .'.id',
                    '=',
                    'product2value_'. $nItem .'.product_id'
                )
                ->join(
                    $tables['option_values'] .' as option_values_'. $nItem,
                    'product2value_'. $nItem .'.product_option_value_id',
                    '=',
                    'option_values_'. $nItem .'.id'
                )
                ->join(
                    $tables['options'] .' as options_'. $nItem,
                    'option_values_'. $nItem .'.option_id',
                    '=',
                    'options_'. $nItem .'.id'
                 )
                ->where('options_'. $nItem .'.code', $optionCode)
                ->whereIn('option_values_'. $nItem .'.code', $optionValues);
                $nItem++;
            }
            $query->distinct();
        }
        $query->orderBy($tables['products'] .'.id');
        return $query->paginate($perPage, ['*'], 'page', $page);
    }
}
