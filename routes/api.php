<?php

use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
    Route::apiResource('/users', UserController::class);
});

Route::post('/signup', [UserAuthController::class, 'signup'])->name('user.signup');
Route::post('/login', [UserAuthController::class, 'login'])->name('user.login');
