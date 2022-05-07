<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Logolási model.
 */
class Log extends Model {
  use HasFactory;

  /**
   * Fillables.
   */
  protected $fillable = [
    'productId',        // Termék azonosító.
    'userId',           // Ki volt a user, aki végrehajtotta.
    'imageId',          // A feltöltött kép azonosítója.
    'commandType',      // Mi történt vele.
    'oldPrice',         // Régi ár (@nullable).
    'newPrice',         // Új ár (@nullable).
    'oldDescription',   // Régi leíárs (@nullable)
    'newDescription',   // Új leírás (@nullable)
  ];

  /**
   * Visszaadja, melyik user volt.
   */
  public function getUser() {
    return $this->belongsTo(\App\Models\User::class, 'userId', 'id');
  }

  /**
   * Visszaadja a termék egyedet.
   */
  public function getProduct() {
    return $this->belongsTo(\App\Models\Product::class, 'productId', 'id');
  }

  /**
   * Visszaaadja a hozzá tartozó képet.
   */
  public function getImage() {
    return $this->belongsTo(\App\Models\ProductImage::class, 'imageId', 'id');
  }
}
