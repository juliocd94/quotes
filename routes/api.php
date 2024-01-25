<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavoriteController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthController::class, 'login']);

Route::group( ['middleware' => ['auth:sanctum']], function(){
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::get('/block-user/{userId}', [UserController::class, 'blockUser']);
    Route::get('/unblock-user/{userId}', [UserController::class, 'unblockUser']);
    Route::get('/quotes-user/{userId}', [QuoteController::class, 'quotesUser']);
    Route::delete('/delete-quote/{id}', [QuoteController::class, 'deleteQuote']);
    Route::get('/quotes', [QuoteController::class, 'index']);
    Route::post('/update-profile', [AuthController::class, 'update']);
    Route::post('/set-favorite', [QuoteController::class, 'setFavorite']);
    Route::get('/favorites-to-user/{userId}', [FavoriteController::class, 'favoritesToUser']);
    Route::delete('/quotes/{quote}', [FavoriteController::class, 'destroy']);
    Route::middleware(['throttle:quotes'])->group(function () {
        Route::get('/get-external-quotes', [QuoteController::class, 'getExternalQuotes']);
    });
});