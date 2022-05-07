@extends('layouts.base')


@section('content')
<div class="container-fluid vh-100 d-flex justify-content-center align-items-center">

  <form class="login" method="POST" action="/login">
    @csrf
      <div class="row">
          <div class="col-sm-12  text-center">
              <h2 class="p-2">Bejelentkezés</h2>
              <hr class="my-3" />

              @if (Session::Get('success'))
                <h3 class="p-2 text-success">{{Session::Get('success')}}</h3>
              @endif

              @if (Session::Get('fail'))
                <h3 class="p-2 text-danger">{{Session::Get('fail')}}</h3>
              @endif

          </div>
      </div>

      <div class="row">
          <div class="col-sm-12">
              <div class="form-group p-2">
                  <input type="text" class="form-control shadow-none @if (Session::Get('fail')) border border-danger @endif" placeholder="Felhasználónév" name="username"/>
              </div>
          </div>
      </div>


      <div class="row mb-5">
          <div class="col-sm-12">
              <div class="form-group p-2">
                  <input type="password" class="form-control shadow-none @if (Session::Get('fail')) border border-danger @endif" placeholder="Jelszó" name="password"/>
              </div>
          </div>
      </div>


      <div class="row">
          <div class="col-sm-12">
              <button class="login_button" type="submit"><i class="bi bi-box-arrow-in-right"></i></button>
          </div>
      </div>

    </form>
</div>
@endsection
