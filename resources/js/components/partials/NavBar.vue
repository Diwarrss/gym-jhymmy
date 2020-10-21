<template>
  <!-- Top navbar -->
  <b-navbar class="navbar bg-gradient-primary navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <b-navbar-brand class="pl-4 pr-4" href="#">NavBar</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <!-- <b-navbar-nav>
        <b-nav-item href="#">Link</b-nav-item>
        <b-nav-item href="#" disabled>Disabled</b-nav-item>
      </b-navbar-nav> -->

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <!-- <b-nav-form>
          <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
          <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
        </b-nav-form> -->

        <!-- <b-nav-item-dropdown text="Lang" right>
          <b-dropdown-item href="#">EN</b-dropdown-item>
          <b-dropdown-item href="#">ES</b-dropdown-item>
          <b-dropdown-item href="#">RU</b-dropdown-item>
          <b-dropdown-item href="#">FA</b-dropdown-item>
        </b-nav-item-dropdown> -->

        <b-nav-item-dropdown right class="pr-md-4">
          <!-- Using 'button-content' slot -->
          <template #button-content>
            <em><i class="fas fa-user-friends"></i> {{ userAuth.name }} </em>
          </template>
          <b-dropdown-item :to="{ name: 'perfil' }" class=""><i class="fas fa-user-circle"></i> Perfil</b-dropdown-item>
          <b-dropdown-item href="#" variant="danger"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</b-dropdown-item>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>
<script>
export default {
  props: {
    path: String,
    user: String
  },
  computed: {
    userAuth() {
      return JSON.parse(this.user)
    }
  },
}
</script>
<style lang="scss">
  .dropdown-menu {
    top: 40px !important;
    left: -80px !important;
  }
</style>
