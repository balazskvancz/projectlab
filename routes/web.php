<?php


use \App\Http\Controllers\Admin\AdminController;
use \App\Http\Controllers\Auth\AuthController;
use \App\Http\Controllers\Client\ClientController;
use \App\Http\Controllers\PageController;

use Illuminate\Support\Facades\Route;

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

/** ADMIN */
Route::prefix('admin')->group(function () {
  Route::get('/dashboard', [AdminController::class, 'displayDashboard'])->name('admin_dashboard');

  Route::prefix('users')->group(function () {
    Route::Get('/', [AdminController::Class, 'displayUsers'] )->name('admin_users');
  });

  Route::prefix('products')->group(function() {
    Route::Get('/', [AdminController::class, 'displayProducts'])->name('admin_products');
  });

});


/** KLIENS */
Route::prefix('client')->group(function () {
  Route::get('/dashboard', [ClientController::class, 'displayDashboard'])->name('client_dashboard');


  Route::prefix('products')->group(function() {
    Route::Get('/', [ClientController::class, 'displayProducts'])->name('client_products');
  });

});
