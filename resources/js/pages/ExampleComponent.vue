<template>
  <div>
    <h1>Componente de prueba</h1>
    <button class="btn btn-primary" @click="count">SUMAR</button>
  </div>
</template>
<script>
export default {
  methods: {
    count(){
      this.$store.dispatch('moduleA/count')
    }
  }
}
</script>
