<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\GroupController;

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
        Route::prefix('groups')->group(function(){
            Route::get('/', [GroupController::class, 'index']);
            Route::post('/', [GroupController::class, 'store']);
        });

        // Event routes
        Route::prefix('events')->group(function(){
            Route::get('/', [EventController::class, 'index']);
            Route::get('/rate', [EventController::class, 'rate']);
            Route::post('/', [EventController::class, 'store']);
        });
    });
});
