@extends('layouts.dashboard')

@section('main_content')

  <div class="card">
    <div class="card-header p-2">
      <h2 class="text-center p-2">Logok</h2>
    </div>

    <div class="card-body">

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th class="text-center">Termék név</th>
              <th class="text-center">Művelet</th>
              <th class="text-center">Dátum</th>
              <th class="text-center">Felhasználó</th>
              <th class="text-center">Változás (ár)</th>
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
                  @if (!is_null($log->oldPrice) && !is_null($log->oldPrice))
                    {{$log->oldPrice}} -> {{$log->newPrice}}
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection