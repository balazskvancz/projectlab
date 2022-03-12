<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use \App\Http\Controllers\Product\ProductController;
use Illuminate\Http\Request;

use \App\Models\Login;
use \App\Models\Product;
use \App\Models\ProductCategory;

/**
 *
 */
class ClientController extends Controller {


  /**
   * Megjeleníti a dashboardot.
   */
  public function displayDashboard() {

    $ownProducts = Product::where([
      ['creatorId', '=', auth()->user()->id],
      ['deleted', '=', 0]
    ])->get();

    $lastLogin = Login::where('userId', '=', auth()->user()->id)->orderBy('id', 'desc')->first();

    $lastLogin = is_null($lastLogin) ? 'Nem volt' : $lastLogin->created_at;


    return view('client.dashboard', array(
      'productsCount'   => count($ownProducts),
      'lastLogin'       => $lastLogin
    ));
  }

  /**
   * Megjeleníti az éppen bejelentkezett user-hez tartozó termékeket.
   */
  public function displayProducts() {

    $keys       = ProductController::getKeysWithLabel();
    $categories = ProductCategory::orderBy('name', 'asc')->get();
    $products = Product::with('getCategory')
    ->where([
      ['deleted', '=', 0],
      ['creatorId', '=', auth()->user()->id]
    ])
    ->get();

    return view('client.products.display',
     array(
        'categories' => $categories,
        'products'   => $products,
        'keys'       => $keys,
      ));
  }

  /**
   * Megjeleníti egy adott terméke módosítási nézetét.
   */
  public function editProduct($id) {

    // Létezik ilyen termék?
    $product = Product::findOrFail($id);

    // Az éppen bejelentkezett user-hez tarozik?
    if ($product->creatorId != auth()->user()->id) {
      abort(404);
    }

    $keys       = ProductController::getKeysWithLabel();
    $categories = ProductCategory::orderBy('name', 'asc')->get();

    return view('client.products.edit', array(
      'product'     => $product,
      'keys'        => $keys,
      'categories'  => $categories,
    ));
  }
}

