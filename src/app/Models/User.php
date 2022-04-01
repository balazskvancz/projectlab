<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * A felhasználók sémája.
 */
class User extends Authenticatable {
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * Fillables.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'username',
    'password',
    'role',
    'apikey'
  ];

 /**
  * Nem sorosítható fieldek.
  *
  * @var array<int, string>
  */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Visszaadja az összes, az adott user által
   * felvett terméket.
   *
   * @return \App\Models\Product[]
   */
  public function getProduct() {

    return $this->hasMany(\App\Models\Product::class, 'creatorId', 'id');
  }
}
