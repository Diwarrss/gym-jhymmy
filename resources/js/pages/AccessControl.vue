<template>
  <div class="p-4 access_component">
    <div class="card">
      <div class="card-header">
        <h2 class="mb-0">Control de Acceso</h2>
      </div>
      <div class="card-body">
        <div>
          <b-button variant="primary" size="sm" class="mb-3" @click="newAccess()"><i class="fas fa-plus-circle"></i> Nuevo Ingreso</b-button>
        </div>

        <div class="body_table pt-3">
          <TableCustom
            type-page="access"
            :fields="fields"
            :items="AccessCotrol"
            :rows="allRow"
            :per-page="10"
          />
        </div>
      </div>
    </div>
    <ModalAccessControl :viewOnlly="false" :event="true" tittleModal="Nuevo Registro" :modal="modal"/>
  </div>
</template>
<script>
import TableCustom from '../components/table/TableCustom'
import ModalAccessControl from '../components/modals/ModalAccessControl'
import EventBus from '../bus'
import moment from "moment";
moment.locale("es");
export default {
  components: {
    TableCustom,
    ModalAccessControl
  },
  data() {
    return {
      // Note `isActive` is left out and will not appear in the rendered table
      allRow: this.row,
      show: true,
      modal: 'modal-access',
      form: {
        id: '',
        name: '',
        user: '',
        date: '',
        temperature:'',
        state: ''
      },
      fields: [
        {
          key: 'id',
          label: 'ID'
        },
        {
          key: 'user.name',
          label: 'Cliente',
          sortable: true
        },
        {
          key: 'temperature',
          label: 'Temperatura °C',
          sortable: true
        },
        {
          key: 'created_at',
          label: 'Fecha y Hora',
          sortable: true,
          formatter: value => {
            return moment(value).format("YYYY-MM-DD hh:mm a")
          }
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
    AccessCotrol(){
      return this.$store.state.administration.access_control
    },
    users(){
      const users = this.$store.state.user.users.filter(user => {
        return user.roles.find(role => role.name !== 'super_admin')
      })
      return users
    },
  },
  created() {
    this.$store.dispatch('getAccessControl')
  },
  methods: {
    hideModal() {
      this.$refs['modal-access'].hide()
      setTimeout(() => {
        //this.$v.$reset()
        this.viewOnlly = false
        this.updating = false
        this.sending = false
        this.form = {
          id: null,
          name: null,
          date: null,
          temperature: null,
          state: null
        }
        //this.$store.dispatch('api/clearErrors') //clean errors of back
      }, 500)
    },
    newAccess(view) {
      EventBus.$emit('show-modal-access')
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
      this.form.user = item.user
      this.form.user = item.date
      this.form.user = item.temperature
      this.form.state = item.state
      this.event = 0
      this.sending = false
      this.updating = false
      this.$refs['modal-access'].show()
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
  .access_component {
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
