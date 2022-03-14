<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Models\Login;
use \App\Models\Product;
use \App\Models\ProductCategory;
use \App\Models\User;

/**
 * Az adminnal kapcsolatos routeok lefedése.
 */
class AdminController extends Controller {

  /**
   * Megjeleníti az admin oldali dashboardot.
   */
  public function displayDashboard() {
    $productsCount = count(Product::where('deleted', '=', 0)->get());
    $usersCount    = count(User::all());
    $logins        = Login::orderBy('id', 'desc')->limit(10)->get();

    return view('admin.dashboard', array(
      'productsCount'   => $productsCount,
      'usersCount'      => $usersCount,
      'logins'          => $logins,
    ));
  }


  /**
   * Megejeleníti a felhasználók nézetet az admin számára.
   */
  public function displayUsers() {
    $allUsers = User::all();
    return view('admin.users.display', array('users' => $allUsers));
  }

  /**
   * Megjeleníti a termékek nézetet az admin számára.
   */
  public function displayProducts() {

    $allProducts = Product::where('deleted', '=', 0)->get();

    return view('admin.products.display', array('products' => $allProducts));
  }

  /**
   * Megjeleníti a kategóriák nézetet az admin számára.
   */
  public function displayCategories() {
    $allCategories = ProductCategory::where('deleted', '=', 0)->get();
    return view('admin.categories.display', array('categories' => $allCategories));
  }

}
