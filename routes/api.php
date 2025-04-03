<?php

use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PerformanceTestController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TestCaseController;
use App\Http\Controllers\Admin\TestResultController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('users', UserController::class);
Route::apiResource('posts', PostController::class);
Route::apiResource('comments', CommentController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('logs', LogController::class);
Route::apiResource('test-cases', TestCaseController::class);
Route::apiResource('test-test_results', TestResultController::class);

Route::prefix('test')->group(function () {
    Route::post('/read', [PerformanceTestController::class, 'testRead']);
    Route::post('/create', [PerformanceTestController::class, 'testCreate']);
    Route::post('/update', [PerformanceTestController::class, 'testUpdate']);
    Route::post('/delete', [PerformanceTestController::class, 'testDelete']);
});
Route::get('/category-fields/{categoryId}', [ProductController::class, 'getCategoryFields']);
