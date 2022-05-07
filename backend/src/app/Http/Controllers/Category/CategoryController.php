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


  }

  /**
   * Törlés. (Soft delete)
   */
  public function delete($id) {
    $category = ProductCategory::where([
      ['id', '=', $id],
      ['deleted', '=', 0]
    ])->first();

    $category->deleted = 1;

    if ($category->save()) {

    }
  }
}
