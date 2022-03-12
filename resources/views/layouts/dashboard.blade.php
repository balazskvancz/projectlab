@extends('layouts.base')


@section('content')

  <div class="row">
    <nav class="navbar bg-dark p-3">
      <div class="container-fluid">

        <div class="row">
          <a class="navbar-brand text-light">Önlab</a>
        </div>

      </div>
    </nav>
  </div>


  <div class="row">
    <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">

         @yield('navbar_content')

          <hr class="my-3" />
          <li class="nav-item">
            <form method="POST" action="{{route('logout')}}">
              @csrf
              <button class="btn shadow-none" type="submit"><i class="bi bi-box-arrow-right p-1"></i> Kijelentkezés </button>
            </form>
          </li>
        </ul>
      </div>
    </nav>

    <main role="main" class="col-md-10 ms-auto ">

      @if(Session::Get('success') || Session::Get('fail'))
      <div class="container mx-auto" id="customAlert">
        <div class="col-sm-12 col-md-8 mx-auto mt-3">
          <div class="card alert @if (Session::Get('success')) alert-success @else alert-danger @endif">
            <div class="card-body ">
              <h3 class="text-center fw-bold">
                @if (Session::Get('success'))
                  {{Session::Get('success')}}
                @else
                  {{Session::Get('fail')}}
                @endif
              </h3>
            </div>
          </div>

        </div>
      </div>
      @endif


      @yield('main_content')
    </main>
  </div>



@endsection
