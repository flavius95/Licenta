
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
      <div class="col-md-12">
        <div class="message loading text-center hidden">Se proceseaza textul</div>
        <div class="accordion hidden" id="accordionExample">
          <div class="card">
            <div class="card-header" id="headingOne">
              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#topicuri" aria-expanded="true" aria-controls="topicuri">
                <h5 class="mb-0">Topicuri</h5>
              </button>
            </div>
            <div id="topicuri" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
              <div class="card-body"></div>
            </div>
          </div>
          <div class="card">
            <div class="card-header" id="headingTwo">
                <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#cuvinteProcesate" aria-expanded="false" aria-controls="cuvinteProcesate">
                  <h5 class="mb-0">Cuvintele procesate din website</h5>
                </button>
            </div>
            <div id="cuvinteProcesate" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
              <div class="card-body"></div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
<script>
    $(document).ready(function(){
      $("#process-form").submit(function(e){
          e.preventDefault();
          if ($('#lgFormGroupInput').val()) {
            var parameters = $(this).serializeArray();
            $(".message").removeClass('hidden');
            $('.accordion').addClass('hidden');
            $.ajax({
                url: $(e.target).attr('action'),
                type: 'post',
                data: parameters,
                success: function( response ){
                    $(".message").addClass('hidden');
                    $('.accordion').removeClass('hidden');
                    $('#topicuri .card-body').text(response.topics);
                    $('#cuvinteProcesate .card-body').html(response.details);
                }
            });
          }
      });
    });
</script>
@endsection
