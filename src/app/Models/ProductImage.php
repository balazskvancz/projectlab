<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Az egyes termékekhez tartozó kép egyedek.
 */
class ProductImage extends Model
{
  use HasFactory;

  /**
   * Fillables.
   * @var array<int, string>
   */
  protected $fillable = [
    'productId',
    'path',
    'deleted'
  ];


  /**
   * Visszaadja, hogy az adott kép egyed, melyik termékhez tartozik.
   * @return {\App\Models\Product} A termék egyed.
   */
  public function getProduct() {
    return $this->belongsTo(\App\Models\Product::class, 'productId', 'id');
  }

}
