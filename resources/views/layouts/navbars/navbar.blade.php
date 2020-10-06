@auth()
  {{-- @include('layouts.navbars.navs.auth') --}}
  <nav-bar></nav-bar>
@endauth

@guest()
  @include('layouts.navbars.navs.guest')
@endguest
