<?php


use \App\Http\Controllers\Admin\AdminController;
use \App\Http\Controllers\Auth\AuthController;
use \App\Http\Controllers\Category\CategoryController;
use \App\Http\Controllers\Client\ClientController;
use \App\Http\Controllers\Image\ImageController;
use \App\Http\Controllers\PageController;
use \App\Http\Controllers\Product\ProductController;

use Illuminate\Support\Facades\Route;

use \App\Http\Middleware\AdminMiddleware;
use \App\Http\Middleware\ClientMiddleware;

/**
 * Az alkalmazás során felhasznált route-ok.
 */

Route::Get('/', [PageController::class, 'displayHome']);

// Létrehozza a kezdő felhasználókat.
Route::Get('/createusers', [AuthController::class, 'createUsers']);


/** AUTHENTIKÁCIÓ */
Route::Get('/login', [AuthController::class, 'displayLogin'])->name('login');
Route::Post('/login', [AuthController::class, 'tryToLogin']);
Route::Post('/logout', [AuthController::class, 'logout'])->name('logout');

/** Ezek, mind belpéshez kötött route-ok. */
Route::group(['middleware' => 'auth'], function() {
  addAdminRoutes();
  addClientRoutes();
});


/** ADMIN */
function addAdminRoutes() {
  Route::middleware(['adminMW'])
  ->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'displayDashboard'])->name('admin_dashboard');

    Route::prefix('users')->group(function () {
      Route::Get('/', [AdminController::Class, 'displayUsers'] )->name('admin_users');
    });

    Route::prefix('products')->group(function() {
      Route::Get('/', [AdminController::class, 'displayProducts'])->name('admin_products');


      Route::Post('{id}/delete', [ProductController::class, 'delete']);

    });

    Route::prefix('categories')->group(function () {
      Route::Get('/', [AdminController::class, 'displayCategories'])->name('admin_categories');
      Route::Post('/', [CategoryController::class, 'store']);


      Route::Post('{id}/delete', [CategoryController::class, 'delete']);
    });
  });
}




/** KLIENS */
function addClientRoutes() {
  Route::middleware(['clientMW'])
  ->prefix('client')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'displayDashboard'])->name('client_dashboard');


    Route::prefix('products')->group(function() {
      Route::Get('/', [ClientController::class, 'displayProducts'])->name('client_products');
      Route::Post('/', [ProductController::class, 'store']);

      Route::Get('/{id}/show', [ClientController::class, 'displayProduct']);

      Route::Post('{id}/delete', [ProductController::class, 'delete']);

      Route::Get('{id}/edit', [ClientController::class, 'editProduct']);
      Route::Post('{id}/edit', [ProductController::class, 'update']);
    });

    Route::prefix('images')->group(function () {
      Route::Get('/', [ClientController::class, 'displayImages'])->name('client_images');

      Route::Post('/', [ImageController::class, 'store']);


    });

  });
}

