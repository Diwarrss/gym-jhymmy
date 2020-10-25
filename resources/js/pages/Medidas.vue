<template>
  <div class="p-4 tracing_component">
    <div class="card">
      <div class="card-header">
        <h1>Componente Seguimiento</h1>
      </div>
      <div class="card-body">
        <div>
          <button class="btn btn-primary mb-3" @click="newTracing()"> Nuevo</button>
        </div>
        <div class="body_table pt-3">
          <TableCustom
            :fields="fields"
            :items="tracings"
            :rows="allRow"
            :per-page="10"/>
        </div>
      </div>
    </div>
    <b-modal
      size="lg"
      ref="modal-medidas"
      id="modal-medidas"
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
        <b-row >
          <b-col cols="md-6">
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
                  v-for="(item, index) in users"
                  :key="index"
                  :value="item.id"
                >{{ item.name }}
              </b-form-select-option>
            </b-form-select>
          </b-form-group>
          </b-col>
          <!-- estado -->
          <b-col cols="md-6">
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
          </b-col>
          <b-col cols="md-4">
             <!-- Espalda -->
            <b-form-group
              id="groupname"
              label="Espalda:"
              label-for="back">
              <b-form-input
                id="back"
                v-model="form.back"
                autofocus
              />
            </b-form-group>
          </b-col>
          <b-col cols="4">
             <!-- Pecho -->
            <b-form-group
              id="groupname"
              label="Pecho:"
              label-for="chest">
              <b-form-input
                id="chest"
                v-model="form.chest"
                autofocus
              />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <!-- Pantorrilla -->
            <b-form-group
              id="groupname"
              label="Pantorrilla:"
              label-for="calf">
              <b-form-input
                id="calf"
                v-model="form.calf"
                autofocus
              />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <!-- Pierna -->
            <b-form-group
              id="groupname"
              label="Pierna:"
              label-for="leg">
              <b-form-input
                id="leg"
                v-model="form.leg"
                autofocus
              />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <!-- Adbdomen -->
            <b-form-group
              id="groupname"
              label="Abdomen:"
              label-for="abdomen">
              <b-form-input
                id="abdomen"
                v-model="form.abdomen"
                autofocus
              />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <!-- Brazo -->
            <b-form-group
              id="groupname"
              label="Brazo:"
              label-for="arm">
              <b-form-input
                id="arm"
                v-model="form.arm"
                autofocus
              />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <!-- cintura -->
            <b-form-group
              id="groupname"
              label="Cintura:"
              label-for="waist">
              <b-form-input
                id="waist"
                v-model="form.waist"
                autofocus
              />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <!-- Peso -->
            <b-form-group
              id="groupname"
              label="Peso:"
              label-for="weigth">
              <b-form-input
                id="weigth"
                v-model="form.weigth"
                autofocus
              />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <!-- Altura -->
            <b-form-group
              id="groupname"
              label="Altura:"
              label-for="size">
              <b-form-input
                id="size"
                v-model="form.size"
                autofocus
              />
            </b-form-group>
          </b-col>
        </b-row>
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
      form: {
        user: '',
        state:'',
        back: '',
        calf: '',
        leg: '',
        abdomen: '',
        arm: '',
        waist: '',
        weigth: '',
        size: ''
      },
      fields: [
        {
          key: 'id',
          label: '#',
          sortable: true
        },
        {
          key: 'user.name',
          label: 'Usuario',
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
    this.$store.dispatch('getTracing')
  },
  methods: {
    hideModal() {
      this.$refs['modal-medidas'].hide()
      setTimeout(() => {
        //this.$v.$reset()
        this.viewOnlly = false
        this.updating = false
        this.sending = false
        this.form = {
          user: null,
          back: null,
        }
        //this.$store.dispatch('api/clearErrors') //clean errors of back
      }, 500)
    },
    newTracing(view) {
      this.form.user = null
      this.form.state = null
      this.form.back = null
      this.form.calf = null
      this.form.leg = null
      this.form.abdomen = null
      this.form.arm = null
      this.form.waist = null
      this.form.weigth = null
      this.form.size = null
      this.tittleModal = 'Nuevo Registro'
      this.event = 1
      this.sending = false
      this.updating = false
      this.$refs['modal-medidas'].show()
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
      this.form.user = item.user
      this.form.state = item.state
      this.form.back = item.back
      this.form.calf = item.calf
      this.form.leg = item.leg
      this.form.abdomen = item.abdomen
      this.form.arm = item.arm
      this.form.waist = item.waist
      this.form.weigth = item.weigth
      this.form.size = item.size
      this.event = 0
      this.sending = false
      this.updating = false
      this.$refs['modal-medidas'].show()
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
