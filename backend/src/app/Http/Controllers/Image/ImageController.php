<?php

namespace App\Http\Controllers\Image;

use \App\Models\Product;
use \App\Models\ProductImage;
use \App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Http\Controllers\Log\LogController;

use \App\Http\Requests\DeleteImageRequest;
use \App\Http\Requests\GetImagesRequest;
use \App\Http\Requests\PostImageRequest;

/**
 * Képek kezelésért felelős kontroller.
 */
class ImageController extends Controller {

  private $outcome = 'fail';
  private $msg     = 'Sikertelen művelet.';

  /**
   * Felölt egy képet, egy adott termékhez.
   */
  public function store(PostImageRequest $request) {
    $cookieUser = json_decode(base64_decode($request->cookie('loggedUser')));
    // Létezik ilyen termék?
    $product = Product::findOrFail($request->product);

    if(!$request->file('image')) {
      return "Nem tartalmaz fájlt.";
    }

    $image = $request->file('image');

    // Meghatározzuk, mi a kiterjesztése.
    $extension = $image->getClientOriginalExtension();

    // Adunk neki egy nevet.
    $fileName = $product->id . '_' . time(). '.' . $extension;

    $image->move(public_path('/images/uploads'), $fileName);

    $newImage = ProductImage::create([
      'productId'  => $product->id,
      'path'       => $fileName
    ]);

    // Ha sikerült menteni, akkor azt logoljuk.
    if ($newImage) {
      LogController::uploadImage($product->id, $cookieUser->userid, $newImage->id);
      return "";
    }

    return "Sikertelen művelet.";
  }

  /**
   * API hívás esetén visszaadja az összes, egy adott user-hez tartozó (nem törölt) képet.
   */
  public function getImages(GetImagesRequest $request) {
    $images = ProductImage::where([
      ['productId', '=', $request->productId],
      ['deleted', '=', 0]
    ])->get();

    return json_encode($images);
  }

  /**
   * Töröl egy adott képet. (softDelete)
   */
  public function delete(Request $request, $id) {
    $cookieUser = json_decode(base64_decode($request->cookie('loggedUser')));

    $user = User::where([
      ['id', '=', $cookieUser->userid],
      ['apikey', '=', $cookieUser->apikey]
    ])->first();

    if (is_null($user)) {
      abort(500);
    }

    $image = ProductImage::find($id);

    if (is_null($image)) {
      abort(500);
    }

    $product = $image->getProduct;
    if ($product->creatorId != $user->id) {
      abort(403);
    }
    $image->deleted = 1;

    // Ha sikerül menteni, akkor beállítjuk, hogy sikeres volt
    // illetve, logoljuk az eseményt.
    if ($image->save()) {
      LogController::deleteImage($product->id, $user->id, $image->id);
    }
  }
}
