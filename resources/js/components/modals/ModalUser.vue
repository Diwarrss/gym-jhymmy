<template>
  <div>
    <!-- Info modal -->
    <b-modal
      ref="modal-users"
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
        <b-row>
          <b-col cols="md-6">
            <b-form-group
                id="groupname"
                label="Nombre:"
                label-for="name">
                <b-form-input
                  id="name"
                  v-model="form.name"
                  autofocus
                />
              </b-form-group>
          </b-col>
        <!-- cedula -->
        <b-col cols="md-6">
         <b-form-group
          id="groupname"
          label="Cedula:"
          label-for="identification">
          <b-form-input
            id="identification"
            v-model="form.identification"
            autofocus
          />
        </b-form-group>
        </b-col>
        <!-- Dirección -->
        <b-col cols="md-6">
         <b-form-group
          id="groupname"
          label="Dirección:"
          label-for="address">
          <b-form-input
            id="address"
            v-model="form.address"
            autofocus
          />
        </b-form-group>
        </b-col>
        <!-- Numero del celula -->
        <b-col cols="md-6">
         <b-form-group
          id="groupname"
          label="Numero Telefonico:"
          label-for="phone">
          <b-form-input
            id="phone"
            v-model="form.phone"
            autofocus
          />
        </b-form-group>
        </b-col>
        <!-- fecha de nacimiento -->
        <b-col cols="md-6">
        <b-form-group
          id="groupname"
          label="Fecha de Nacimiento:"
          label-for="birthdate">
          <b-form-input
            id="birthdate"
            v-model="form.birthdate"
            autofocus
          />
        </b-form-group>
        </b-col>
        <!-- correo electronico -->
        <b-col cols="md-6">
        <b-form-group
          id="groupname"
          label="E-mail:"
          label-for="email">
          <b-form-input
            id="email"
            v-model="form.email"
            autofocus
          />
        </b-form-group>
        </b-col>
        <!-- Genero -->
        <b-col cols="md-6">
            <b-form-group
                id="groupname"
                label="Genero:"
                label-for="gender">
                <b-form-input
                  id="gender"
                  v-model="form.gender"
                  autofocus
                />
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
    item: {
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
      allRow: this.row,
      show: true,
      form: {
        id: '',
        name: '',
        from_date: '',
        state: ''
      },
      sending: false,
      updating: false,
      states: [
        { "id" : "1", "name" : "Activo"},
        { "id" : "2", "name" : "Inactivo"}
      ]
    }
  },
  computed: {
    users(){
      return this.$store.state.user.users
    },
    row() {
      return this.$store.state.config.allRow
    }
  },
  methods: {
    hideModal() {
      this.$bvModal.hide(this.modal)
      EventBus.$emit('clear-data-modal')
    }
  },
  created() {
    EventBus.$on('show-modal-user-table', () => {
      this.$bvModal.show('modal-users-table')
    })
    EventBus.$on('show-modal-user', () => {
    this.$bvModal.show('modal-users')
    })
    this.$store.dispatch('getUsers')
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
