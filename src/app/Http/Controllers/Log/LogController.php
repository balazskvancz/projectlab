<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Models\Log;

/**
 * Logolással kapcsolatos műveleteket hajtja végre.
 */
class LogController extends Controller {

  // Állapotok.
  //
  // 1 - Új termék felvétele.
  // 2 - Termék módosítása.
  // 3 - Termék törlése.

  public static function getCommands() {
    $array = arra();

    $array["1"] = "Insert";
    $array["2"] = "Update";
    $array["3"] = "Delete";

    return $array;
  }

  /**
   * Új termék felvétele.
   *
   * @param number $productId: A termék id-ja.
   * @param number $userId: Melyik user hajtotta végre.
   */
  public static function insertProduct($productId, $userId) {
    Log::create([
      'productId'     => $productId,
      'userId'        => $userId,
    ]);
  }

  /**
   * Egy adott termék árának módosítása.
   *
   * @param number $productId: A termék id-ja.
   * @param number $userId: Melyi user hajtotta végre a műveletet.
   * @param number $oldPrice: A termék régi ára.
   * @param number $newPrice: A termék új ára.
   */
  public static function modifyPrice($productId, $userId, $oldPrice, $newPrice) {
    Log::create([
      'productId'      => $productId,
      'userId'         => $userId,
      'oldPrice'       => $oldPrice,
      'newPrice'       => $newPrice
    ]);
  }

  /**
   * Egy adott termékről tárolja, hogy törölve lett.
   *
   * @param number $productId: A termék id-ja.
   * @param number $userId: Melyik user hajtotta végre a műveletet.
   */
  public static function deleteProduct($productId, $userId) {
    Log::create([
      'productId'      => $productId,
      'userId'         => $userId
    ]);
  }




}
