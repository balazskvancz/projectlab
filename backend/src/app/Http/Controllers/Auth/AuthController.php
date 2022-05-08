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
    $user = User::where('username', '=', $request->name)->first();

    // Ha nincs ilyen user, akkor adjunk vissza üres sztringet.
    if (is_null($user)) {
      return "";
    }

    // Ha nem jó a jelszó, ami megadott.
    if(!Hash::check($request->password, $user->password)) {
      return "";
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
