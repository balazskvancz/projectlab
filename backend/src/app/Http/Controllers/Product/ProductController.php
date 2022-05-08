<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use \App\Http\Controllers\Log\LogController;
use Illuminate\Http\Request;

use \App\Models\User;
use \App\Models\Product;


use \App\Http\Requests\PostProductRequest;
use \App\Http\Requests\StoreProductRequest;

/**
 * Termék kezelés
 */
class ProductController extends Controller {

  private $outcome = 'fail';
  private $msg     = 'Sikertelen művelet.';

  private static $nameAsc   = 'name_asc';
  private static $nameDesc  = 'name_desc';
  private static $priceAsc  = 'price_asc';
  private static $priceDesc = 'price_desc';

  /**
   * Egy új egyed felvétele.
   */
  public function store (StoreProductRequest $request) {
    $cookieUser = json_decode(base64_decode($request->cookie('loggedUser')));

    $user = User::find($cookieUser->userId);

    if (!$user) {
      return;
    }

    // Van már ilyen nevű vagy sku-val rendelkező termék?
    $products = Product::where('name', '=', $request->name)
    ->get();

    // Már van ilyen, térjünk vissza.
    if (count($products) > 0) {
      return;
    }

    $newProduct = Product::create([
      'name'            => $request->name,
      'categoryId'      => $request->categoryId,
      'price'           => $request->price,
      'description'     => $request->description,
      'creatorId'       => $user->id
    ]);


    // Ha sikerült kreálni, akkor siker üzenez
    // + log-ba mentjük.
    if ($newProduct) {
      $this->outcome = 'success';
      $this->msg     = 'Sikeres művelet.';

      LogController::insertProduct($newProduct->id, $currentUserId);
    }
  }

  /**
   * Töröl egy terméket. (Soft-delete)
   */
  public function delete (Request $request, $id) {
    $cookieUser = json_decode(base64_decode($request->cookie('loggedUser')));
    // Létezik ilyen termék?
    // Ha nincs ilyen, dobjon 404-t.
    $product = Product::findOrFail($id);

    // Admin vagy nem?
    $currentUser = User::where([
      ['apikey', '=', $cookieUser->apikey],
      ['id', '=', $cookieUser->userid],
    ])->first();

    // Ha, a jelenelgi user nem admin & nem hozzá tartozik a jelen termék,
    // ne csináljon semmit.
    if ($currentUser->role == 1 && $product->creatorId != $currentUser->id) {
      return;
    }

    // Soft delete
    $product->deleted = 1;

    // Sikeres mentés esetén, üznetek beállítása
    // illetve a log megírása.
    if ($product->save()) {
      $this->outcome = 'success';
      $this->msg     = 'Sikeres művelet.';

      LogController::deleteProduct($product->id, $currentUser->id);
    }
  }

  /**
   * Updateel, egy adott terméket.
   */
  public function update ($id, PostProductRequest $request) {
    $cookieUser = json_decode(base64_decode($request->cookie('loggedUser')));
    // Létezik ilyen termék?
    $product = Product::findOrFail($id);

    $currentUser = User::find($cookieUser->userid);

    // Ha nem megfelelő jogosultság. Értsd: valaki, nem a saját termékét szeretné módosítani
    // akkor dobjon hibát. TODO: elegánsabb megoldás!
    if ($currentUser->role == 1 &&
        $currentUser->id != $product->creatorId) {
      abort(404);
    }

    // Volt névváltoztatás?
    if ($product->name != $request->name) {
      $nameQuery = Product::where([
        ['name', '=', $request->name],
        ['deleted', '=', 0]
      ])->get();

      // Error
      if (count($nameQuery) > 0) {
        return "Ilyen névvel már létezik termék.";
      }
    }

    $keys = ProductController::getKeysWithLabel();

    // az előző ár.
    $oldPrice = $product->price;

    // előző leírás
    $oldDescription = $product->description;



    foreach ($keys as $key => $value) {
      $product->$key = $request->$key;
    }

    // Sikeres mentés esetén, beállítjuk a üzenetet
    // illvete logolunk.
    if ($product->save()) {
      // Ha történt ármódosítás, akkor azt logoljuk.
      if ($oldPrice != $product->price) {
        LogController::modifyPrice($product->id, $currentUser->id, $oldPrice, $product->price);
      }

      // Ugyanezt megtesszük leírás esetében is.
      if ($oldDescription != $product->description) {
        LogController::modifyDescription($product->id, $currentUser->id, $oldDescription, $product->description);
      }
    }
  }

  /**
   * Visszaadja a Termék model attribútumait, és hozzá egy label-t.
   *
   * @return array
   */
  public static function getKeysWithLabel() {
    $keysWithLabels = array();

    $keysWithLabels['name']         = 'Megnevezés';
    $keysWithLabels['sku']          = 'Cikkszám';
    $keysWithLabels['categoryId']   = 'Kategória';
    $keysWithLabels['description']  = 'Leírás';
    $keysWithLabels['price']        = 'Ár';

    return $keysWithLabels;
  }

  /**
   * Visszaadja a rendezési opciókat.
   *
   * @return array
   */
  public static function getOrderOptions() {
    $sorting = array();
    $sorting[ProductController::$nameAsc]    = 'Név szerint növekvő';
    $sorting[ProductController::$nameDesc]   = 'Név szerint csökkenő';
    $sorting[ProductController::$priceAsc]   = 'Ár szerint növekvő';
    $sorting[ProductController::$priceDesc]  = 'Ár szerint csökkenő';

    return $sorting;
  }

  public static function orderBy($condition, $collection) {

    if ($condition == ProductController::$nameAsc) {
      $collection = $collection->orderBy('name', 'asc')->get();
    } else if ($condition == ProductController::$nameDesc) {
      $collection = $collection->orderBy('name', 'desc')->get();
    } else if ($condition == ProductController::$priceAsc) {
      $collection = $collection->orderBy('price', 'asc')->get();
    } else if ($condition == ProductController::$priceDesc) {
      $collection = $collection->orderBy('price', 'desc')->get();
    } else {
      $collection = $collection->get();
    }


    return $collection;
  }


}

