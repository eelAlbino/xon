<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Методы апи, по-идее, реализуются через /api, но в тз указан пример запроса без данного префикса в урле.
// Сделал редиректом
Route::get('/products', function () {
    return redirect('/api/products');
})->name('products');
