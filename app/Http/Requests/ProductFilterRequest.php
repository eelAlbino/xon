<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'properties' => 'nullable|array', // Параметр properties должен быть массивом
            'properties.*' => 'nullable|array', // Каждый элемент properties должен быть массивом
            'properties.*.*' => 'nullable|string', // Каждый элемент вложенных массивов properties должен быть строкой
            'page' => 'nullable|integer|min:1' // Параметр page должен быть целым числом и не менее 1
        ];
    }
}
