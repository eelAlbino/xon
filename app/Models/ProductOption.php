<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductOption extends Model
{
    use HasFactory;

    /**
     * Значения опции
     * 
     * @return HasMany
     */
    public function values(): HasMany
    {
        return $this->hasMany(ProductOptionValue::class, 'option_id');
    }
}
