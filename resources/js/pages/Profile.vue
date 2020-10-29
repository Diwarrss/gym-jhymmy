<template>
  <div class="p-4">
    <div class="card">
      <div class="card-header">
        <h1>Componente de Perfil</h1>
      </div>
      <div class="card-body">
        <b-row>
          <b-col cols="md-4">
            <div class="card">
              <div class="card-header">
                <h1>Mi perfil</h1>
              </div>
              <div class="card-body">
                <form action="">
                  <b-form-group></b-form-group>
                </form>
              </div>
            </div>
          </b-col>
          <b-col cols="md-4"></b-col>
          <b-col cols="md-4"></b-col>
        </b-row>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  methods: {
    count(){
      this.$store.dispatch('count')
    }
  }
}
</script>
