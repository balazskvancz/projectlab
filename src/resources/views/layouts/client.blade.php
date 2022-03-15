@extends('layouts.dashboard')

@section('navbar_content')
  <li class="nav-item">
    <a class="nav-link" href="{{route('client_dashboard')}}">
      <i class="bi bi-speedometer p-1"></i>Áttekintés
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{route('client_products')}}">
      <i class="bi bi-box-seam p-1"></i>Termékek
    </a>
  </li>


  <li class="nav-item">
    <a class="nav-link" href="{{route('client_images')}}">
      <i class="bi bi-image p-1"></i>Képek kezelése
    </a>
  </li>

  @endsection

@section('main_content')
  <div class="container-fluid">
    <div class="container mx-auto p-4 m-4">
      @yield('client_content')
    </div>
  </div>

@endsection


