<template>
  <div class="p-4 tracing_component">
    <div class="card">
      <div class="card-header">
        <h1>Componente Seguimiento</h1>
      </div>
      <div class="card-body">
        <b-row>
          <b-col>
            <b-form>
              <b-form-group
                id="group1"
                label-cols-md="3"
                label="Usuario:"
                label-for="user_id">
                <v-select id="user_id"
                  v-model="form.user_id"
                  :options="users"
                  placeholder="Seleccionar..."
                  :reduce="users => users.id"
                  label="name"
                  name="user"
                  @input="changeUser"
                >
                <div slot="no-options">No hay Resultados!</div>
                </v-select>
              </b-form-group>
            </b-form>
          </b-col>
          <b-col sm="12" md="12" lg="6">
            <button class="btn btn-primary mb-3" @click="newTracing()">Nuevo</button>
          </b-col>
        </b-row>
        <div class="body_table pt-3">
          <TableCustom
            type-page="tracing"
            :fields="fields"
            :items="tracings"
            :rows="allRow"
            :per-page="10"
            :show-filter="false"
            :per-pagination="false"
            />
        </div>
      </div>
    </div>
    <ModalTracing :viewOnlly="false" :event="true" tittleModal="Nuevo Registro" :modal="modal" :user="form.user_id"/>
  </div>
</template>
<script>
import TableCustom from '../components/table/TableCustom'
import ModalTracing from '../components/modals/ModalTracing'
import EventBus from '../bus'
export default {
  components: {
    TableCustom,
    ModalTracing
  },
  data() {
    return {
      // Note `isActive` is left out and will not appear in the rendered table
      states: [
        { "id" : "1", "name" : "Activo"},
        { "id" : "2", "name" : "Inactivo"}
      ],
      show: true,
      sending: false,
      updating: false,
      event: '',
      viewOnlly: false,
      tittleModal : '',
      allRow: this.row,
      rows: 4,
      modal: 'modal-tracing',
      form: {
        user_id: 0,
        back: '',
        calf: '',
        leg: '',
        date: '',
        arm: '',
        waist: '',
        weigth: '',
        size: ''
      },
      fields: [
        {
          key: 'back',
          label: 'Espalda',
          sortable: true
        },
        {
          key: 'chest',
          label: 'Pecho',
          sortable: true
        },
        {
          key: 'leg',
          label: 'Pierna',
          sortable: true
        },
        {
          key: 'arm',
          label: 'Brazo',
          sortable: true
        },
        {
          key: 'waist',
          label: 'cintura',
          sortable: true
        },
        {
          key: 'weight',
          label: 'Peso',
          sortable: true
        },
        {
          key: 'created_at',
          label: 'Fecha',
          sortable: true
        },
        {
          key: 'acciones',
          label: 'Acciones',
          visible: false,
          sortable: false
        }
      ],
      items: [
        { isActive: true, age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
        { isActive: false, age: 21, first_name: 'Larsen', last_name: 'Shaw' },
        { isActive: false, age: 89, first_name: 'Geneva', last_name: 'Wilson' },
        { isActive: true, age: 38, first_name: 'Jami', last_name: 'Carney' }
      ]
    }
  },
  computed: {
    tracings(){
      return this.$store.state.administration.tracings
    },
    row() {
      return this.$store.state.administration.allRow
    },
    users(){
      return this.$store.state.user.users
    },
  },
  created() {
    // this.$store.dispatch('getTracing')
    this.$store.dispatch('getUsers')
  },
  methods: {
    changeUser () {
      this.$store.dispatch('getTracing', this.form.user_id)
    },
    newTracing(view) {
      EventBus.$emit('show-modal-tracing')
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
      this.form.user_id = item.user_id
      //this.form.state = item.state
      this.form.back = item.back
      this.form.calf = item.calf
      this.form.leg = item.leg
      this.form.date = item.date
      this.form.arm = item.arm
      this.form.waist = item.waist
      this.form.weigth = item.weigth
      this.form.size = item.size
      this.event = 0
      this.sending = false
      this.updating = false
      this.$refs['modal-tracing'].show()
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
  .tracing_component {
    .card-body {
      .form-group {
        label {
          @media (min-width: 992px) {
            text-align: right;
          }
        }
        .vs__dropdown-toggle {
          height: 46px;
        }
      }
    }
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
