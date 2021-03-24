<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;

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

// version 1 of auth module routes
Route::prefix('v1')->group(function(){
    // Auth routes
    Route::post('/signup', [AuthController::class, 'signUp']);
    Route::post('/signin', [AuthController::class, 'signIn']);
    Route::post('/reset/password', [AuthController::class, 'resetPassword']);
    Route::post('/verify/token', [AuthController::class, 'verifyToken']);

    // Timezone
    Route::get('/timezone', [FrontController::class, 'timeZones']);

    // Private routes
    Route::middleware('auth:sanctum')->group(function(){
        // User routes
        Route::post('/signout', [AuthController::class, 'signOut']);
        Route::put('/{user}/profile/', [UserController::class, 'updateProfile']);

        // Group routes
        Route::get('/groups', [RoomController::class, 'index']);
        Route::post('/groups', [RoomController::class, 'store']);

        // Reservation routes
        Route::get('/events', [ReservationController::class, 'index']);
        Route::get('/events/rate', [ReservationController::class, 'rate']);
        Route::post('/events', [ReservationController::class, 'store']);
    });
});
