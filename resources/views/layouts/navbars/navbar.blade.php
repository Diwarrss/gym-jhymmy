@auth()
  {{-- @include('layouts.navbars.navs.auth') --}}
  <nav-bar path="{{ asset('argon') }}" user="{{ auth()->user() }}" ></nav-bar>
@endauth

@guest()
  @include('layouts.navbars.navs.guest')
@endguest
