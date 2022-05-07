@extends('layouts.dashboard')

@section('main_content')

  <div class="card">
    <div class="card-header p-2">
      <h2 class="text-center p-2">{{$product->name}}</h2>
    </div>

    <div class="card-body">

      <div class="row">
        <div class="col-sm-12 col-md-6 mx-auto d-flex justify-content-around">
          <a href="/client/products/{{$product->id}}/edit"><button type="button" class="btn btn-primary shadow-none">Módosítás <i class="bi bi-pencil-square"></i></button></a>
          <form method="POST" action="/client/products/{{$product->id}}/delete"
            onsubmit="return confirm('Biztosan törölni szeretnéd?');"
            >
            @csrf

            <button type="submit" class="btn btn-danger shadow-none">Törlés <i class="bi bi-trash3-fill"></i></button>
          </form>

        </div>
      </div>

      <hr class="my-3" />

      @include('common.display_prod')

    </div>

  </div>
@endsection
