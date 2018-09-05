<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Licenta</title>

        <!-- Fonts -->
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">
    </head>
    <body id="page-top">
      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <div class="container">
          <a class="navbar-brand" href="javascript:void(0)">Aplicatie pentru extragere si procesare de text</a>
          <a class="navbar-brand" href="javascript:void(0)">Flavius Daniel Ilina</a>
        </div>
      </nav>
      <section>
        @yield('content')
      </section>
    </body>
</html>
