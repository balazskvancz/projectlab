@extends('layouts.dashboard')


@section('main_content')
  <div class="card">
    <div class="card-header p-2">
      <h2 class="text-center">Áttekintés</h2>
    </div>

    <div class="card-body">
      <div class="row m-2">
        <div class="col-sm-12 col-md-5 p-2 mt-4 mx-auto card bg-danger">
          <div class="card-header">
            <h3 class="text-light text-center p-2">Felhasználók száma</h3>
          </div>

          <div class="card-body">
            <h2 class="text-light text-center fw-bold">{{$usersCount}}</h2>
          </div>
        </div>
        <div class="col-sm-12 col-md-5 p-2 mt-4  mx-auto card bg-primary">
          <div class="card-header">
            <h3 class="text-light text-center p-2">Termékek száma</h3>
          </div>

          <div class="card-body">
            <h2 class="text-light text-center fw-bold">{{$productsCount}}</h2>
          </div>
        </div>
      </div>

      <hr class="my-3" />

      <h4 class="p-2">
        Utolsó 10 bejelentkezés
      </h4>

      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center">Felhasználó </th>
              <th class="text-center">Dátum</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($logins as $login)
              <tr>
                <td class="text-center">{{$login->getUser->username}}</td>
                <td class="text-center">{{$login->created_at}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>
@endsection
