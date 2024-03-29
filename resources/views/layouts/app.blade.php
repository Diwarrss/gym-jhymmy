<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Argon Dashboard') }}</title>
  <!-- Favicon -->
  <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Extra details for Live View on GitHub Pages -->

  <!-- Icons -->
  <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
  <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
  <!-- Argon CSS -->
  <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
</head>

<body class="{{ $class ?? '' }}">
  <div id="app">
    @auth()
    {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form> --}}
    <side-bar path="{{ asset('argon') }}" user="{{ auth()->user()->role }}" csrf="{{ csrf_token() }}"></side-bar>
    {{-- @include('layouts.navbars.sidebar') --}}
    @endauth

    <div class="main-content">
      @include('layouts.navbars.navbar')
      {{-- Solo se muestra el componente cuando este Auth --}}
      @auth()
      <router-view user="{{ auth()->user()->role }}"></router-view>
      @endauth
      {{-- Se muestra el contenido para el Cliente --}}
      @yield('content')
    </div>

    @guest()
    @include('layouts.footers.guest')
    @endguest
  </div>

  <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
  <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  @stack('js')

  <!-- Argon JS -->
  <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
  <script src="{{ asset('/js/app.js') }}"></script>
</body>

</html>
