<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\{Category\CategoryController,News\NewsController};
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\Api\News\NewsController;

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

// User Authentication Routes
// routes/api.php



Route::middleware('auth:sanctum')->get('/user', fn(Request $request) => $request->user());


// Authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('jwt.auth');

// Group routes that require authentication
Route::group(['middleware' => ['jwt.auth']], function() {

    // Category routes
    Route::prefix('category')->controller(CategoryController::class)->group(function () {
        Route::get('/orders/{id}', 'show')->name('category.show');
        Route::post('/orders', 'store')->name('category.store');
        Route::post('/create', 'create')->name('category.create');
        Route::post('/edit/{id}', 'update')->name('category.update');
        Route::get('/index', 'index')->name('category.index');
        Route::get('/detail/{id}', 'detail')->name('category.detail');
        Route::get('/', 'search')->name('category.search');
    });

    // News routes
    Route::prefix('news')->controller(NewsController::class)->group(function () {
        Route::post('/create', 'create')->name('news.create');
        Route::get('/index', 'index')->name('news.index');
        Route::get('/detail/{id}', 'detail')->name('news.detail');
        Route::post('/edit/{id}', 'update')->name('news.update');
        Route::post('/delete/{id}', 'delete')->name('news.delete');
        Route::get('/', 'search')->name('news.search');
    });
});










