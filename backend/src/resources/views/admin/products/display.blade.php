@extends('layouts.dashboard')

@section('main_content')

  <div class="card">
    <div class="card-header p-2">
      <h2 class="text-center p-2">Termékek áttekintése</h2>
    </div>

    <div class="card-body">

      <div class="col-sm-12 d-flex">

        <div class="col-sm-6">
          <h5 class="p-2">Termékek száma: <b>{{count($products)}}</b> db </h5>
        </div>


      </div>

      <hr class="my-3" />

      @include('common.sort')

      <div class="table-responsive mt-2">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center">Felvivő</th>
              <th class="text-center">Cikkszám</th>
              <th class="text-center">Kategória</th>
              <th class="text-center">Megnevezés</th>
              <th class="text-center">Ár</th>
              <th class="text-center">Műveletek</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($products as $product)
              <tr>
                <td class="text-center align-middle">{{$product->getUser->username}}</td>
                <td class="text-center align-middle">{{$product->sku}}</td>
                <td class="text-center align-middle">{{$product->getCategory->name}}</td>
                <td class="text-center align-middle">{{$product->name}}</td>
                <td class="text-center align-middle">{{$product->price}}</td>
                <td class="text-center">
                  <a href="/admin/products/{{$product->id}}/show">
                      <button class="btn btn-primary shadow-none pe-4 ps-4"><i class="bi bi-arrow-bar-right font-light"></i></button>
                    </a>
                </td>
              </tr>

            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
@endsection

