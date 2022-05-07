<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Admin\AdminController;
use \App\Http\Controllers\Auth\AuthController;
use \App\Http\Controllers\Category\CategoryController;
use \App\Http\Controllers\Client\ClientController;
use \App\Http\Controllers\Image\ImageController;
use \App\Http\Controllers\PageController;
use \App\Http\Controllers\Product\ProductController;


use \App\Http\Middleware\AdminMiddleware;




Route::Post('/images/getall', [ImageController::class, 'getImages']);
Route::Post('/images/delete', [ImageController::class, 'delete']);

Route::Get('/client/products/getall', [ClientController::class, 'getAllProducts'])->middleware('auth');

Route::Post('/login', [AuthController::class, 'tryToLogin']);


Route::middleware(['adminMW'])->prefix('admin')->group(function () {
  Route::Get('/dashboard', [AdminController::class, 'getDashboardData']);
  Route::Get('/users', [AdminController::class, 'getUsers']);
  Route::Get('/products', [AdminController::class, 'getProducts']);
  Route::Get('/logs', [AdminController::class, 'getLogs']);
});

Route::middleware(['clientMW'])->prefix('client')->group(function() {
  Route::Get('dashboard', [ClientController::class, 'getDashboardData']);
  Route::Get('/products', [ClientController::class, 'getProducts']);
});
