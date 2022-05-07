<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use \App\Models\Product;
use \App\Models\User;

use \App\Http\Requests\BaseApiRequest;

class GetImagesRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize(BaseApiRequest $req) {
    $user = User::find($req->userId);

    // Le kell vizsgálni, hogy egyáltalán az adott user-hez tartozik e
    // az adott termék.
    $product = Product::find($req->productId);

    // Ha nincs ilyen termék.
    if (is_null($product)) {
      return false;
    }

    // Megegyik?
    return $product->creatorId == $user->id;
  }

  /**
   * Gyakorlatilag validációra semmi szükség, adatot nem akarunk
   * seholsem tárolni vagy bármi ilyesmi.
   *
   * @return array
   */
  public function rules() {
    return [];
  }
}
