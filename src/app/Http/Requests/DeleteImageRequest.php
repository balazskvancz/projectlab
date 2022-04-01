<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use \App\Models\ProductImage;
use \App\Models\User;

use \App\Http\Requests\BaseApiRequest;

class DeleteImageRequest extends FormRequest
{
  /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
  public function authorize(BaseApiRequest $request) {
    $user = User::find($request->userId);
    $image = ProductImage::find($request->imageId);

    if (is_null($image)) {
      return false;
    }

    // Az adott user-hez tartozik a kép?
    return $image->getProduct->creatorId == $user->id;
  }

  /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
