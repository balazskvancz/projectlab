      <div class="row">
        <div class="col-sm-12 col-md-6 mx-auto mt-2">
          <div class="table-responive mt-3">
            <table class="table table-striped table-bordered table-hover">
              <tbody>
                @foreach ($keys as $key => $value)
                  <tr>
                    <td class="text-center align-middle w-25">{{$value}}</td>
                    <td class="text-center align-middle w-75">{{$product->$key}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <hr class="my-3" />

      <div class="row">
        <div class="col-sm-12 p-3">
          <h3 class="p-3">Feltöltött képek </h3>
        </div>

        @foreach ($product->getImages as $image)
          <div class="col-sm-12 col-md-6 mx-auto mt-4">
            <img src="{{asset('images/uploads/'.$image->path)}}" class="img-fluid border border-primary"  alt="Kép"/>

          </div>
        @endforeach
      </div>
