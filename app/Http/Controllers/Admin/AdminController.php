<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Models\User;

/**
 * Az adminnal kapcsolatos routeok lefedése.
 */
class AdminController extends Controller
{
    //

  public function displayDashboard() {
    return view('admin.dashboard');
  }


  public function displayUsers() {
    $allUsers = User::all();
    return view('admin.users.display', array('users' => $allUsers));
  }

  public function displayProducts() {
    return view('admin.products.display');
  }


}
