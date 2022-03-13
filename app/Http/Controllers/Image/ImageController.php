<?php

namespace App\Http\Controllers\Image;

use \App\Models\Product;
use \App\Models\ProductImage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
      $fileName = auth()->user()->id. '_' . time(). '.' . $extension;


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
}
