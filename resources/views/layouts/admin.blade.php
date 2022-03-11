@extends('layouts.dashboard')

@section('navbar_content')
  <li class="nav-item">
    <a class="nav-link" href="{{route('admin_dashboard')}}">
      <i class="bi bi-speedometer p-1"></i>Áttekintés
    </a>


  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{route('admin_users')}}">
      <i class="bi bi-people-fill p-1"></i>Felhasználók
    </a>

  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{route('admin_products')}}">
      <i class="bi bi-box-seam p-1"></i>Termékek
    </a>
  </li>




  @endsection

@section('main_content')
  <div class="container-fluid">
    <div class="container mx-auto p-4 m-4">
      @yield('admin_content')
    </div>
  </div>

@endsection
