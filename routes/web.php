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




/*
Route::middleware('auth')->group(function() {

});

// Сотрудники
Route::view('/auth', 'user.auth');

Route::name('user.')->prefix('personal')->group(function() {
    Route::get('/', [UserController::class, 'list'])->name('list');
    Route::get('/{user}', [UserController::class, 'item'])->name('item');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
    Route::get('/reg', [UserController::class, 'save'])->name('reg');
});
*/


/*
// Проверка аутентификации
Route::get('/login', function() {
    if(Auth::check())  return redirect(route('home'));
    return view('user.login');
})->name('login');
// Запрос на аутентификацию
Route::post('/login', [UserController::class, 'login']);

// Внутри сайта
Route::middleware('auth')->group(function() {
*/
    // Отдельные разделы
    Route::get('/', [OrderController::class, 'list'])->name('home');
    Route::view('/help', 'help')->name('help');

    // Заказы
    Route::name('order.')->prefix('order')->group(function() {
        Route::get('/new', [OrderController::class, 'create'])->name('create');
        Route::get('/edit/{order}', [OrderController::class, 'edit'])->name('edit');
        Route::get('/{order}', [OrderController::class, 'item'])->name('item');
        Route::post('/store', [OrderController::class, 'store'])->name('store');
        Route::patch('/update/{order}', [OrderController::class, 'update'])->name('update');
        Route::delete('/delete/{order}', [OrderController::class, 'destroy'])->name('delete');
    });

    // Платежи
    Route::name('pay.')->prefix('pay')->group(function() {
        Route::get('/new/{order}', [PayController::class, 'create'])->name('create');
        Route::get('/edit/{pay}', [PayController::class, 'edit'])->name('edit');
        Route::patch('/update/{pay}', [PayController::class, 'update'])->name('update');
        Route::post('/store', [PayController::class, 'store'])->name('store');
        Route::delete('/delete/{pay}', [PayController::class, 'destroy'])->name('delete');
    });

    // Клиенты
    Route::name('client.')->prefix('client')->group(function() {
        Route::get('/', [ClientController::class, 'list'])->name('list');
        Route::get('/new', [ClientController::class, 'create'])->name('create');
        Route::get('/{client}', [ClientController::class, 'item'])->name('item');
        Route::get('/edit/{client}', [ClientController::class, 'edit'])->name('edit');
        Route::patch('/update/{client}', [ClientController::class, 'update'])->name('update');
        Route::post('/store', [ClientController::class, 'store'])->name('store');
        Route::delete('/delete/{client}', [ClientController::class, 'destroy'])->name('delete');
    });

    // Каталог
    Route::name('catalog.')->prefix('catalog')->group(function() {
        // Категории
        Route::get('/', [CategoryController::class, 'list'])->name('category.list');
        Route::name('category.')->prefix('category')->group(function() {
            Route::get('/new', [CategoryController::class, 'create'])->name('new');
            Route::get('/{category}', [CategoryController::class, 'item'])->name('item');
            Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('edit');
            Route::patch('/update/{category}', [CategoryController::class, 'update'])->name('update');
            Route::post('/store', [CategoryController::class, 'store'])->name('store');
            Route::delete('/delete/{category}', [CategoryController::class, 'destroy'])->name('delete');
        });
        // Товары
        Route::name('product.')->prefix('product')->group(function() {
            Route::get('/new/{category}', [ProductController::class, 'create'])->name('create');
            Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('edit');
            Route::patch('/update/{product}', [ProductController::class, 'update'])->name('update');
            Route::post('/store', [ProductController::class, 'store'])->name('store');
            Route::delete('/delete/{product}', [ProductController::class, 'destroy'])->name('delete');
        });
    });

    // Сотрудники
    Route::name('user.')->prefix('personal')->group(function() {
        Route::get('/', [UserController::class, 'list'])->name('list');
        Route::get('/reg', [UserController::class, 'reg'])->name('reg');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::get('/{user}', [UserController::class, 'item'])->name('item');
        Route::patch('/update/{user}', [UserController::class, 'update'])->name('update');
        Route::post('/save', [UserController::class, 'save'])->name('save');
        Route::delete('/delete/{user}', [UserController::class, 'destroy'])->name('delete');
    });

//});
