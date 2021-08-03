<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ShoppingCartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('/shopping')->group(function () {
    Route::get('/list', [ProductsController::class, 'index']);
    Route::get('/create', [ProductsController::class, 'create']);
    Route::post('/create', [ProductsController::class, 'store']);
    Route::get('/add', [ShoppingCartController::class, 'add'])->name('thang');
    Route::get('/cart', [ShoppingCartController::class, 'show']);
    Route::get('/remove', [ShoppingCartController::class, 'remove']);
    Route::post('/save', [ShoppingCartController::class, 'save']);
});
