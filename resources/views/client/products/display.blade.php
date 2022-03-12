@extends('layouts.client')


@section('client_content')

  <div class="card">
    <div class="card-header p-2">
      <h2 class="text-center p-2">Termékek áttekintése</h2>
    </div>

    <div class="card-body">

      <div class="col-sm-12 d-flex">

        <div class="col-sm-6">
          <h5 class="p-2">Termékek száma: <b>{{count($products)}}</b> db </h5>
        </div>

        <div class="col-sm-6 text-end">
          <button class="btn btn-success shadow-none"
          data-bs-toggle="modal" data-bs-target="#newProductModal"
          >Új termék felvétele <i class="bi bi-plus-circle"></i></button>
        </div>
      </div>

      <hr class="my-3" />

      <div class="table-responsive mt-2">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center">Cikkszám</th>
              <th class="text-center">Kategória</th>
              <th class="text-center">Megnevezés</th>
              <th class="text-center">Leírás</th>
              <th class="text-center">Ár</th>
              <th class="text-center">Műveletek</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($products as $product)
              <tr>
                <td class="text-center align-middle">{{$product->sku}}</td>
                <td class="text-center align-middle">{{$product->getCategory->name}}</td>
                <td class="text-center align-middle">{{$product->name}}</td>
                <td class="text-center align-middle">{{$product->description}}</td>
                <td class="text-center align-middle">{{$product->price}}</td>
                <td class="text-center">
                  <a href="/client/products/{{$product->id}}/edit">
                    <button class="btn btn-lg shadow-none"><i class="bi bi-pencil-square"></i></button>
                  </a>

                  <form action="/client/products/{{$product->id}}/delete" method="POST"
                    onsubmit="confirm('Biztosan törölni szeretnéd?')">
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

  @include('client.products.new_product_modal')
@endsection
