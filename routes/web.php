<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PerformanceTestController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TestResultController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [SiteController::class, 'index'])->name('home');

Auth::routes();


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/search', [UserController::class, 'search'])->name('search');
        Route::get('{user}/roles', [UserController::class, 'getUserRoles'])->name('roles');
        Route::post('/assignRole', [UserController::class, 'assignRole'])->name('assignRole');
        Route::delete('{user}/roles/{role}', [UserController::class, 'removeUserRole'])->name('removeRole');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('brands')->name('brands.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('index');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/store', [BrandController::class, 'store'])->name('store');
        Route::get('/{brand}/edit', [BrandController::class, 'edit'])->name('edit');
        Route::put('/{brand}', [BrandController::class, 'update'])->name('update');
        Route::delete('/{brand}', [BrandController::class, 'destroy'])->name('destroy');
    });
    Route::prefix('performance_test')->name('performance_test.')->group(function () {
        Route::get('/', [PerformanceTestController::class, 'index'])->name('index');
        Route::post('/create', [PerformanceTestController::class, 'testCreate'])->name('create');
        Route::post('/read', [PerformanceTestController::class, 'testRead'])->name('read');
        Route::post('/update', [PerformanceTestController::class, 'testUpdate'])->name('update');
        Route::post('/delete', [PerformanceTestController::class, 'testDelete'])->name('delete');
    });
    Route::prefix('test_results')->name('test_results.')->group(function () {
        Route::get('/', [TestResultController::class, 'index'])->name('index');
        Route::get('/view/{testCase}', [TestResultController::class, 'show'])->name('show');
        Route::get('/graph', [TestResultController::class, 'graph'])->name('graph');
    });

    Route::get('/roles/list', [RoleController::class, 'list'])->name('roles.list');

    Route::resource('brands', BrandController::class);
    Route::resource('compatibility', CompatibilityRuleController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('posts', PostController::class);

    Route::get('performance/take', [PerformanceTestController::class, 'take'])->name('performance.take');
    Route::get('performance/test_results', [PerformanceTestController::class, 'test_results'])->name('performance.test_results');
});

