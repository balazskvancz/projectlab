<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Http\FormRequest;

use \App\Models\User;

/**
 * Legalapvetőbb api request.
 * 1) Megnézi van e egyáltalán ilyen user.
 * 2) Helyes e a megadott API kulcs.
 */
class BaseApiRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $req) {
      $user = User::find($req->userId);

      // Ha nincs ilyen user.
      if (is_null($user)) {
        return false;
      }

      // Ha nem egyezik az apiKey.
      return Hash::check($user->apikey, $req->apikey);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
