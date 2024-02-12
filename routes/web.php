<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::post('signup', [LoginController::class, 'signupUser'])->name('signup');
Route::post('login', [LoginController::class, 'loginUser'])->name('login');
Route::post('logout', [LoginController::class, 'logoutUser'])->middleware('auth')->name('logout');
