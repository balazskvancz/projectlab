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

    $lastLogin = Login::where('userId', '=', auth()->user()->id)
    ->orderBy('id', 'desc')->get();

    $lastLogin = count($lastLogin) <= 1 ? 'Nem volt' : $lastLogin[1]->created_at;


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

    $categories = ProductCategory::where('deleted', '=', 0)
    ->orderBy('name', 'asc')
    ->get();

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
   * Megjelenít egy adott termékekt.
   */
  public function displayProduct ($id) {

    // Létezik ilyen termék?
    $product = Product::findOrFail($id);

    $keys = ProductController::getKeysWithLabel();


    // Az adotemberhet tartozik?
    if ($product->creatorId != auth()->user()->id) {
      abort(403);
    }

    return view('client.products.show', array(
      'product' => $product,
      'keys'    => $keys,
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

    $categories = ProductCategory::where('deleted', '=', 0)
    ->orderBy('name', 'asc')->get();

    return view('client.products.edit', array(
      'product'     => $product,
      'keys'        => $keys,
      'categories'  => $categories,
    ));
  }

  /**
   * Megjeleníti a képfeltöltési felületet a kliens számára.
   */
  public function displayImages() {

    // Le kell kérdezni az összes, az adott userhez tartzó termméket.
    $products = Product::where([
      ['creatorId', '=', auth()->user()->id],
      ['deleted', '=', 0]
    ])->get();


    return view('client.images.display', array('products' => $products));
  }

  /**
   * Api hívja meg.
   */
  public function getAllProduct() {

    dd(auth()->user());
  }
}

