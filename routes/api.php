<?php

use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
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

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/users/edit/{id}', [UserController::class, 'edit']);
    Route::post('/users/remove/{id}', [UserController::class, 'remove']);
    Route::post('/users/new', [UserController::class, 'new']);
    Route::get('/users/index', [UserController::class, 'index']);

    Route::post('/posts/new', [PostController::class, 'new']);
    Route::post('/posts/remove/{id}', [PostController::class, 'remove']);
    Route::post('/posts/edit/{id}', [PostController::class, 'edit']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::get('/posts/index', [PostController::class, 'index']);

Route::post('/password_reset/send_email', [PasswordResetController::class, 'sendEmail']);
Route::post('/password_reset/reset', [PasswordResetController::class, 'resetPassword']);
Route::get('/password_reset/check_code', [PasswordResetController::class, 'checkResetCode']);

