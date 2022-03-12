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
class AuthController extends Controller
{

  /**
   * Megjeleníti a bejelentkezés nézetet.
   */
  public function displayLogin() {

    // Van már bejelentkezett user?
    if (auth()->user()) {


      if (auth()->user()->role == 2) {
        return redirect()->route('admin_dashboard');
      }

      return redirect()->route('client_dashboard');
    }


    // Ha nincs, akkor adjuk vissza a bejelentkezés view-t.
    return view('pages.login');
  }

  /**
   * Megpróbálja bejelentkeztetni a usert, a request alapján.
   * Siker esetén, jogosultsági szint alapján irányítja tovább.
   *
   * @param Request A bejövő request
   * @return void
   */
  public function tryToLogin(Request $request) {

    // Létezik ilyen user?
    $user = User::where('username', '=', $request->username)->first();


    if (is_null($user)) {
      return redirect()->route('login')->with('error', 'Sikertelen bejelentkezés.'); //errorr,
    }

    // Ha sikerül a bejelentkezés.
    if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {

      // Elmentünk egy bejelentkezési statisztikát.
      Login::create([
        'userId' => auth()->user()->id
      ]);

      if (auth()->user()->role == 2) {
        return redirect()->route('admin_dashboard');
      }

      return redirect()->route('client_dashboard');
    }


    // Ha nem sikerül bejelentkezni, akkor is, csak egyszerűen dobjuk vissza.
    return redirect()->route('login')->with('error', 'Sikertelen bejelentkezés.'); //errorr,
  }

  /**
   * Kijelentkzeteti a usert.
   *
   * @param Request A bejövő request.
   */
  public function logout(Request $request) {
    auth()->logout();
    return redirect()->route('login')->with('Sikeres kijelentkezés.');
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

  /**
   * Felhasználói jogosultság alapján irányítja tovább a bejelentkezett user-t.
   */
  public function redirectUser() {

  }
}
