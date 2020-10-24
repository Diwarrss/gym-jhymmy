<template>
  <div class="p-4 access_component">
    <div class="card">
      <div class="card-header">
        <h1>Componente de Acceso</h1>
      </div>
      <div class="card-body">
        <div>
          <button class="btn btn-primary mb-3" @click="newAccess()">Nuevo Ingreso</button>
        </div>
        <div class="body_table pt-3">
          <TableCustom
            :fields="fields"
            :items="accesses"
            :rows="allRow"
            :per-page="10"/>
        </div>
      </div>
    </div>
    <!-- Info modal -->
    <b-modal
      ref="modal-access"
      id="modal-access"
      no-close-on-esc
      no-close-on-backdrop
      hide-footer>
      <template v-slot:modal-title>
        <i
          v-if="!viewOnlly && event"
          class="fas fa-plus-circle"/>
        <i
          v-else-if="!viewOnlly && !event"
          class="fas fa-edit"/>
        <i
          v-else
          class="fas fa-eye"/>
        {{ tittleModal }}
      </template>
      <b-form
        v-if="show">
        <!-- usuario -->
        <b-form-group
          id="groupstate"
          label="Usuario:"
          label-for="user"
          >
          <b-form-select
            id="user"
            v-model="form.user"
          >
            <b-form-select-option :value="null" disabled>Seleccionar...</b-form-select-option>
              <b-form-select-option
                v-for="(item, index) in states"
                :key="index"
                :value="item.id"
              >{{ item.name }}
            </b-form-select-option>
          </b-form-select>
        </b-form-group>
        <!-- estado -->
        <b-form-group
          id="groupstate"
          label="Estado:"
          label-for="state"
          >
          <b-form-select
            id="state"
            v-model="form.state"
          >
            <b-form-select-option :value="null" disabled>Seleccionar...</b-form-select-option>
              <b-form-select-option
                v-for="(item, index) in states"
                :key="index"
                :value="item.id"
              >{{ item.name }}
            </b-form-select-option>
          </b-form-select>
        </b-form-group>
        <div
          class="text-center">
          <button class="btn btn-primary" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
          </button>
          <b-button
            v-if="event && !viewOnlly"
            :disabled="sending"
            @click="sendData()"
            variant="success">
            <span v-if="sending">
              <b-spinner small type="grow"></b-spinner>
                Guardando...
            </span>
            <span v-else>
              <i class="fas fa-save"/> Guardar
            </span>
          </b-button>
          <b-button
            v-else-if="!event && !viewOnlly"
            :disabled="updating"
            @click="sendData()"
            variant="success">
            <span v-if="updating">
              <b-spinner
                small
                label="Spinning"/> Actualizando...
            </span>
            <span v-else>
              <i class="fas fa-save"/> Actualizar
            </span>
          </b-button>
          <b-button
            variant="danger"
            @click="hideModal"><i class="fas fa-times-circle"/> Cancelar</b-button>
        </div>
      </b-form>
    </b-modal>
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
      // Note `isActive` is left out and will not appear in the rendered table
      allRows: this.row,
      show: true,
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
          key: 'name',
          label: 'Nombre',
          sortable: true
        },
        {
          key: 'user',
          label: 'Usuario',
          sortable: true
        },
        {
          key: 'date',
          label: 'Fecha y Hora',
          sortable: true
        },
        {
          key: 'temperature',
          label: 'Temperatura',
          sortable: true
        },
        {
          key: 'acciones',
          label: 'Acciones',
          visible: false,
          sortable: false
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
    accesses(){
      return this.$store.state.administration.payment
    }
  },
  created() {
    this.$store.dispatch('getPayment')
  },
  methods: {
    count(){
      this.$store.dispatch('count')
    },
    onFiltered(filteredItems) {
      // actualiza la paginacion cuando se usa el filtro
      this.rows = filteredItems.length
      this.currentPage = 1
    },
    sendData(){
      let me = this
      me.sending = true
      console.log('guardando')
      /* setTimeout(() => {
        me.hideModal()
      }, 1000); */
    },
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
          state: null
        }
        //this.$store.dispatch('api/clearErrors') //clean errors of back
      }, 500)
    },
    newAccess(view) {
      this.form.id = null
      this.form.name = null
      this.form.user = null
      this.form.date = null
      this.form.temperature = null
      this.form.state = null
      this.tittleModal = 'Nuevo Registro'
      this.event = 1
      this.sending = false
      this.updating = false
      this.$refs['modal-access'].show()
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
