@if (auth()->user()->role == 2)
  @extends('layouts.admin')
@else
  @extends('layouts.client')
@endif



@if (auth()->user()->role == 2)
  @section('admin_content')
@else
  @section('client_content')
@endif


<div class="row p-3 mt-5">
  <div class="col-sm-12 p-3 text-center">
    <h1 class="display-1 text-danger"><i class="bi bi-x-octagon-fill"></i></h1>
  </div>
</div>

@endsection
