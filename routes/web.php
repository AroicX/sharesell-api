<?php

use App\Http\Controllers\AdministratorAuthenticationController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\ProductCategoryController;
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

Route::get('/', [AdministratorAuthenticationController::class, 'login'])->name(
    'login'
);

Route::group(['prefix' => 'administrator'], function () {
    Route::post('/login', [
        AdministratorAuthenticationController::class,
        'loginSubmit',
    ]);

    // Auth::routes();
    Route::get('/logout', [
        AdministratorAuthenticationController::class,
        'logout',
    ])
        ->name('logout')
        ->middleware('auth');

    Route::get('/dashboard', [
        AdministratorController::class,
        'getDashboard',
    ])->name('dashboard');

    Route::group(['prefix' => 'products'], function () {
        Route::get('/category', [
            ProductCategoryController::class,
            'index',
        ])->name('product.category');
        Route::post('/category', [
            ProductCategoryController::class,
            'create',
        ])->name('product.category.create');
    });
});

Route::get('/test', function () {
    $categories = [
        'Men’s Fashion ',
        'Women’s Fashion',
        'Kids’ Fashion',
        'Beauty & Cosmetics',
        'Gifts',
        'Home & Kitchen',
        'Jewelries & Accessories',
        'Groceries & Beverages',
        'Toys & Baby Products',
        'Sports & Fitness',
        'Health & Wellness',
    ];

    foreach ($categories as $value) {
        dd($value);
    }
});
