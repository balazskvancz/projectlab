@extends('layouts.client')

@section('client_content')

  <form class="card" action="" method="POST">
    @csrf
    <div class="card-header p-2">
      <h2 class="text-center p-2">Termék módosítása</h2>
    </div>

    <div class="card-body">
      @foreach ($keys as $key => $value)

          <div class="row p-2 mt-2">
            <div class="col-sm-12 col-md-6 mx-auto form-group">
              <label class="fw-bold">{{$value}}</label>

              @if ($key == 'categoryId')
                <select class="form-select shadow-none" name="{{$key}}">
                  @foreach ($categories as $category)
                    <option value="{{$category->id}}" @if ($product->$key == $category->id) selected @endif>{{$category->name}}</option>
                  @endforeach
                </select>
              @elseif ($key == 'description')
                <textarea class="form-control shadow-none" name="{{$key}}" rows=6 spellcheck="off" autocomplete="false">{{$product->$key}}</textarea>
              @else
                <input type="text" class="form-control shadow-none"
                  value="{{$product->$key}}" name="{{$key}}" />
              @endif
            </div>
          </div>

      @endforeach

      <hr class="my-3" />

      <div class="row mt-4">
        <div class="col-sm-12 p-4">
          <h3 class="p-3">Feltöltött képek </h3>
        </div>

        <div class="col-sm-12 col-md-6 mx-auto">
          <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered">
              <thead>
                <tr>
                  <th class="text-center">Kép</th>
                  <th class="text-center">Törlés</th>
                </tr>
              </thead>

              <tbody>
                @foreach ($product->getImages as $image)
                  <tr>
                    <td class="text-center">
                      <button class="btn btn-primary shadow-none"
                      type="button"
                      onclick="onClickOpenImageModal('{{$image->path}}')"
                      >Megtekintés</button>
                    </td>

                    <td class="text-center">
                      <button class="btn btn-danger shadow-none">Törlés</button>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="card-footer">
      <div class="col-sm-12 p-2 text-center">
        <button class="btn btn-lg btn-success shadow-none" type="submit">Mentés</button>
      </div>
    </div>
  </form>


  @include('client.products.image_modal')

@endsection


@section('scripts')

  <script src="{{asset('js/client/edit/main.js')}}"></script>

@endsection
