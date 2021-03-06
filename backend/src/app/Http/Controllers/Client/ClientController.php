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
use \App\Models\User;

/**
 *
 */
class ClientController extends Controller {

  /**
   * Megjeleníti a dashboardot.
   */
  public function getDashboardData(Request $request) {
    $cookieUser = json_decode(base64_decode($request->cookie('loggedUser')));

    $ownProducts = Product::where([
      ['creatorId', '=', $cookieUser->userid],
      ['deleted', '=', 0]
    ])->get();

    $lastLogin = Login::where('userId', '=', $cookieUser->userid)
    ->orderBy('id', 'desc')->get();

    $lastLogin = count($lastLogin) <= 1 ? 'Nem volt' : (string) $lastLogin[1]->created_at;

    $data = array();

    $data['productsCount']   = count($ownProducts);
    $data['lastLogin']       = $lastLogin;

    return json_encode($data);
  }

  /**
   * Megjeleníti az éppen bejelentkezett user-hez tartozó termékeket.
   */
  public function getProducts(Request $request) {
    $cookieUser = json_decode(base64_decode($request->cookie('loggedUser')));

    $products = Product::
      select(
        "products.id",
        "products.name",
        "product_categories.name AS categoryName"
      )
      ->join('product_categories', 'product_categories.id', '=', 'products.categoryId')
      ->where([
        ['products.creatorId', '=', $cookieUser->userid],
        ['products.deleted', '=', 0]
      ])
      ->orderBy('name', 'asc')
      ->get();

    return json_encode($products);
  }

  /**
   * Megjelenít egy adott termékekt.
   */
  public function getProduct (Request $request, $id) {
    $cookieUser = json_decode(base64_decode($request->cookie('loggedUser')));
    $user = User::where([
      ['id', '=', $cookieUser->userid],
      ['apikey', '=', $cookieUser->apikey]
    ])->first();

    if (is_null($user)) {
      return null;
    }
    // Létezik ilyen termék?

    $product = Product::select(
      "products.id",
      "products.name",
      "products.price",
      "products.description",
      "product_categories.name AS categoryName"
    )
    ->join('product_categories', 'product_categories.id', '=', 'products.categoryId')
    ->where([
      ['products.id', '=', $id],
      ['products.deleted', '=', 0],
      ['products.creatorId', '=', $user->id]
    ])->first();

    // Van ilyen termék?
    if (is_null($product)) {
      return null;
    }

    $images = ProductImage::where([
      ['productId', '=', $product->id],
      ['deleted', '=', 0]
    ])->get();

    $product->images = $images;

    return $product;
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

