
@extends('master')
@section('content')
<div class="container">
  <form method="post" action="{{url('/url/save')}}">
    <div class="form-group row">
      {{csrf_field()}}
      <label for="lgFormGroupInput" class="col-sm-2 col-form-label col-form-label-lg">URL</label>
      <div class="col-sm-10">
        <input type="text" class="form-control form-control-lg" id="lgFormGroupInput" placeholder="url" name="page_url">
      </div>
    </div>
    <div class="form-group row">
      <div class="col-md-12">
          <input type="submit" class="btn btn-primary float-right">
      </div>

    </div>
  </form>
</div>
@endsection
