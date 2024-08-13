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
use App\Http\Controllers\Admin\subCategoryController;
use App\Http\Controllers\Admin\ListSubCategoryController;



Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'login']);
Route::post('admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin.auth:web'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');

    //categories routes
    Route::get('category/create', [CategoryController::class, 'CategoryCreate'])->name('admin.category.create');
    Route::post('category/store', [CategoryController::class, 'Store'])->name('admin.category.store');
    Route::get('all/categories', [CategoryController::class, 'index'])->name('admin.category.index');
    Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
    Route::post('category/update', [CategoryController::class, 'update'])->name('admin.category.update');
    Route::get('category/appicon/delete/{id}', [CategoryController::class, 'appIconDelete'])->name('admin.category.delete.app.icon');
    Route::get('category/webicon/delete/{id}', [CategoryController::class, 'webIconDelete'])->name('admin.category.delete.web.icon');
    Route::get('category/mainicon/delete/{id}', [CategoryController::class, 'mainIconDelete'])->name('admin.category.delete.main.icon');
    Route::post('/delete-categories', [CategoryController::class, 'deleteSelectedCategories'])->name('admin.category.deleteSelected');
    Route::post('/trash-categories', [CategoryController::class, 'trashSelectedCategories'])->name('admin.category.trashSelected');
    Route::post('/active-categories', [CategoryController::class, 'activeSelectedCategories'])->name('admin.category.activeSelected');
    Route::post('/inactive-categories', [CategoryController::class, 'inactiveSelectedCategories'])->name('admin.category.inactiveSelected');
    Route::post('/front-active-categories', [CategoryController::class, 'frontactiveSelectedCategories'])->name('admin.category.frontactiveSelected');
    Route::post('/front-inactive-categories', [CategoryController::class, 'frontinactiveSelectedCategories'])->name('admin.category.frontinactiveSelected');


    //sub-categories-routes

    Route::get('subcategory/create', [subCategoryController::class, 'SubCategoryCreate'])->name('admin.subcategory.create');
    Route::post('subcategory/store', [subCategoryController::class, 'Store'])->name('admin.subcategory.store');
    Route::get('all/subcategories', [subCategoryController::class, 'index'])->name('admin.subcategory.index');
    Route::get('subcategory/edit/{id}', [subCategoryController::class, 'edit'])->name('admin.subcategory.edit');
    Route::post('subcategory/update', [subCategoryController::class, 'update'])->name('admin.subcategory.update');

    Route::get('subcategory/appicon/delete/{id}', [subCategoryController::class, 'appIconDelete'])->name('admin.subcategory.delete.app.icon');
    Route::get('subcategory/webicon/delete/{id}', [subCategoryController::class, 'webIconDelete'])->name('admin.subcategory.delete.web.icon');
    Route::get('subcategory/mainicon/delete/{id}', [subCategoryController::class, 'mainIconDelete'])->name('admin.subcategory.delete.main.icon');
    Route::post('/delete-subcategories', [subCategoryController::class, 'deleteSelectedSubCategories'])->name('admin.subcategory.deleteSelected');
    Route::post('/trash-subcategories', [subCategoryController::class, 'trashSelectedSubCategories'])->name('admin.subcategory.trashSelected');
    Route::post('/active-subcategories', [subCategoryController::class, 'activeSelectedSubCategories'])->name('admin.subcategory.activeSelected');
    Route::post('/inactive-subcategories', [subCategoryController::class, 'inactiveSelectedSubCategories'])->name('admin.subcategory.inactiveSelected');
    Route::post('/front-active-subcategories', [subCategoryController::class, 'frontactiveSelectedSubCategories'])->name('admin.subcategory.frontactiveSelected');
    Route::post('/front-inactive-subcategories', [subCategoryController::class, 'frontinactiveSelectedSubCategories'])->name('admin.subcategory.frontinactiveSelected');



    //list sub categories 
    Route::get('list/subcategory/create', [ListSubCategoryController::class, 'Create'])->name('admin.list.subcategory.create');
    Route::post('list/subcategory/store', [ListSubCategoryController::class, 'Store'])->name('admin.list.subcategory.store');
    Route::get('all/list-subcategories', [ListSubCategoryController::class, 'index'])->name('admin.list.subcategories.index');
    Route::get('list/subcategory/edit/{id}', [ListSubCategoryController::class, 'edit'])->name('admin.list.subcategories.edit');
    Route::post('list/subcategory/update', [ListSubCategoryController::class, 'update'])->name('admin.list.subcategories.update');


    Route::get('list/subcategory/appicon/delete/{id}', [ListSubCategoryController::class, 'appIconDelete'])->name('admin.list.subcategory.delete.app.icon');
    Route::get('list/subcategory/webicon/delete/{id}', [ListSubCategoryController::class, 'webIconDelete'])->name('admin.list.subcategory.delete.web.icon');
    Route::get('list/subcategory/mainicon/delete/{id}', [ListSubCategoryController::class, 'mainIconDelete'])->name('admin.list.subcategory.delete.main.icon');
    Route::post('list/delete-subcategories', [ListSubCategoryController::class, 'deleteSelectedSubCategories'])->name('admin.list.subcategory.deleteSelected');
    Route::post('list/trash-subcategories', [ListSubCategoryController::class, 'trashSelectedSubCategories'])->name('admin.list.subcategory.trashSelected');
    Route::post('list//active-subcategories', [ListSubCategoryController::class, 'activeSelectedSubCategories'])->name('admin.list.subcategory.activeSelected');
    Route::post('list//inactive-subcategories', [ListSubCategoryController::class, 'inactiveSelectedSubCategories'])->name('admin.list.subcategory.inactiveSelected');
    Route::post('list/front-active-subcategories', [ListSubCategoryController::class, 'frontactiveSelectedSubCategories'])->name('admin.list.subcategory.frontactiveSelected');
    Route::post('list/front-inactive-subcategories', [ListSubCategoryController::class, 'frontinactiveSelectedSubCategories'])->name('admin.list.subcategory.frontinactiveSelected');





});

