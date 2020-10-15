<template>
  <div class="p-4">
    <div class="card">
      <div class="card-header">
        <h1>Componente de Perfil</h1>
      </div>
      <div class="card-body">
        <button class="btn btn-primary" @click="count">PERFIL</button>

        <b-alert show>Default Alert</b-alert>

        <b-alert variant="success" show>Success Alert</b-alert>

        <b-alert v-model="showDismissibleAlert" variant="danger" dismissible>
          Dismissible Alert!
        </b-alert>
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
