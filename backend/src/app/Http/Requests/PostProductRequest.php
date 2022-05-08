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
    public function rules () {
      return [
        'name'          => 'required|max:191',
        'categoryId'    => 'required|numeric',
        'description'   => 'max:500',
      ];
    }

    /**
     * Visszaadja a validációs szabályokhoz tartozó hivaüzeneteket.
     *
     * @return array
     */
    public function messages () {
      return [
        'required'      => 'A mező kitöltése kötelező.',
        'max'           => 'A mező hossza túl hosszú.',
        'name.unique'   => 'Ilyen névvel már létezik termék.',
      ];
    }
}
