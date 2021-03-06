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
  public static $insertVal   = 1;
  public static $modifyPrice = 2;
  public static $deleteVal   = 3;
  public static $modifyDesc  = 4;
  public static $uploadImage = 5;
  public static $deleteImage = 6;

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
      'commandType'   => self::$insertVal
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
      'commandType'    => self::$modifyVal,
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
      'userId'         => $userId,
      'commandType'    => self::$deleteVal,
    ]);
  }

  /**
   * Egy adott termékről tárolja, hogy nódosították a leírását.
   *
   * @param number $productId: A termék id-ja.
   * @param number $userId: A módosítást végrehajtó felhasználó id-ja.
   * @param string $oldDescription: A régi leírás.
   * @param string $newDescription: A új leírás.
   */
  public static function modifyDescription($productId, $userId, $oldDescription, $newDescription) {
    Log::create([
      'productId'        => $productId,
      'userId'           => $userId,
      'commandType'      => self::$modifyDesc,
      'oldDescription'   => $oldDescription,
      'newDescription'   => $newDescription
    ]);
  }

  /**
   * Egy új kép feltöltését naplózza.
   *
   * @param number $productId: A termék azonosítója.
   * @param number $userId: A feltöltő azonosítója.
   * @param number $imageId: A kép azonosítója.
   */
  public static function uploadImage($productId, $userId, $imageId) {
    Log::create([
      'productId'        => $productId,
      'userId'           => $userId,
      'imageId'          => $imageId,
      'commandType'      => self::$uploadImage,
    ]);
  }

  /**
   * Egy kép törlését naplózza.
   *
   * @param number $productId: A termék azonosítója.
   * @param number $userId: A felhasználó azonosítója.
   * @param number $imageId: A kép azonosítója.
   */
  public static function deleteImage($productId, $userId, $imageId) {
    Log::create([
      'productId'       => $productId,
      'userId'          => $userId,
      'imageId'         => $imageId,
      'commandType'     => self::$deleteImage
    ]);
  }

}
