<template>
  <div>
    <!-- Info modal -->
    <b-modal
      ref="modal-users"
      id="modal-users"
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
          id="groupname"
          label="Nombre:"
          label-for="name">
          <b-form-input
            id="name"
            v-model="form.name"
            autofocus
          />
        </b-form-group>
        <!-- cedula -->
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
        <!-- Dirección -->
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
        <!-- Numero del celula -->
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
        <!-- fecha de nacimiento -->
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
        <!-- correo electronico -->
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
      event: '',
      viewOnlly: false,
      tittleModal : '',
      states: [
        { "id" : "1", "name" : "Activo"},
        { "id" : "2", "name" : "Inactivo"}
      ]
    }
  },
  computed: {
    users(){
      return this.$store.state.user.users
    }
  },
  methods: {
    hideModal() {
      this.$bvModal.hide('modal-users')
    }
  },
  created() {
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
