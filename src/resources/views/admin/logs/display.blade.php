@extends('layouts.dashboard')

@section('main_content')

 <div class="row">
    <div class="col-sm-12 col-md-8 mx-auto">
      <form class="card" method="GET" action="">
        <div class="card-header p-2">
          <h2 class="p-2 text-center">Szűrés</h2>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-sm-12 col-md-4 p-3">
              <select name="userid" class="form-select">
                <option value="">Válassz egy felhsználót!</option>

                @foreach ($users as $user)
                  <option value="{{$user->id}}"
                    @if(!is_null($lastUser) && $lastUser == $user->id) selected @endif
                    >{{$user->username}}</option>
                @endforeach
              </select>
              <hr class="my-3">
            </div>

            <div class="col-sm-12 col-md-4 p-3">
              <input type="date" name="startdate" class="form-control"
              @if(!is_null($lastStart)) value="{{$lastStart}}"  @endif >

              <hr class="my-3">
            </div>

            <div class="col-sm-12 col-md-4 p-3">
              <input type="date" name="enddate" class="form-control"
              @if(!is_null($lastEnd)) value="{{$lastEnd}}" @endif >

              <hr class="my-3">
            </div>
          </div>
        </div>

        <div class="card-footer">
          <div class="col-sm-12 p-3 text-center">
            <button class="btn btn-primary shadow-none">Lekérés</button>
          </div>
        </div>
      </form>
    </div>
  </div>



   <div class="card mt-4">
    <div class="card-header p-2">
      <h2 class="text-center p-2">Logok</h2>
    </div>

    <div class="card-body">
      <div class="d-flex justify-content-center">
        {!! $logs->links() !!}
      </div>
      <div class="table-responsive">
        <table class="table table-hover table-striped">
          <thead>
            <tr>
              <th class="text-center">Termék név</th>
              <th class="text-center">Művelet</th>
              <th class="text-center">Dátum</th>
              <th class="text-center">Felhasználó</th>
              <th class="text-center">Változás</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($logs as $log)
              <tr>
                <td class="text-center">{{$log->productName}}</td>
                <td class="text-center">{{$log->logName}}</td>
                <td class="text-center">{{$log->created_at}}</td>
                <td class="text-center">{{$log->username}}</td>
                <td class="text-center">
                  {{
                    $log->diff
                  }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>



@endsection
