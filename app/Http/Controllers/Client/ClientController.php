<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{


  /**
   * Megjeleníti a dashboardot.
   */
  public function displayDashboard() {
    dd('mivan');
  }

  /**
   * Megjeleníti az éppen bejelentkezett user-hez tartozó termékeket.
   */
  public function displayProducts() {
    dd('asd');
  }
}

