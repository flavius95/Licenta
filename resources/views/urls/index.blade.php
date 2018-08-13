@extends('master')
@section('content')
  <div class="container">
    <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Url</th>
        <th>SubUrls</th>
        <th>Data</th>
      </tr>
    </thead>
    <tbody>
      @foreach($urls as $post)
      <tr>
        <td>{{$post['id']}}</td>
        <td>{{$post['url']}}</td>
        <td>{{$post['sub_urls']}}</td>
        <td>{{$post['data']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  </div>
@endsection
