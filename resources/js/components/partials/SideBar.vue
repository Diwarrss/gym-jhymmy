<template>
  <nav class="sidebar_custom navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <div class="text-center">
        <img :src="path + '/img/brand/blue.png'" class="navbar-brand-img" alt="...">
      </div>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                    <span class="avatar avatar-sm rounded-circle">
                    <img alt="Image placeholder" :src="path + '/img/theme/team-1-800x800.jpg'">
                    </span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome!</h6>
                </div>
                <!-- <a href="{{ route('profile.edit') }}" class="dropdown-item">
                    <i class="ni ni-single-02"></i>
                    <span>{{ __('My profile') }}</span>
                </a> -->
                <!-- <a href="#" class="dropdown-item">
                    <i class="ni ni-settings-gear-65"></i>
                    <span>{{ __('Settings') }}</span>
                </a>
                <a href="#" class="dropdown-item">
                    <i class="ni ni-calendar-grid-58"></i>
                    <span>{{ __('Activity') }}</span>
                </a>
                <a href="#" class="dropdown-item">
                    <i class="ni ni-support-16"></i>
                    <span>{{ __('Support') }}</span>
                </a> -->
                <div class="dropdown-divider"></div>
                <!-- <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                    <i class="ni ni-user-run"></i>
                    <span>{{ __('Logout') }}</span>
                </a> -->
            </div>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <div>
                <img :src="path + '/img/brand/blue.png'">
              </div>
            </div>
              <div class="col-6 collapse-close">
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                  <span></span>
                  <span></span>
                </button>
              </div>
          </div>
        </div>
        <!-- Form -->
        <form class="mt-4 mb-3 d-md-none">
            <div class="input-group input-group-rounded input-group-merge">
                <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Buscar" aria-label="Search">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <span class="fa fa-search"></span>
                    </div>
                </div>
            </div>
        </form>
        <!-- Navigation -->
        <ul class="navbar-nav">
            <li class="nav-item">
              <router-link class="nav-link" to="/">
                  <i class="fas fa-window-maximize"></i> Dashboard
              </router-link>
            </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading text-muted">ADMINISTRACIÓN</h6>
        <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'usuarios' }">
                  <i class="fas fa-users"></i> Usuarios
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'medidas' }">
                  <i class="fas fa-chart-line"></i> Seguimiento
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'pagos' }">
                  <i class="fas fa-dollar-sign"></i> Pagos
              </router-link>
            </li>
            <li class="nav-item">
                <!-- <a class="nav-link active" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-examples">
                    <i class="fab fa-laravel" style="color: #f4645f;"></i>
                    <span class="nav-link-text" style="color: #f4645f;">Laravel Examples</span>
                </a>

                <div class="collapse show" id="navbar-examples">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.edit') }}">
                                {{ __('User profile') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.index') }}">
                                {{ __('User Management') }}
                            </a>
                        </li>
                    </ul>
                </div> -->
            </li>

            <li class="nav-item">
                <!-- <a class="nav-link" href="{{ route('icons') }}">
                    <i class="ni ni-planet text-blue"></i> {{ __('Icons') }}
                </a> -->
            </li>
            <li class="nav-item ">
                <!-- <a class="nav-link" href="{{ route('map') }}">
                    <i class="ni ni-pin-3 text-orange"></i> {{ __('Maps') }}
                </a> -->
            </li>
            <li class="nav-item">
                <!-- <a class="nav-link" href="{{ route('table') }}">
                  <i class="ni ni-bullet-list-67 text-default"></i>
                  <span class="nav-link-text">Tables</span>
                </a> -->
            </li>
            <li class="nav-item">
                <!-- <a class="nav-link" href="#">
                    <i class="ni ni-circle-08 text-pink"></i> {{ __('Register') }}
                </a> -->
            </li>
            <li class="nav-item mb-5 mr-4 ml-4 pl-1 bg-danger" style="position: absolute; bottom: 0;">
                <!-- <a class="nav-link text-white" href="https://www.creative-tim.com/product/argon-dashboard-pro-laravel" target="_blank">
                    <i class="ni ni-cloud-download-95"></i> Upgrade to PRO
                </a> -->
            </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading text-muted">CONFIGURACIÓN</h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'generos' }">
                  <i class="fas fa-venus-mars"></i> Generos
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'estados' }">
                  <i class="fas fa-atom"></i> Estados
              </router-link>
            </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading text-muted">CUENTA</h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'perfil' }">
                  <i class="fas fa-user-circle"></i> Perfil
              </router-link>
            </li>
            <li class="nav-item">
                <!-- <a class="nav-link" href="https://argon-dashboard-laravel.creative-tim.com/docs/getting-started/overview.html">
                    <i class="ni ni-spaceship"></i> Getting started
                </a> -->
            </li>
            <li class="nav-item">
                <!-- <a class="nav-link" href="https://argon-dashboard-laravel.creative-tim.com/docs/foundation/colors.html">
                    <i class="ni ni-palette"></i> Foundation
                </a> -->
            </li>
            <li class="nav-item">
                <!-- <a class="nav-link" href="https://argon-dashboard-laravel.creative-tim.com/docs/components/alerts.html">
                    <i class="ni ni-ui-04"></i> Components
                </a> -->
            </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script>
export default {
  props: {
    path: String
  }
}
</script>
<style lang="scss">
  .sidebar_custom {
    .fas {
      color: #5e72e4;
    }
    .router-link-exact-active {
      background: #825ee4 !important;
      color: white !important;
      .fas {
        color: white !important;
      }
    }
    .nav-item:hover {
      background: #d9cbff !important;
    }
  }
</style>
