<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller {

  /**
   * Megjeleníti a főoldalt.
   */
  public function displayHome() {
    return view('pages.index');
  }

  /**
   * Megjeleníti a bejelentkezés fület.
   */
  public function displayLogin() {
    return view('pages.login');
  }

}
