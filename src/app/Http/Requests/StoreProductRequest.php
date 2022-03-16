<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \App\Http\Requests\PostProductRequest;

class StoreProductRequest extends PostProductRequest {
    /**
     * Kinek van joga?
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * A hozzáadandó szabályok.
     *
     * @return array
     */
    public function rules() {
      return array_merge(parent::rules(), [
        'name' => 'unique:products',
        'sku'  => 'unique:products'
    ]);

    }
}
