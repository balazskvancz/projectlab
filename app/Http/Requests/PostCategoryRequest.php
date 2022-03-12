<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostCategoryRequest extends FormRequest
{
    /**
     * Csak az admin hozhat létre új terméket.
     *
     * @return bool
     */
    public function authorize() {
        return auth()->user()->role == 2;
    }

    /**
     * A validációs feltételek, új termék felvétele esetén.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name'=> 'required|unique:product_categories|max: 191'
        ];
    }
}
