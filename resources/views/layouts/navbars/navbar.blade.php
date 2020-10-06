@auth()
  {{-- @include('layouts.navbars.navs.auth') --}}
  <nav-bar path="{{ asset('argon') }}"></nav-bar>
@endauth

@guest()
  @include('layouts.navbars.navs.guest')
@endguest
