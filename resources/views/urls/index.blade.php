@extends('master')
@section('content')
  <div class="container">
    <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Url</th>
      </tr>
    </thead>
    <tbody>
      @foreach($urls as $post)
      <tr>
        <td>{{$post['id']}}</td>
        <td>{{$post['url']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
@endsection
