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


use \App\Models\Product;
use \App\Models\ProductCategory;


/**
 * Az alkalmazás során felhasznált route-ok.
 */

// Route::Get('/', [PageController::class, 'displayHome']);
Route::Get('/', [AuthController::class, 'displayLogin'])->name('login');

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


      Route::Get('{id}/show', [AdminController::class, 'displayProduct']);
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

/**
 * Feltölti az adatbázist dummay adatokkal.
 */
Route::Get('/dummydata', function () {


  if (count(Product::all()) > 0 || count(ProductCategory::all()) > 0) {
    return;
  }
  // Kategóriák

  $books = ProductCategory::create([
    'name'    => 'Könyv'
  ]);

  $homeStuff = ProductCategory::create([
    'name'    => 'Háztartási cikk'
  ]);

  $itCat     = ProductCategory::create([
    'name'    => 'Számítástechnikai termék'
  ]);

  Product::create([
    'name'       => 'Gyűrűk ura',
    'categoryId' => $books->id,
    'sku'        => '10001',
    'price'      => '5000',
    'creatorId'  => 2
  ]);

  Product::create([
    'name'       => 'Végtelen tréfa',
    'categoryId' => $books->id,
    'sku'        => '10002',
    'price'      => '7000',
    'description' => 'Magávalragadó történet David Foster Wallace tollából.',
    'creatorId'  => 2
  ]);

  Product::create([
    'name'       => 'Harry Potter',
    'categoryId' => $books->id,
    'sku'        => '10003',
    'price'      => '5000',
    'creatorId'  => 2
  ]);

  Product::create([
    'name'       => 'Porszívó piros színű',
    'categoryId' => $homeStuff->id,
    'sku'        => 'porszivo_piros',
    'price'      => '25000',
    'description' => 'Nagyteljesítményű otthoni porszvó, piros színben.',
    'creatorId'  => 2
  ]);


  Product::create([
    'name'       => 'Mikrohullámú sütő',
    'categoryId' => $homeStuff->id,
    'sku'        => 'mikrohullamu_suto',
    'price'      => '35000',
    'description' => '600W teljesítményű mikrohullámú sütő.',
    'creatorId'  => 3,
  ]);

  Product::create([
    'name'       => 'Vasaló',
    'categoryId' => $homeStuff->id,
    'sku'        => 'vasalo',
    'price'      => '7000',
    'description' => '',
    'creatorId'  => 3,
  ]);


  Product::create([
    'name'       => 'Monitor 24 col',
    'categoryId' => $itCat->id,
    'sku'        => 'monitor24',
    'price'      => '35000',
    'description' => '24 colos monitor, jó minőség',
    'creatorId'  => 3,
  ]);


  Product::create([
    'name'       => 'Laptop',
    'categoryId' => $itCat->id,
    'sku'        => 'laptop',
    'price'      => '1000000',
    'description' => 'Nagyon erős laptop, sötétszürke színben',
    'creatorId'  => 3,
  ]);


  Product::create([
    'name'       => 'Videókártya',
    'categoryId' => $itCat->id,
    'sku'        => 'videokartya',
    'price'      => '24990',
    'description' => 'BitCoin bányászatra alkalmas GPU',
    'creatorId'  => 3,
  ]);
});
