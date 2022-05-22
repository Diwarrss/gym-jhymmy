<template>
  <div class="p-4 users_component">
    <div class="card">
      <div class="card-header">
        <h2 class="mb-0">Usuarios/Clientes</h2>
      </div>
      <div class="card-body">
        <div>
          <b-button size="sm" variant="primary" class="mb-3" @click="newUser()"><i class="fas fa-plus-circle"></i> Nuevo Usuario</b-button>
        </div>
        <div class="body_table pt-3">
          <TableCustom
            :fields="fields"
            :items="users"
            :rows="allRow"
            :per-page="10"
            type-page="user"/>
        </div>
      </div>
    </div>
    <ModalUser :viewOnlly="false" :event="true" tittleModal="Nuevo Registro" :modal="modal"/>
  </div>
</template>
<script>
import TableCustom from '../components/table/TableCustom'
import ModalUser from '../components/modals/ModalUser'
import EventBus from '../bus'
export default {
  components: {
    TableCustom,
    ModalUser
  },
  data() {
    return {
      // Note `isActive` is left out and will not appear in the rendered table
      allRow: this.row,
      show: true,
      modal: 'modal-users',
      sending: false,
      updating: false,
      event: '',
      viewOnlly: false,
      tittleModal : '',
      form: {
        id: '',
        name: '',
        from_date: '',
        state: ''
      },
      fields: [
        {
          key: 'id',
          label: 'ID'
        },
        {
          key: 'name',
          label: 'Nombre',
          sortable: true
        },
        {
          key: 'state.name',
          label: 'Estado',
          sortable: true
        },
        {
          key: 'acciones',
          label: 'Acciones',
          visible: false,
          sortable: false
        }
      ],
      states: [
        { "id" : "1", "name" : "Activo"},
        { "id" : "2", "name" : "Inactivo"}
      ],
    }
  },
  computed: {
    users(){
      return this.$store.state.user.users
    },
    row() {
      return this.$store.state.user.allRow
    }
  },
  created() {
    this.$store.dispatch('getUsers')
  },
  methods: {
    hideModal() {
      this.$refs['modal-users'].hide()
      setTimeout(() => {
        //this.$v.$reset()
        this.viewOnlly = false
        this.updating = false
        this.sending = false
        this.form = {
          id: null,
          name: null,
          date: null,
          identification: null,
          state: null
        }
        //this.$store.dispatch('api/clearErrors') //clean errors of back
      }, 500)
    },
    newUser(view) {
      EventBus.$emit('show-modal-user')
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
      this.form.from_date = item.from_date
      this.form.state = item.state
      this.event = 0
      this.sending = false
      this.updating = false
      this.$refs['modal-users'].show()
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
  .users_component {
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
