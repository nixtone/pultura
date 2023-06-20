<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;

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

Route::name('order.')->group(function() {
    Route::get('/order/create', [OrderController::class, 'create'])->name('create');
    Route::get('/order/{order}', [OrderController::class, 'item'])->name('item');

});
