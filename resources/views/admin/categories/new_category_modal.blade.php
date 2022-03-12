<div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="newCategoryModal" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Új kategória felvétele</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12 p-2 form-group">
            <label class="fw-bold m-2">Kategória megnevezése</label>
            <input type="text" class="form-control shadow-none" name="name" autocomplete="off" />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Bezárás</button>
        <button type="submit" class="btn btn-success">Mentés</button>
      </div>
    </form>
  </div>
</div>
