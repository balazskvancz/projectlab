<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostProductRequest extends FormRequest
{
    /**
     * Mindenki vehet fel terméket. [Vagy Csak az, aki nem admin?]
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Validálja a beérkező requestet.
     *
     * @return array
     */
    public function rules() {
      return [
        'name'          => 'required|max:191',
        'sku'           => 'required|max:191',
        'categoryId'    => 'required|numeric',
        'description'   => 'max:500',
      ];
    }
}
