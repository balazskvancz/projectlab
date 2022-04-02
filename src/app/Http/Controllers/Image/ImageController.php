<?php

namespace App\Http\Controllers\Image;

use \App\Models\Product;
use \App\Models\ProductImage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



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
    // Létezik ilyen termék?
    $product = Product::findOrFail($request->product);

    if($request->file('image')){

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

      if ($newImage) {
        $this->outcome = 'success';
        $this->msg     = 'Sikeres művelet.';
      }
    }

    return redirect()->back()->with($this->outcome, $this->msg);
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
  public function delete(DeleteImageRequest $request) {
    $image = ProductImage::find($request->imageId);

    $image->deleted = 1;

    if ($image->save()) {
      $this->outcome = 'success';
      $this->msg     = 'Sikeres művelet.';
    }

    // Abban az esetben, ha rendes form-ot sütöttünk el,
    // akkor irányítsuk vissza oda a felhasználót.
    if ($route->route == 0) {
      return redirect()->route('client_images')->with($this->outcome, $this->msg);
    }

    return $this->outcome . ": " . $this->msg;
  }
}
