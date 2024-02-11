<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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


Route::post('/signup', [LoginController::class, 'createUser'])->name('user.create');
Route::post('/login', [LoginController::class, 'loginUser'])->name('user.login');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});