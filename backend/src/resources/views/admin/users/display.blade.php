@extends('layouts.dashboard')

@section('main_content')

  <div class="card">
    <div class="card-header p-2">
      <h2 class="text-center p-2">Felhasználók áttekintése</h2>
    </div>

    <div class="card-body">
      <div class="table-responsive">

        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th class="text-center">Felhasználónév</th>
              <th class="text-center">Jogosultság</th>
              <th class="text-center">Művelet</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($users as $user)
              <tr>
                <td class="text-center">
                  {{$user->username}}
                </td>

                <td class="text-center">
                  @if ($user->role == 1)
                    Felhasználó
                  @elseif ($user->role == 2)
                    Admin
                  @endif
                </td>

                <td class="text-center">
                  <button class="btn btn-primary shadow-none">Módosítás</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection


