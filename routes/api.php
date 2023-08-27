<?php

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

Route::post('/users/edit/{id}', [UserController::class, 'edit'])->middleware('auth:sanctum');
Route::post('/users/remove/{id}', [UserController::class, 'remove'])->middleware('auth:sanctum');
Route::post('/users/new', [UserController::class, 'new'])->middleware('auth:sanctum');
Route::get('/users/index', [UserController::class, 'index'])->middleware('auth:sanctum');

Route::post('/posts/new', [PostController::class, 'new'])->middleware('auth:sanctum');
Route::post('/posts/remove/{id}', [PostController::class, 'remove'])->middleware('auth:sanctum');
Route::post('/posts/edit/{id}', [PostController::class, 'edit'])->middleware('auth:sanctum');
Route::get('/posts/index', [PostController::class, 'index']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

