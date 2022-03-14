<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Models\ProductCategory;

use \App\Http\Requests\PostCategoryRequest;

class CategoryController extends Controller {

  private $outcome = 'fail';
  private $msg     = 'Sikertelen művelet.';

  /**
   * Felvesz egy új egyedet az adatbázisba.
   */
  public function store(PostCategoryRequest $request) {

    $newCategory = ProductCategory::create([
      'name'    => $request->name,
    ]);

    if ($newCategory) {
      $this->outcome = 'success';
      $this->msg     = 'Sikeres művelet.';
    }

    return redirect()->back()->with($this->outcome, $this->msg);
  }

  /**
   * Törlés. (Soft delete)
   */
  public function delete($id) {

    $category = ProductCategory::where([
      ['id', '=', $id],
      ['deleted', '=', 0]
    ])->first();

    if (is_null($category)) {
      abort(404);
    }

    $category->deleted = 1;

    if ($category->save()) {
      $this->outcome = 'success';
      $this->msg     = 'Sikeres művelet.';
    }

    return redirect()->route('admin_categories')->with($this->outcome, $this->msg);
  }

}
