{{ Form::model(['action' => 'SaveController@save']) }}
    <div class="form-group">
      {!! Form::label('url', 'Url') !!}
      {!! Form::text('url', '', ['class' => 'form-control']) !!}
    </div>
    <button class="btn btn-success" type="submit">Submit!</button>
{{ Form::close() }}


