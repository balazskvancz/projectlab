<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use \App\Http\Controllers\Product\ProductController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


use \App\Models\Login;
use \App\Models\Product;
use \App\Models\ProductCategory;
use \App\Models\ProductImage;

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

    $data = array();

    $data['productsCount']   = count($ownProducts);
    $data['lastLogin']       = $lastLogin;

    return json_encode($data);
  }

  /**
   * Megjeleníti az éppen bejelentkezett user-hez tartozó termékeket.
   */
  public function displayProducts(Request $request) {
    $fields = json_decode($request->data);

    $user = User::find($field->userid);

    if (is_null($user)) {
      return "";
    }

    // Elkérjük a queryParamot.
    $sort = $request->query('sort');

    $sorting = ProductController::getOrderOptions();

    $keys  = ProductController::getKeysWithLabel();

    $categories = ProductCategory::where('deleted', '=', 0)
    ->orderBy('name', 'asc')
    ->get();

    $products = Product::with('getCategory')
    ->where([
      ['deleted', '=', 0],
      ['creatorId', '=', $user->id]
    ]);


    $products = ProductController::orderBy($sort, $products);

    $data = array();

    $data['categories']   = $categories;
    $data['products']     = $products;
    $data['keys']         = $keys;
    $data['sorting']      = $sorting;
    $data['currentSort']  = $sort;

    return json_encode($data);
  }

  /**
   * Megjelenít egy adott termékekt.
   */
  public function displayProduct ($id) {
    $fields = json_decode($request->data);

    $user = User::find($field->userid);

    if (is_null($user)) {
      return "";
    }
    // Létezik ilyen termék?

    $product = Product::where([
      ['id', '=', $id],
      ['deleted', '=', 0],
      ['creatorId', '=', $user->id]
    ])->first();

    // Van ilyen termék?
    if (is_null($product)) {
      abort(404);
    }

    $keys = ProductController::getKeysWithLabel();

    $data = array();

    $data['product'] = $product;
    $data['keys']    = $keys;

    return json_encode($data);
  }

  /**
   * Megjeleníti egy adott terméke módosítási nézetét.
   */
  public function editProduct($id) {

    // Létezik ilyen termék?
    $product = Product::where([
      ['id', '=', $id],
      ['deleted', '=', 0],
      ['creatorId', '=', auth()->user()->id]
    ])->first();

    // Ha nincs ilyen termék, akkor dobjon hibát.
    if (is_null($product)) {
      abort(404);
    }

    $keys       = ProductController::getKeysWithLabel();

    $categories = ProductCategory::where('deleted', '=', 0)
    ->orderBy('name', 'asc')->get();

    $apikey = Hash::make(auth()->user()->apikey);

    return view('client.products.edit', array(
      'product'     => $product,
      'keys'        => $keys,
      'categories'  => $categories,
      'apikey'      => $apikey,
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

    $images = ProductImage::join('products', 'product_images.productId', '=', 'products.id')
      ->where([
        ['products.creatorId', '=', auth()->user()->id],
        ['product_images.deleted', '=', 0]
      ])
      ->select('product_images.id', 'products.name', 'product_images.path', 'product_images.created_at')
      ->get();


    $apikey = Hash::make(auth()->user()->apikey);

    return view('client.images.display', array(
      'products' => $products,
      'images'   => $images,
      'apikey'   => $apikey));
  }

}

