<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Http\Controllers\Log\LogController;
use \App\Http\Controllers\Product\ProductController;

use \App\Models\Log;
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
  public function displayProducts(Request $request) {

    $sort = $request->query('sort');

    $sorting = ProductController::getOrderOptions();

    $products = Product::where('deleted', '=', 0);

    $products = ProductController::orderBy($sort, $products);

    return view('admin.products.display', array(
      'products'    => $products,
      'sorting'     => $sorting,
      'currentSort' => $sort));
  }

  /**
   * Megjeleníti egy adott termék adatait az admin számára.
   */
  public function displayProduct($id) {

    // Létezik ilyen termék?
    $product = Product::findOrFail($id);


    $keys = ProductController::getKeysWithLabel();

    return view('admin.products.show', array(
      'product'   => $product,
      'keys'      => $keys
    ));
  }


  /**
   * Megjeleníti a kategóriák nézetet az admin számára.
   */
  public function displayCategories() {
    $allCategories = ProductCategory::where('deleted', '=', 0)->get();
    return view('admin.categories.display', array('categories' => $allCategories));
  }

  /**
   * Megjeleníti a logok néztetét.
   */
  public function displayLogs(Request $request) {

    $userQuery      = $request->query('userid');
    $startDateQuery = $request->query('startdate');
    $endDateQuery   = $request->query('enddate');


    $allUsers = User::where('role', '=', 1)
      ->orderBy('username')->get();

    // dd($allUsers);
    // Az összes log
    $logs = Log::
      select(
        "logs.created_at",
        "logs.oldPrice",
        "logs.newPrice",
        "logs.oldDescription",
        "logs.newDescription",
        "log_types.name AS logName",
        "log_types.id AS logType",
        "users.username",
        "products.name AS productName")
      ->join('users', 'users.id', '=', 'logs.userId')
      ->join('log_types', 'log_types.id', '=', 'logs.commandType')
      ->join('products', 'logs.productId', '=', 'products.id')
      ->orderBy('logs.created_at', 'DESC');

    if (!is_null($userQuery)) {
      $logs = $logs->where('users.id', '=', $userQuery);
    }

    if (!is_null($startDateQuery)) {
      $logs = $logs->where('logs.created_at', '>=', $startDateQuery);
    }

    if (!is_null($endDateQuery)) {
      $logs = $logs->where('logs.created_at', '<=', $endDateQuery);
    }

    $logs = $logs->paginate(10);

      // Meghatározzuk, mi volt a differencia.
    foreach ($logs as $log) {
      $log->diff = '';

      if ($log->logType == LogController::$modifyPrice) {
        $log->diff = $log->oldPrice . " -> " . $log->newPrice;
      }

      if ($log->logType == LogController::$modifyDesc) {
          // $diff = xdiff_string_diff($log->oldDescription, $log->newDescription, 1);
    }

      }

    return view('admin.logs.display', array(
      'logs'      => $logs,
      'users'     => $allUsers,
      'lastUser'  => $userQuery,
      'lastStart' => $startDateQuery,
      'lastEnd'   => $endDateQuery
    ));
  }

}
