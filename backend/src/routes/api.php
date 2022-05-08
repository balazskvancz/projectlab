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

Route::Get('/categories', [CategoryController::class, 'get']);
Route::Post('/products/{id}/delete', [ProductController::class, 'delete']);

Route::middleware(['adminMW'])->prefix('admin')->group(function () {
  Route::Get('/dashboard', [AdminController::class, 'getDashboardData']);

  Route::Get('/users', [AdminController::class, 'getUsers']);

  Route::Post('/categories/{id}/delete', [CategoryController::class, 'delete']);
  Route::Post('/categories', [CategoryController::class, 'store']);

  Route::Get('/products', [AdminController::class, 'getProducts']);

  Route::Get('/logs', [AdminController::class, 'getLogs']);


  Route::Post('/categories/{id}/delete', [CategoryController::class, 'delete']);
});

Route::middleware(['clientMW'])->prefix('client')->group(function() {
  Route::Get('dashboard', [ClientController::class, 'getDashboardData']);
  Route::Get('/products', [ClientController::class, 'getProducts']);

  Route::Get('/product/{id}', [ClientController::class, 'getProduct']);

  Route::Post('/products', [ProductController::class, 'store']);

  Route::Post('/images/upload', [ImageController::class, 'store']);
  Route::Post('/images/delete/{id}', [ImageController::class, 'delete']);
});
