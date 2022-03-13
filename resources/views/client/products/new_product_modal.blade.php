
<div class="modal fade" id="newProductModal" tabindex="-1" aria-labelledby="newProductModal" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Új termék felvétele</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @foreach ($keys as $key => $value)
          <div class="row p-2 mt-2">
            <div class="col-sm-12 mx-auto form-group">
              <label class="fw-bold">{{$value}}</label>

              @if ($key == 'categoryId')
                <select class="form-select shadow-none" name="{{$key}}">
                  @foreach ($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
                </select>
              @elseif ($key == 'description')
                <textarea class="form-control shadow-none" name="{{$key}}" rows=6 spellcheck="off" autocomplete="false"></textarea>
              @else
                <input type="text" class="form-control shadow-none" name="{{$key}}" />
              @endif
            </div>
          </div>
        @endforeach

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Bezárás</button>
        <button type="submit" class="btn btn-success">Mentés</button>
      </div>
    </form>
  </div>
</div>
