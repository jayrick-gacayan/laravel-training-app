<?php

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
                Route::get('/testTwilio', 'testTwilio');
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
    ->group(
        function(){
            Route::controller(ProductController::class)
                ->group(function(){
                Route::get('/', 'index');
                Route::get('/{id}', 'show')->middleware('not.found:'.Product::class);
                Route::post('/', 'store')->middleware('auth:api');
            });
            
            Route::controller(ProductController::class)
                ->middleware(['auth:api','not.found:'.Product::class, 'not.allowed:'.Product::class])
                ->group(function(){
                    Route::delete('/{id}', 'destroy');
                    Route::put('/{id}', 'update');
                });
        });

// Route::resource('products', ProductController::class, ["except"=> ['create', 'edit']]);
