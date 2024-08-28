<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

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


// Вход
Route::name('user.')->controller(UserController::class)->group(function() {
    Route::get('/login', 'auth')->name('auth');
    Route::post('/login', 'login')->name('login');
});

// Внутри сайта
Route::middleware('auth')->group(function() {

    // Сотрудники
    Route::name('user.')->prefix('personal')->controller(UserController::class)->group(function() {
        Route::get('/', 'list')->name('list');
        Route::get('/reg', 'reg')->name('reg');
        Route::get('/logout', 'logout')->name('logout');
        Route::get('/edit/{user}', 'edit')->name('edit');
        Route::get('/{user}', 'item')->name('item');
        Route::patch('/update/{user}', 'update')->name('update');
        Route::post('/save', 'save')->name('save');
        Route::delete('/delete/{user}', 'destroy')->name('delete');
    });

    // Отдельные разделы
    Route::get('/', [OrderController::class, 'list'])->name('home');
    Route::view('/help', 'help')->name('help');

    // Заказы
    Route::name('order.')->prefix('order')->controller(OrderController::class)->group(function() {
        Route::get('/test', 'test')->name('test');
        Route::get('/new', 'create')->name('create');
        Route::get('/edit/{order}', 'edit')->name('edit');
        Route::get('/{order}', 'item')->name('item');
        Route::get('/{order}/pdfstream', 'pdfStream')->name('pdfstream');
        Route::get('/{order}/pdfdownload', 'pdfDownload')->name('pdfdownload');
        Route::get('/{order}/contract', 'contract')->name('contract');
        Route::post('/store', 'store')->name('store');
        Route::patch('/update/{order}', 'update')->name('update');
        Route::delete('/delete/{order}', 'destroy')->name('delete');
        Route::post('/price', 'price')->name('price');
    });

    // Платежи
    Route::name('pay.')->prefix('pay')->controller(PayController::class)->group(function() {
        Route::get('/new/{order}', 'create')->name('create');
        Route::get('/edit/{pay}', 'edit')->name('edit');
        Route::patch('/update/{pay}', 'update')->name('update');
        Route::post('/store', 'store')->name('store');
        Route::delete('/delete/{pay}', 'destroy')->name('delete');
    });

    // Клиенты
    Route::name('client.')->prefix('client')->controller(ClientController::class)->group(function() {
        Route::get('/', 'list')->name('list');
        Route::get('/new', 'create')->name('create');
        Route::get('/{client}', 'item')->name('item');
        Route::get('/edit/{client}', 'edit')->name('edit');
        Route::patch('/update/{client}', 'update')->name('update');
        Route::post('/store', 'store')->name('store');
        Route::delete('/delete/{client}', 'destroy')->name('delete');
        Route::post('/presearch', 'presearch')->name('presearch');
        Route::post('/search', 'search')->name('search');
    });

    // Каталог
    Route::name('catalog.')->prefix('catalog')->group(function() {
        // Категории
        Route::get('/', [CategoryController::class, 'list'])->name('category.list');
        Route::name('category.')->prefix('category')->controller(CategoryController::class)->group(function() {
            Route::get('/new', 'create')->name('new');
            Route::get('/{category}', 'item')->name('item');
            Route::get('/edit/{category}', 'edit')->name('edit');
            Route::patch('/update/{category}', 'update')->name('update');
            Route::post('/store', 'store')->name('store');
            Route::delete('/delete/{category}', 'destroy')->name('delete');
        });
        // Товары
        Route::name('product.')->prefix('product')->controller(ProductController::class)->group(function() {
            Route::get('/new/{category}', 'create')->name('create');
            Route::get('/{product}', 'item')->name('item');
            Route::get('/edit/{product}', 'edit')->name('edit');
            Route::patch('/update/{product}', 'update')->name('update');
            Route::post('/store', 'store')->name('store');
            Route::delete('/delete/{product}', 'destroy')->name('delete');
        });
    });

});
