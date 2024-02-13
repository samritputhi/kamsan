<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\Category\CategoryController;

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



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/signup', [LoginController::class, 'createUser'])->name('signup');
Route::post('/login', [LoginController::class, 'loginUser'])->name('login');
Route::post('/logout', [LoginController::class, 'logoutUser'])->middleware('auth')->name('logout');

Route::post('/category/create', [CategoryController::class, 'create']);
Route::post('/category/edit/{id}', [CategoryController::class, 'update']);
Route::get('/category/index', [CategoryController::class, 'index']);
Route::get('/category/detail/{id}', [CategoryController::class, 'detail']);



