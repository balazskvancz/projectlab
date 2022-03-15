<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Bejelentkezéseket nyilvántaró model.
 */
class Login extends Model
{
  use HasFactory;

  protected $fillable = [
    'userId'
  ];

  /**
   * Visszaadja, melyik user-hez tartozik az adott bejelentkezés egyed.
   */
  public function getUser() {
    return $this->belongsTo(\App\Models\User::class, 'userId', 'id');
  }
}
