<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Название
        'price', // Цена
        'quantity'// Количество
    ];

    /**
     * Значения опций товара
     * 
     * @return BelongsToMany
     */
    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductOptionValue::class,
            'product_option_value_product',
            'product_id',
            'product_option_value_id'
        );
    }
}
