<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
    Route::post('/categories', [\App\Http\Controllers\CategoryController::class, 'store']);
    Route::patch('/categories/{id}', [\App\Http\Controllers\CategoryController::class, 'update']);
    Route::delete('/categories/{id}', [\App\Http\Controllers\CategoryController::class, 'delete']);
    Route::get('/categories/{id}/books', [\App\Http\Controllers\CategoryController::class, 'show']);
    Route::get('/books', [\App\Http\Controllers\BookController::class, 'index']);
    Route::post('/books', [\App\Http\Controllers\BookController::class, 'store']);
    Route::patch('/books/{id}', [\App\Http\Controllers\BookController::class, 'update']);
    Route::delete('/books/{id}', [\App\Http\Controllers\BookController::class, 'delete']);
});
