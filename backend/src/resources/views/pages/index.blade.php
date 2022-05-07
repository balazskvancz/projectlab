@extends('layouts.base')

@section('content')
 <div class="container-fluid d-flex align-items-center justify-content-center">
    <div class="container text-center">
      <div>
        <h1>Helló, </h1>
      </div>

      <div>
        <img class="globe" src="{{asset('images/globe.svg')}}"/>
      </div>
    </div>
 </div>
@endsection
