@extends('layouts.admin')

@section('admin_content')

<div class="card">

  <div class="card-header p-2">
    <h2 class="text-center p-2">Kategóriák kezelése</h2>
  </div>

  <div class="card-body">
    <div class="col-sm-12 d-flex">

      <div class="col-sm-6">
        <h5 class="p-2">Kategóriák száma: <b>{{count($categories)}}</b>  db</h5>
      </div>

      <div class="col-sm-6 text-end">
        <button class="btn btn-success shadow-none"
          data-bs-toggle="modal" data-bs-target="#newCategoryModal"
          >Új kategória felvétele <i class="bi bi-plus-circle"></i></button>

      </div>

    </div>
    <hr class="my-3" />

    <div class="table-responsive mt-4">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th class="text-center">Azonosító</th>
            <th class="text-center">Megnevezés</th>
            <th class="text-center">Műveletek</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($categories as $category)
              <tr>
                <td class="text-center align-middle">{{$category->id}}</td>
                <td class="text-center align-middle">{{$category->name}}</td>
                <td class="text-center">
                  <form action="/admin/categories/{{$category->id}}/delete" method="POST"
                    onsubmit="return confirm('Biztosan törlöd?');"
                    >
                    @csrf
                    <button class="btn btn-lg shadow-none" type="submit"><i class="bi bi-trash-fill"></i></button>
                  </form>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>


</div>

@include('admin.categories.new_category_modal')
@endsection

