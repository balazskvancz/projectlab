<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use \App\Models\Login;
use \App\Models\User;

/**
 * Authentikációval kapcsolatos routeok, requestek kezelése.
 */
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


  /**
   * Kijelentkzeteti a usert.
   *
   * @param Request A bejövő request.
   */
  public function logout(Request $request) {
    auth()->logout();
    return redirect()->route('login')->with('success', 'Sikeres kijelentkezés.');
  }


  /**
   * Létrehoz 3 felhasználót. 1 admin-t és 2 sima user-t.
   *
   * Csak abban az esetben fut le, ha még NINCS egy user sem felvéve.
   */
  public function createUsers () {

    $allUsers = User::all();

    // Ha már van legalább egy user, egyszerűen navigáljunk át, a login-ra.
    if (count($allUsers) > 0) {
      return redirect()->route('login');
    }

    // Admin
    $admin = User::create([
      'username' => 'admin',
      'password' => Hash::make('admin'),
      'role'     => 2
    ]);

    // Első user
    $userOne = User::create([
      'username' => 'user1',
      'password' => Hash::make('user1'),
      'role'     => 1
    ]);

    // Második user
    $userOne = User::create([
      'username' => 'user2',
      'password' => Hash::make('user2'),
      'role'     => 1
    ]);


    return redirect()->route('login');

  }
}
