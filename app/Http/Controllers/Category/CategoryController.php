<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use \App\Models\ProductCategory;

use \App\Http\Requests\PostCategoryRequest;

class CategoryController extends Controller {


  /**
   * Felvesz egy új egyedet az adatbázisba.
   */
  public function store(PostCategoryRequest $request) {

    $newCategory = ProductCategory::create([
      'name'    => $request->name,
    ]);

    // Ha sikerült, létrehozni.
    if ($newCategory) {
      return redirect()->back()->with('success', 'Sikeres kategóriafelvétel.');
    }

    return redirect()->back()->with('fail', 'Nem sikerült beszúrni a kategóriát.');
  }
}
