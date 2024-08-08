<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserAuthController;


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

Route::get('/', function () {
    return view('welcome');
});
use Illuminate\Support\Facades\Log;

Route::get('/test-log', function () {
    Log::channel('db')->info('Your message');
    return 'Log created';
});


use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;

Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login']);
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin.auth:web'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('category/create', [CategoryController::class, 'CategoryCreate'])->name('admin.category.create');
    Route::post('category/store', [CategoryController::class, 'Store'])->name('admin.category.store');
    Route::get('all/categories', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');

    Route::post('category/update', [CategoryController::class, 'update'])->name('admin.category.update');

});

