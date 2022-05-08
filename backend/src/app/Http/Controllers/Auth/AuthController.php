<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use \App\Models\User;
use \App\Models\Login;

class AuthController extends Controller {
   /**
   * Megpróbálja bejelentkeztetni a usert, a request alapján.
   * Siker esetén, jogosultsági szint alapján irányítja tovább.
   *
   * @param Request A bejövő request
   * @return void
   */
  public function tryToLogin(Request $request) {
    $fields = json_decode($request->data);

    $user = User::where('username', '=', $fields->name)->first();

    // Ha nincs ilyen user, akkor adjunk vissza üres sztringet.
    if (is_null($user)) {

      return json_encode("");
    }

    // Ha nem jó a jelszó, ami megadott.
    if(!Hash::check($fields->password, $user->password)) {

      return json_encode("");
    }

    // Ekkor "sikeres" volt a bejelentkezés.
    // Logoljuk a bejelentkeztést.
    Login::create([
      'userId' => $user->id
    ]);

    $userModel = array();

    $userModel['userid'] = $user->id;
    $userModel['apikey'] = $user->apikey;
    $userModel['role']   = $user->role;

    return json_encode($userModel);
  }
}
