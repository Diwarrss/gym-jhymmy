<template>
  <nav class="sidebar_custom navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button @click="touchCollapse" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <div class="text-center">
        <img :src="path + '/img/brand/blue.png'" class="navbar-brand-img" alt="...">
      </div>
      <!-- User -->
      <b-nav-item-dropdown class="pr-md-4 dropdown-custom d-md-none">
          <!-- Using 'button-content' slot -->
          <template #button-content>
            <em><i class="fas fa-user-friends"></i></em>
          </template>
          <b-dropdown-item :to="{ name: 'profile' }" class=""><i class="fas fa-user-circle"></i> Perfil</b-dropdown-item>
          <b-dropdown-item @click.prevent="logout" variant="danger"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</b-dropdown-item>
          <form id="logout-form" action="/logout" method="POST" style="display: none;">
            <input type="hidden" name="_token" v-bind:value="csrf" />
          </form>
        </b-nav-item-dropdown>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main" :class="!showCollapse ? 'collapse-oculto' : '' ">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <div>
                <img :src="path + '/img/brand/blue.png'">
              </div>
            </div>
              <div class="col-6 collapse-close">
                <button @click="touchClose" type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
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
        <!-- <ul class="navbar-nav">
            <li class="nav-item">
              <router-link class="nav-link" to="/">
                  <i class="fas fa-window-maximize"></i> Dashboard
              </router-link>
            </li>
        </ul> -->
        <!-- Divider -->
        <!-- <hr class="my-3"> -->
        <!-- Heading -->
        <div v-if="rol_id == 1">
          <h6 class="navbar-heading text-muted">ACCESO</h6>
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'access_control' }">
                <i class="fas fa-calendar-check"></i> Control de Ingreso
              </router-link>
            </li>
          </ul>
          <!-- Divider -->
          <hr class="my-3">
        </div>
        <!-- Heading -->
        <h6 class="navbar-heading text-muted">ADMINISTRACIÓN</h6>
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item" v-if="rol_id == 1">
            <router-link class="nav-link" :to="{ name: 'user' }">
              <i class="fas fa-users"></i> Usuarios
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" :to="{ name: 'tracing' }">
                <i class="fas fa-chart-line"></i> Seguimiento
            </router-link>
          </li>
          <li class="nav-item" v-if="rol_id == 1">
            <router-link class="nav-link" :to="{ name: 'payment' }">
                <i class="fas fa-dollar-sign"></i> Pagos
            </router-link>
          </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <div v-if="rol_id == 1">
          <h6 class="navbar-heading text-muted">CONFIGURACIÓN</h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'gender' }">
                  <i class="fas fa-venus-mars"></i> Generos
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'state' }">
                  <i class="fas fa-atom"></i> Estados
              </router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'cancellation_reason' }">
                  <i class="fas fa-ban"></i> Motivo de Cancelación
              </router-link>
            </li>
          </ul>
          <!-- Divider -->
          <hr class="my-3">
        </div>
        <!-- Heading -->
        <h6 class="navbar-heading text-muted">CUENTA</h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <router-link class="nav-link" :to="{ name: 'profile' }">
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
    path: String,
    user: String,
    csrf: String
  },
  data() {
    return {
      rol_id: '',
      showCollapse: false
    }
  },
  methods: {
    touchCollapse() {
      this.showCollapse = true
    },
    touchClose() {
      this.showCollapse = false
    },
    logout() {
      event.preventDefault();
      document.getElementById("logout-form").submit();
    }
  },
  mounted() {
    this.rol_id = this.userAuth.roles[0]['id']
  },
  computed: {
    userAuth() {
      return JSON.parse(this.user)
    }
  },
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
    .nav-item{
      ul {
        top: 18px !important;
        left: -60px !important;
      }
      &:hover {
        background: transparent !important;
      }
    }
    .collapse-oculto {
      left: -800px !important;
    }
  }
</style>
