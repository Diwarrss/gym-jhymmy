<template>
  <div class="p-4 state_component">
    <div class="card">
      <div class="card-header">
        <h1>Componente de Estados</h1>
      </div>
      <div class="card-body">
        <div>
          <button class="btn btn-primary mb-3" @click="newState()">Nuevo</button>
        </div>
        <div class="body_table pt-3">
          <TableCustom
            :fields="fields"
            :items="allStates"
            :rows="allRow"
            :per-page="10"/>
        </div>
      </div>
    </div>
    <ModalState :viewOnlly="false" :event="true" tittleModal="Nuevo Registro"/>
  </div>
</template>
<script>
import TableCustom from '../components/table/TableCustom'
import ModalState from '../components/modals/ModalState'
import EventBus from '../bus'
export default {
  components: {
    TableCustom,
    ModalState
  },
  data() {
    return {
      show: true,
      allRow: this.row,
      form: {
        id: '',
        name: '',
        state: ''
      },
      states: [
        { "id": 1, "name": "Activo"},
        { "id": 2, "name": "Inactivo"}
      ],
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
      ],
      sending: false,
      updating: false,
      event: '',
      viewOnlly: false,
      tittleModal : ''
    }
  },
  computed: {
    allStates(){
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
    hideModal() {
      this.$refs['modal-states'].hide()
      setTimeout(() => {
        //this.$v.$reset()
        this.viewOnlly = false
        this.updating = false
        this.sending = false
        this.form = {
          id: null,
          name: null,
          state: null
        }
        //this.$store.dispatch('api/clearErrors') //clean errors of back
      }, 500)
    },
    newState(view) {
      EventBus.$emit('show-modal-state')
    },
    modalEdit(item, index, button, view) {
      if (view) {
        this.tittleModal = 'Ver ' + item.names
        this.viewOnlly = true
      } else {
        this.viewOnlly = false
        this.tittleModal = 'Editar ' + item.names
      }
      //this.$store.dispatch('api/clearErrors') //clean errors of back
      //this.$store.dispatch('config/getGender')
      //this.$store.dispatch('config/getTypeIdentification')
      this.form.id = item.id
      this.form.name = item.name
      this.form.state = item.state
      this.event = 0
      this.sending = false
      this.updating = false
      this.$refs['modal-states'].show()
    },
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
  .modal-header {
    border-bottom: 1px solid #cac4c4;
    h5 {
      font-size: 18px;
    }
  }
  .modal-backdrop {
    background-color: #0000001c;
  }
</style>
