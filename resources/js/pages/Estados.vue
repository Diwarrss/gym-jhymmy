<template>
  <div class="p-4 state_component">
    <div class="card">
      <div class="card-header">
        <h1>Componente de Estados</h1>
      </div>
      <div class="card-body">
        <div>
          <button class="btn btn-primary mb-3" @click="count">Nuevo</button>
        </div>
        <div class="body_table pt-3">
          <TableCustom
            :fields="fields"
            :items="states"
            :rows="allRow"
            :per-page="10"/>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import TableCustom from '../components/table/TableCustom'
export default {
  components: {
    TableCustom
  },
  data() {
    return {
      allRow: this.row,
      fields: [
        {
          key: 'id',
          label: 'ID'
        },
        {
          key: 'name',
          label: 'Nombre'
        },
        {
          key: 'acciones',
          label: 'Acciones'
        }
      ]
    }
  },
  computed: {
    states(){
      return this.$store.state.config.states
    },
    row() {
      return this.$store.state.config.allRow
    }
  },
  created() {
    this.$store.dispatch('getStates')
  },
  methods: {
    count(){
      this.$store.dispatch('count')
    }
  },
  watch: {
    row() {
      this.allRow = this.row
    }
  },
}
</script>
<style lang="scss">
  .state_component {
    .body_table {
      border-top: 1px solid #cec6c6;
    }
  }
</style>
