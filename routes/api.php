<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)
        ->prefix('auth')
        ->as('auth.')
        ->group(
            function(){
                Route::post('login','userLogin')->middleware('guest');
                Route::post('logout', 'userLogout')->middleware('auth:api');
                Route::post('register','userRegister')->middleware('guest');
            }
        );

Route::prefix('email/verify')
    ->name('verification.')
    ->controller(VerificationController::class)
    ->group(
        function(){
            Route::get('/resend', 'resend')->name('resend');
            Route::get('/', 'viewVerifyEmail')->middleware('auth:api')->name('notice');
            Route::get('/{id}', 'verify')->name('verify');
        }
    );


Route::prefix('products')
    ->name('products.')
    ->controller(ProductController::class)
    ->group(
        function(){
            Route::get('/', 'index');
            Route::get('/{product}', 'show')->middleware('notfound:'.Product::class.',product');
            Route::post('/', 'store')->middleware('auth:api');
            // Route::middleware(['auth:api','notfound:'.Product::class.',product'])
            //     ->group(function(){
            //         Route::delete('/{product}', 'delete');
            //         Route::patch('/{product}', 'update');
            //     });
        });

// Route::resource('products', ProductController::class, ["except"=> ['create', 'edit']]);
