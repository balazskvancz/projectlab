      <div class="col-sm-12 col-md-6 col-lg-3 col-lx-2 p-3">
        <form method="GET" action=''>
          <label class="fw-bold">Rendezés</label>
          <select class="form-select shadow-none" name="sort">
            @foreach ($sorting as $key => $value)
              <option value="{{$key}}"
              @if (!is_null($currentSort) && $currentSort == $key) selected @endif
              >{{$value}}</option>
            @endforeach
          </select>

          <button class="btn btn-primary shadow-none mt-4" type="submit">Rendezés</button>
        </form>
      </div>
      <hr class="my-3" />
