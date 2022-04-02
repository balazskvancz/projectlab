@extends('layouts.dashboard')

@section('main_content')


<div class="card">
  <div class="card-header p-2">
    <h2 class="text-center p-2">Képek feltöltése</h2>
  </div>

  <form class="card-body" action="" method="POST"
  enctype="multipart/form-data">

    @csrf

    <div class="row">
      <div class="col-sm-12 p-3 text-center">
        <h4 class="text-center">Új kép hozzáadás</h4>
        <hr class="my-3" />
      </div>
    </div>


    <div class="row">
      <div class="col-sm-12 col-md-6 mx-auto mb-3">
        <label class="fw-bold">Termék kiválasztása</label>
        <select class="form-select shadow-none" name="product">
          @foreach ($products as $product)
            <option value="{{$product->id}}">{{$product->name}}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="row">
      <div class="file-upload col-md-6 mx-auto m-3">
        <div class="file-select">
          <div class="file-select-button" id="fileName">Tallózás</div>
          <div class="file-select-name" id="noFile">Nincs fájl kiválasztva...</div>
          <input type="file" name="image" id="image" onchange="inputChanged(1);">
          @error('image')
            <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12 p-2 text-center">
        <button class="btn btn-success shadow-none" type="submit">Feltöltés</button>
      </div>
    </div>

  </form>
</div>

<div class="card mt-4">
  <div class="card-header p-2">
    <h2 class="p-2 text-center">Feltöltött képek kezelése</h2>
  </div>

  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover table-striped">
        <thead>
          <tr>
            <th class="text-center">Dátum</th>
            <th class="text-center">Termék</th>
            <th class="text-center">Megnyitás</th>
            <th class="text-center">Törlés</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($images as $image)
            <tr>
              <td class="text-center align-middle">{{$image->created_at}}</td>
              <td class="text-center align-middle">{{$image->name}}</td>
              <td class="text-center align-middle">
                <button class="btn btn-primary shadow-none" type="button" onclick="onClickOpenModal('{{$image->path}}')"><i class="bi bi-folder2-open"></i></button>

              </td>
              <td class="text-center align-middle">

                <form method="POST" action="/client/images/{{$image->id}}/delete" onsubmit="return confirm('Biztosan törlöd?')">
                  @csrf
                  <input type="hidden" name="userId" value="{{auth()->user()->id}}" />
                  <input type="hidden" name="apikey" value="{{$apikey}}" />
                  <input type="hidden" name="route" value="1" />
                  <button class="btn btn-danger shadow-none" type="submit"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
</div>

@include('client.images.image_modal')

@endsection


@section('scripts')

  <script src="{{asset('js/client/images/main.js')}}"></script>
@endsection


