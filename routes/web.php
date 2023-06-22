<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;

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



Route::get('/', [OrderController::class, 'list'])->name('home');

// Заказы
Route::name('order.')->group(function() {
    Route::get('/order/new', [OrderController::class, 'create'])->name('create');
    Route::get('/order/{order}/edit', [OrderController::class, 'edit'])->name('edit');
    Route::get('/order/{order}', [OrderController::class, 'item'])->name('item');
    Route::post('/order/store', [OrderController::class, 'store'])->name('store');
});

// Клиенты
Route::name('client.')->group(function() {
    Route::get('/client', [ClientController::class, 'list'])->name('list');
    Route::get('/client/new', [ClientController::class, 'create'])->name('create');
    Route::get('/client/{client}', [ClientController::class, 'item'])->name('item');
    Route::get('/client/{client}/edit', [ClientController::class, 'edit'])->name('edit');
    Route::patch('/client/{client}/update', [ClientController::class, 'update'])->name('update');
    Route::post('/client/store', [ClientController::class, 'store'])->name('store');
    Route::delete('/client/{client}/delete', [ClientController::class, 'destroy'])->name('delete');
});

// Услуги и наименования
Route::name('product.')->group(function() {
    Route::get('/product', [ProductController::class, 'list'])->name('list');
    Route::get('/product/new', [ProductController::class, 'create'])->name('create');
    Route::get('/product/{product}', [ProductController::class, 'item'])->name('item');
});

// Сотрудники
