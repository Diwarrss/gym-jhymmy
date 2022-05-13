<template>
  <div>
    <!-- Info modal -->
    <b-modal
      ref="modal-access"
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
        @submit="sendData"
        v-if="show">
        <!-- usuario -->
        <b-form-group
              id="groupusers"
              label="Seleccionar cliente:"
              label-for="user_id"
              >
              <v-select
                id="user_id"
                v-model="form.user_id"
                :class="{ 'is-invalid': $v.form.user_id.$error }"
                :options="users"
                placeholder="Seleccionar..."
                :reduce="users => users.id"
                label="name"
                name="user"
                :disabled="viewOnlly"
              >
                <div slot="no-options">No hay Resultados!</div>
              </v-select>
              <template v-if="$v.form.user_id.$error">
                <div class="invalid-feedback" v-if="!$v.form.user_id.required">
                  Seleccione Usuario
                </div>
              </template>
            </b-form-group>
        <!-- temperatura -->
        <b-form-group
          id="groupname"
          label="Temperatura °C:"
          label-for="temperature">
          <b-form-input
            id="temperature"
            v-model="form.temperature"
            :class="{ 'is-invalid': $v.form.temperature.$error }"
            :disabled="viewOnlly"
          />
          <template v-if="$v.form.temperature.$error">
            <div class="invalid-feedback" v-if="!$v.form.temperature.required">
              Digite la Temperatura
            </div>
          </template>
        </b-form-group>
        <div
          class="text-center">
          <b-button
            v-if="event && !viewOnlly"
            :disabled="sending"
            type="submit"
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
            type="submit"
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
import { required, minLength, maxLength, between, integer, email } from 'vuelidate/lib/validators'
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
      allRow: this.row,
      show: true,
      form: {
        id: '',
        user_id: null,
        temperature: ''
      },
      sending: false,
      updating: false
    }
  },
  validations() {
    let form = {
      form: {
        user_id: {
          required
        },
        temperature: {
          required
        }
      }
    }
    return form
  },
  computed: {
    AccessCotrol(){
      return this.$store.state.administration.access_control
    },
    users(){
      const users = this.$store.state.user.users.filter(user => {
        return user.roles.find(role => role.name !== 'super_admin')
      })
      return users.filter(user => user.state.name == 'Activo')
    },
    errors() {
      return this.$store.state.actions.errors
    }
  },
  methods: {
    hideModal() {
      this.form.id = ''
      this.form.user_id = null
      this.form.date = ''
      this.form.temperature = ''
      this.form.state = null
      this.$bvModal.hide(this.modal)
      this.$v.$reset()
      EventBus.$emit('clear-data-modal')
    },
    sendData(evt) {
      evt.preventDefault()
      let me = this
      me.$v.$touch()
      if (this.$v.$invalid) {
        return
      } else {
        //Crear
        me.sending = true
        if (me.event) {
          let params = {
            url: '/access-controlls',
            data: me.form,
            files: false,
            action: 'getAccessControl',
          }
          me.$store.dispatch('create', params)

          setTimeout(() => {
            //console.log(Object.keys(me.errors).length)
            if (Object.keys(me.errors).length >= 1) {
              //validation back
              me.sending = false
              return
            } else {
              me.sending = false
              //me.$store.dispatch('config/getAccessControl')
              me.hideModal()
            }
          }, 300)
        } else {
          me.updating = true
          //actualizar
          let params = {
            url: `/access_control/${me.form.id}`,
            data: me.form,
            action: 'getAccessControl',
            files: false
          }
          me.$store.dispatch('update', params)
          setTimeout(() => {
            if (Object.keys(me.errors).length !== 0) {
              //validation back
              me.updating = false
              //console.log('Paso el front')
              return
            } else {
              //console.log('errors vacio')
              me.updating = false
              //me.$store.dispatch('config/getGender')
              me.hideModal()
            }
          }, 300)
        }
      }
    },
  },
   watch: {
    items() {
      this.form.id = this.items.id
      this.form.user_id = this.items.user_id
      this.form.date = this.items.date
      this.form.temperature = this.items.temperature
      this.form.state = this.items.state
    }
  },
  created() {
    EventBus.$on('show-modal-access-table', () => {
      this.$bvModal.show('modal-access-table')
      this.$store.dispatch('getUsers')
    })
    EventBus.$on('show-modal-access', () => {
      this.$bvModal.show('modal-access')
      this.$store.dispatch('getUsers')
    })
    //this.$store.dispatch('getAccessControl')
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
