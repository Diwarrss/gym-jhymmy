<template>
  <div class="p-4 genders_component">
    <div class="card">
      <div class="card-header">
        <h1>Generos</h1>
      </div>
      <div class="card-body">
        <div>
          <button class="btn btn-primary mb-3" @click="newGender()" ><i class="fas fa-plus-circle"></i> Nuevo</button>
        </div>
        <div class="body_table pt-3">
          <TableCustom
            type-page="gender"
            :fields="fields"
            :items="allGenders"
            :rows="allRow"
            :per-page="10"/>
        </div>
      </div>
    </div>
    <ModalGender :viewOnlly="false" :event="true" tittleModal="Nuevo Registro" :modal="modal"/>
  </div>
</template>
<script>
import TableCustom from '../components/table/TableCustom'
import ModalGender from '../components/modals/ModalGender'
import EventBus from '../bus'
export default {
  components: {
    TableCustom,
    ModalGender
  },
  data() {
    return {
      show: true,
      allRow: this.row,
      modal: 'modal-gender',
      sending: false,
      updating: false,
      event: '',
      viewOnlly: false,
      tittleModal : '',
      form: {
        id: '',
        name: '',
        initial: '',
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
          key: 'initials',
          label: 'Iniciales'
        },
        {
          key: 'state',
          label: 'Estado'
        },
        {
          key: 'acciones',
          label: 'Acciones'
        }
      ]
    }
  },
  computed: {
    allGenders(){
      return this.$store.state.config.genders
    },
    row() {
      return this.$store.state.config.allRow
    }
  },
  created() {
    this.$store.dispatch('getGenders')
  },
  methods: {
    /* hideModal() {
      this.$refs['modal-genders'].hide()
      setTimeout(() => {
        //this.$v.$reset()
        this.viewOnlly = false
        this.updating = false
        this.sending = false
        this.form = {
          id: null,
          name: null,
          initial: null,
          state: null
        }
        //this.$store.dispatch('api/clearErrors') //clean errors of back
      }, 500)
    }, */
    newGender(view) {
      EventBus.$emit('show-modal-gender')
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
      this.form.initials = item.initials
      this.form.state = item.state
      this.event = 0
      this.sending = false
      this.updating = false
      this.$refs['modal-genders'].show()
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
  .genders_component {
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
