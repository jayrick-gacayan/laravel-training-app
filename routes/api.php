<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\VerificationController;
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
            Route::get('/', 'viewVerifyEmail')->middleware('auth')->name('notice');
            Route::get('/{id}/{hash}', 'verify')->middleware('signed')->name('verify');
            Route::get('/resend', 'resend')->name('send');
        }
    );
