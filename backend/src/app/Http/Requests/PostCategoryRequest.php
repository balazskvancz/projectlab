<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use \App\Models\User;


use Illuminate\Http\Request;

class PostCategoryRequest extends FormRequest
{
    /**
     * Csak az admin hozhat létre új terméket.
     *
     * @return bool
     */
    public function authorize(Request $request) {
      $cookieUser = json_decode(base64_decode($request->cookie('loggedUser')));

      $user = User::where([
        ['id', '=', $cookieUser->userid],
        ['apikey', '=', $cookieUser->apikey]
      ])->first();


      if (is_null($user) || $user->role == 1) {
        return false;
      }

      return true;
    }

    /**
     * A validációs feltételek, új termék felvétele esetén.
     *
     * @return array
     */
    public function rules() {
        return [
          'name'=> 'required|unique:product_categories|max:191'
        ];
    }

    /**
     * Visszaadja az egyes validációs feltételekhez tartozó hibaüzeneteket.
     */
    public function messages() {
      return [
        'required' => 'A mező kitöltése kötelező.',
        'max'      => 'A mező maximális hossza 191 karakter lehet.',
        'unique'   => 'Ezzel a névvel már létezik kategória.'
      ];
    }

}
