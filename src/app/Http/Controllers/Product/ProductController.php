<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Models\Product;

use \App\Http\Requests\PostProductRequest;

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
  public function store (PostProductRequest $request) {
    // Van már ilyen nevű vagy sku-val rendelkező termék?
    $products = Product::where('name', '=', $request->name)
    ->where('sku', '=', $request->sku)
    ->get();

    // Már van ilyen, térjünk vissza.
    if (count($products) > 0) {
      return;
    }

    $newProduct = Product::create([
      'name'            => $request->name,
      'categoryId'      => $request->categoryId,
      'sku'             => $request->sku,
      'price'           => $request->price,
      'description'     => $request->description,
      'creatorId'       => auth()->user()->id
    ]);


    if ($newProduct) {
      $this->outcome = 'success';
      $this->msg     = 'Sikeres művelet.';
    }

    return redirect()->back()->with($this->outcome, $this->msg);

  }

  /**
   * Töröl egy terméket. (Soft-delete)
   */
  public function delete ($id) {

    // Létezik ilyen termék?
    // Ha nincs ilyen, dobjon 404-t.
    $product = Product::findOrFail($id);

    // Admin vagy nem?
    $currentUser = auth()->user();

    // Ha, a jelenelgi user nem admin & nem hozzá tartozik a jelen termék,
    // dogjon error-t.
    if ($currentUser->role == 1 && $product->creatorId != $currentUser->id) {
      return ;
    }


    // Soft delete
    $product->deleted = 1;

    if ($product->save()) {
      $this->outcome = 'success';
      $this->msg     = 'Sikeres művelet.';
    }

    // Hova kell majd visszairányítani a user-t?
    $route = auth()->user()->role == 2 ? 'admin_products' : 'client_products';

    return redirect()->route($route)->with($this->outcome, $this->msg);
  }

  /**
   * Updateel, egy adott terméket.
   */
  public function update ($id, PostProductRequest $request) {

    // Létezik ilyen termék?
    $product = Product::findOrFail($id);

    // Ha nem megfelelő jogosultság. Értsd: valaki, nem a saját termékét szeretné módosítani
    // akkor dobjon hibát. TODO: elegánsabb megoldás!
    if (auth()->user()->role == 1 && auth()->user()->id != $product->creatorId) {
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

      }
    }

    // Volt cikkszámváltoztatás?
    if ($product->sku != $request->sku) {
      $skuQuery = Product::where([
        ['sku', '=', $request->sku],
        ['deleted', '=', 0]
      ])->get();

      // Error
      if (count($skuQuery) > 0) {

      }

    }

    $keys = ProductController::getKeysWithLabel();

    foreach ($keys as $key => $value) {
      $product->$key = $request->$key;
    }

    $redirectRoute = auth()->user()->role == 1 ? 'client_products' : 'admin_products';

    if ($product->save()) {
      $this->outcome = 'success';
      $this->msg     = 'Sikeres művelet.';
    }

    return redirect()->route($redirectRoute)->with($this->outcome, $this->msg);
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
