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

Route::controller(PagesController::class)->group(function () {
    Route::get('/home', 'welcome')->name('home');
});

Route::prefix('products')
    ->name('products.')
    ->controller(ProductController::class)
    ->group(
        function () {
            Route::get('/create', 'create');
        }
    );
