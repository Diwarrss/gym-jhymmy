<template>
  <div>
    <b-modal
      size="lg"
      ref="modal-tracing"
      :id="modal"
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
              <v-select
                id="user"
                v-model="form.user_id"
                :options="users"
                placeholder="Seleccionar..."
                :reduce="users => users.id"
                label="name"
                name="user"
                :disabled="viewOnlly"
              >
                <div slot="no-options">No hay Resultados!</div>
              </v-select>
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
              :disabled="viewOnlly"
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
             <!-- Fecha -->
            <b-form-group
              id="date"
              label="Fecha:"
              label-for="created_at">
              <b-form-input
                id="created_at"
                v-model="form.created_at"
                :disabled="viewOnlly"
              />
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
                :disabled="viewOnlly"
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
                :disabled="viewOnlly"
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
                :disabled="viewOnlly"
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
                :disabled="viewOnlly"
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
                :disabled="viewOnlly"
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
                :disabled="viewOnlly"
              />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <!-- Peso -->
            <b-form-group
              id="groupname"
              label="Peso:"
              label-for="weight">
              <b-form-input
                id="weight"
                v-model="form.weight"
                :disabled="viewOnlly"
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
                :disabled="viewOnlly"
              />
            </b-form-group>
          </b-col>
        </b-row>
        <div
          class="text-center">
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
import EventBus from '../../bus'
export default {
  props: {
    viewOnlly: {
      type: Boolean,
      default: ()=> false
    },
    event: {
      type: Boolean,
      default: ()=> false
    },
    items: {
      type: Object,
      default: ()=> {}
    },
    tittleModal: {
      type: String,
      default: ()=> 'Titulo'
    },
    modal: {
      type: String,
      default: () => ''
    }
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
      allRow: this.row,
      rows: 4,
      form: {
        id: '',
        user: '',
        state:'',
        back: '',
        chest: '',
        calf: '',
        leg: '',
        created_at: '',
        arm: '',
        waist: '',
        weight: '',
        size: ''
      },
    }
  },
  computed: {
    users() {
      return this.$store.state.user.users
    }
  },
  methods: {
    hideModal() {
      this.form.id = ''
      this.form.user = ''
      this.form.state = ''
      this.form.back = ''
      this.form.chest = ''
      this.form.calf = ''
      this.form.leg = ''
      this.form.created_at = ''
      this.form.arm = ''
      this.form.waist = ''
      this.form.weight = ''
      this.form.size = ''
      this.$bvModal.hide(this.modal)
      EventBus.$emit('clear-data-modal')
    }
  },
  created() {
    EventBus.$on('show-modal-tracing-table', () => {
      this.$bvModal.show('modal-tracing-table')
      console.log(this.items)
    })
    EventBus.$on('show-modal-tracing', () => {
      this.$bvModal.show('modal-tracing')
    })
    this.$store.dispatch('getTracing')
  },
  watch: {
    items(){
      //console.log('items')
      this.form.id = this.items.id
      this.form.user = this.items.user
      this.form.state = this.items.state
      this.form.back = this.items.back
      this.form.chest = this.items.chest
      this.form.calf =  this.items.calf
      this.form.leg = this.items.leg
      this.form.created_at = this.items.created_at
      this.form.arm = this.items.arm
      this.form.waist = this.items.waist
      this.form.weight = this.items.weight
      this.form.size = this.items.size
    }
  },
}
</script>
<style lang="scss">
  .modal-content{
    .v-select{
      .vs__dropdown-toggle{
        height: 46px !important;
      }
    }
    /* .vdpComponent.vdpWithInput>input {
      height: 46px;
      width: 100%;
      border-radius: 5px;
      border: 1px solid #cac7c7;
      font-size: 16px;
      padding-left: 10px;
      color: black;
    } */
    /* .vdpComponent {
      width: 100%;
    } */
  }
</style>
