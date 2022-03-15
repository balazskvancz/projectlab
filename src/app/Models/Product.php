<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Az adatbázisban előforduló termékek sémája.
 */
class Product extends Model
{
    use HasFactory;

    /**
     * Fillables.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'name',               // Termék megnevezése. @unique
      'categoryId',         // Milyen kategóriába tartozik a termék.
      'sku',                // Termék cikkszáma. @unique
      'price',              // Ár. @nullable
      'description',        // Leírás @nullable
      'creatorId',          // Ki hozta létre, (kiehz tartozik).
      'deleted',            // Törölve lett a termék, (0/1) => (false/true)
    ];

    /**
     * Visszaadja, melyik user a termék létrehozója.
     * @return <\App\Models\User> A felhasználó.
     */
    public function getUser() {
      return $this->belongsTo(\App\Models\User::class, 'creatorId', 'id');
    }

    /**
     * Visszaadja az összes, adott egyedhez tartozó összes feltölött képet.
     * @return <\App\Models\ProductImage[]> A képek tömbje.
     */
    public function getImages() {
      return $this->hasMany(\App\Models\ProductImage::class, 'productId', 'id');
    }

    /**
     * Visszadja, a hozzá tartozó kategóriát.
     */
    public function getCategory() {
      return $this->hasOne(\App\Models\ProductCategory::class, 'id', 'categoryId');

    }
}
