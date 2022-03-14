@extends('layouts.client')


@section('client_content')

  <div class="card">
    <div class="card-header p-2">
      <h2 class="text-center p-2">Áttekintés</h2>
    </div>

    <div class="card-body">
      <div class="row m-2">
        <div class="col-sm-12 col-md-5 p-2 mt-4 mx-auto card bg-danger">
          <div class="card-header">
            <h3 class="text-light text-center p-2">Utolsó bejelentkezés</h3>
          </div>

          <div class="card-body">
            <h2 class="text-light text-center fw-bold">{{$lastLogin}}</h2>
          </div>
        </div>
        <div class="col-sm-12 col-md-5 p-2 mt-4  mx-auto card bg-primary">
          <div class="card-header">
            <h3 class="text-light text-center p-2">Saját termékek száma</h3>
          </div>

          <div class="card-body">
            <h2 class="text-light text-center fw-bold">{{$productsCount}}</h2>
          </div>
        </div>
      </div>

      <hr class="my-3" />

      <div class="row mt-2">
        <form method='GET' action={{route('client_products')}} class="mx-auto text-center">
          <button class="btn btn-lg btn-outline-success shadow-none me-auto">Új termék felvétele <i class="bi bi-plus-circle"></i></button>
        </form>
      </div>
    </div>
  </div>

@endsection
