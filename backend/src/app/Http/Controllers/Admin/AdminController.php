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
  public function getDashboardData() {
    $productsCount = count(Product::where('deleted', '=', 0)->get());
    $usersCount    = count(User::all());
    $logins        = Login::join('users', 'logins.userid', '=', 'users.id')
      ->select('users.username', 'logins.created_at')
      ->orderBy('logins.id', 'desc')
      ->limit(10)
      ->get();

    $data = array();

    $data['productsCount'] = $productsCount;
    $data['usersCount']    = $usersCount;
    $data['logins']        = $logins;

    return json_encode($data);
  }


  /**
   * Visszaadja az összes user-t.
   */
  public function getUsers() {
    $allUsers = User::all();

    return json_encode($allUsers);
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

    $data = array();
    $data['product'] = $product;
    $data['keys']    = $keys;

    return json_encode($data);
  }


  /**
   * Megjeleníti a kategóriák nézetet az admin számára.
   */
  public function displayCategories() {
    $allCategories = ProductCategory::where('deleted', '=', 0)->get();

    return json_encode($allCategories);
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

    $data = array();

    $data['logs']      = $logs;
    $data['users']     = $allUsers;
    $data['lastUser']  = $userQuery;
    $data['lastStart'] = $startDateQuery;
    $data['lastEnd']   = $endDateQuery;

    return json_encode($data);
  }
}
