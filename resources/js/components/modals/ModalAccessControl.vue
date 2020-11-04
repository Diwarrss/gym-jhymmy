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
              label="Usuario:"
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
          label="Temperatura:"
          label-for="temperature">
          <b-form-input
            id="temperature"
            v-model="form.temperature"
            :class="{ 'is-invalid': $v.form.temperature.$error }"
            :disabled="viewOnlly"
            autofocus
          />
          <template v-if="$v.form.temperature.$error">
            <div class="invalid-feedback" v-if="!$v.form.temperature.required">
              Digite la Temperatura
            </div>
          </template>
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
            :class="{ 'is-invalid': $v.form.state.$error }"
          >
            <b-form-select-option :value="null" disabled>Seleccionar...</b-form-select-option>
            <b-form-select-option :value="1">Activo</b-form-select-option>
            <b-form-select-option :value="0">Inactivo</b-form-select-option>
          </b-form-select>
          <template v-if="$v.form.state.$error">
            <div class="invalid-feedback" v-if="!$v.form.state.required">
              Seleccione el Estado
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
        user_id: null,
        date: '',
        temperature:'',
        state: null
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
        },
        state: {
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
    users() {
      return this.$store.state.user.users
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
      this.$v.$touch()
      if (this.$v.$invalid) {
        return
      } else {
        //Crear
        me.sending = true
        if (me.event) {
          let params = {
            url: 'access_control',
            data: me.form,
            files: false
          }
          me.$store.dispatch('api/create', params)
          setTimeout(() => {
            if (Object.keys(me.errors).length >= 1) {
              //validation back
              me.sending = false
              return
            } else {
              me.sending = false
              me.$store.dispatch('config/getAccessControl')
              me.hideModal()
            }
          }, 2000)
        } else {
          me.updating = true
          //actualizar
          let params = {
            url: `access_control/${me.form.id}`,
            data: me.form,
            action: 'config/getAccessControl'
          }
          me.$store.dispatch('api/update', params)
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
          }, 2000)
        }
      }
    },
  },
   watch: {
    row() {
      this.form.id = this.items.id
      this.form.name = this.items.name
      this.form.date = this.items.date
      this.form.temperature = this.items.temperature
      this.form.state = this.items.state
    }
  },
  created() {
    EventBus.$on('show-modal-access-table', () => {
      this.$bvModal.show('modal-access-table')
      console.log(this.items)
    })
    EventBus.$on('show-modal-access', () => {
      this.$bvModal.show('modal-access')
    })
    this.$store.dispatch('getAccessControl')
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
