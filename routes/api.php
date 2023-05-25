<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
                Route::post('login','userLogin');
                Route::post('logout', 'userLogout')->middleware('auth:api');
                Route::post('register','userRegister');
            }
        );

Route::prefix('email/verify')
    ->name('verification.')
    ->controller(VerificationController::class)->group(
        function(){
            Route::get('/resend', 'resend')->name('resend');
            Route::get('/', 'viewVerifyEmail')->middleware('auth:api')->name('notice');
            Route::get('/{id}', 'verify')->name('verify');
        }
    );

Route::resource('products', ProductController::class, ["except"=> ['create', 'edit']]);
