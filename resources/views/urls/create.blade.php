
@extends('master')
@section('content')
<div class="container">
  <form method="post" action="{{url('/url/save')}}" id="process-form">
    <div class="form-group row">
      {{csrf_field()}}
      <label for="lgFormGroupInput" class="col-sm-3 col-form-label col-form-label-lg text-right">URL</label>
      <div class="col-sm-7">
        <input type="text" class="form-control form-control-lg" id="lgFormGroupInput" placeholder="url" name="page_url">
      </div>
      <div class="col-md-2">
        <input type="submit" class="btn btn-primary" value="Submit">
      </div>
    </div>
  </form>
  <div class="row">
      <div class="col-md-10 text-center" id="response"></div>
  </div>
</div>


<script>
    $(document).ready(function(){
      $("#process-form").submit(function(e){
          e.preventDefault();

          var parameters = $(this).serializeArray();
          $("#response").html("Processing text from website ...");
          $.ajax({
              url: $(e.target).attr('action'),
              type: 'post',
              data: parameters,
              success: function( response ){
                  $('#response').html(response.details);
              }
          });
      });
    });
</script>
@endsection
