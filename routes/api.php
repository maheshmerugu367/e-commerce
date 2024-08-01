<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\UserAuthController;

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

Route::prefix('user')->group(function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
});

Route::prefix('admin')->group(function () {
    Route::post('register', [AdminAuthController::class, 'register']);
    Route::post('login', [AdminAuthController::class, 'login']);
});

Route::middleware('admin.auth')->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminAuthController::class, 'dashboard']);
    Route::post('category/create', [CategoryController::class, 'store']);
    Route::get('categories', [CategoryController::class, 'index'])->name('all.categories');
    Route::get('category', [CategoryController::class, 'Category'])->name('get.one.category');
    Route::post('category/update', [CategoryController::class, 'CategoryUpdate'])->name('category.update');
    Route::post('category/move-to-trash', [CategoryController::class, 'CategoryMoveToTrash'])->name('category.move.trash');
    Route::post('category/delete', [CategoryController::class, 'CategoryDelete'])->name('category.delete');


});

