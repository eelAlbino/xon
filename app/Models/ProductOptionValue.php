<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOptionValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'value', // Значение опции
        'code', // Символьный код
        'option_id' // ID связанной опции
    ];

    /**
     * Товары с данным значением опции
     * 
     * @return BelongsToMany
     */
    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Опция
     * 
     * @return BelongsTo
     */
    public function option(): BelongsTo
    {
        return $this->belongsTo(ProductOption::class, 'option_id');
    }
}
