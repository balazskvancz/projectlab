@extends('layouts.dashboard')

@section('main_content')
  <div class="card">
    <div class="card-header p-2">
      <h2 class="text-center p-2">{{$product->name}}</h2>
    </div>

    <div class="card-body">
      @include('common.display_prod')
    </div>
  </div>
@endsection
