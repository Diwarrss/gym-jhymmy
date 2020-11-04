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
        @submit="sendData"
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
                :disabled="viewOnlly"
                v-model="form.name"
                :class="{ 'is-invalid': $v.form.name.$error }"
                autofocus
              />
              <template v-if="$v.form.name.$error">
                <div class="invalid-feedback" v-if="!$v.form.name.required">
                  Digite el Nombre
                </div>
                <div class="invalid-feedback" v-if="!$v.form.name.maxLength">
                  Exede los 200 Caracteres
                </div>
              </template>
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
            :disabled="viewOnlly"
            v-model="form.identification"
            :class="{ 'is-invalid': $v.form.identification.$error }"
          />
          <template v-if="$v.form.identification.$error">
            <div class="invalid-feedback" v-if="!$v.form.identification.required">
              Digite el Cedula
            </div>
            <div class="invalid-feedback" v-if="!$v.form.identification.maxLength">
              Exede los 20 Caracteres
            </div>
          </template>
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
            :disabled="viewOnlly"
            v-model="form.address"
            :class="{ 'is-invalid': $v.form.address.$error }"
          />
          <template v-if="$v.form.address.$error">
            <div class="invalid-feedback" v-if="!$v.form.address.required">
              Digite la Dirección
            </div>
            <div class="invalid-feedback" v-if="!$v.form.address.maxLength">
              Exede los 200 Caracteres
            </div>
          </template>
        </b-form-group>
        </b-col>
        <!-- Numero del telefono -->
        <b-col cols="md-6">
         <b-form-group
          id="groupname"
          label="Numero Telefonico:"
          label-for="phone">
          <b-form-input
            id="phone"
            :disabled="viewOnlly"
            v-model="form.phone"
            :class="{ 'is-invalid': $v.form.phone.$error }"
          />
          <template v-if="$v.form.phone.$error">
            <div class="invalid-feedback" v-if="!$v.form.phone.required">
              Digite el Numero
            </div>
            <div class="invalid-feedback" v-if="!$v.form.phone.maxLength">
              Exede los 20 Caracteres
            </div>
          </template>
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
            :disabled="viewOnlly"
            v-model="form.birthdate"
            :class="{ 'is-invalid': $v.form.birthdate.$error }"
          />
          <template v-if="$v.form.birthdate.$error">
            <div class="invalid-feedback" v-if="!$v.form.birthdate.required">
              Digite el fecha de nacimiento
            </div>
          </template>
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
            :disabled="viewOnlly"
            v-model="form.email"
            :class="{ 'is-invalid': $v.form.email.$error }"
          />
          <template v-if="$v.form.email.$error">
            <div class="invalid-feedback" v-if="!$v.form.email.required">
              Digite el E-mail
            </div>
            <div class="invalid-feedback" v-if="!$v.form.email.maxLength">
              Exede los 200 Caracteres
            </div>
          </template>
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
                  :disabled="viewOnlly"
                  v-model="form.gender_id"
                  :class="{ 'is-invalid': $v.form.gender_id.$error }"
                />
                <template v-if="$v.form.gender_id.$error">
            <div class="invalid-feedback" v-if="!$v.form.gender_id.required">
              Seleccione el Genero
            </div>
          </template>
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
            :disabled="viewOnlly"
            v-model="form.state_id"
            :class="{ 'is-invalid': $v.form.state_id.$error }"
          >
            <b-form-select-option :value="null" disabled>Seleccionar...</b-form-select-option>
              <b-form-select-option
                v-for="(item, index) in states"
                :key="index"
                :value="item.id"
              >{{ item.name }}
            </b-form-select-option>
          </b-form-select>
          <template v-if="$v.form.state_id.$error">
            <div class="invalid-feedback" v-if="!$v.form.state_id.required">
              Seleccione el Estado
            </div>
          </template>
        </b-form-group>
        </b-col>
        </b-row>
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
        name: '',
        identification: '',
        address: '',
        phone: '',
        birthdate: '',
        email: '',
        gender_id: '',
        state_id: ''
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
      this.form.id = ''
      this.form.name =''
      this.form.identification = ''
      this.form.address = ''
      this.form.phone = ''
      this.form.birthdate = ''
      this.form.email = ''
      this.form.gender_id = ''
      this.form.state_id = ''
      EventBus.$emit('clear-data-modal')
      this.$v.$reset()
    },
    sendData(evt) {
      evt.preventDefault()
      let me = this
      me.form.name = me.form.name ? me.form.name.toUpperCase() : ''
      me.form.identification = me.form.identification ? me.form.identification.toUpperCase() : ''
      me.form.address = me.form.address ? me.form.address.toUpperCase() : ''
      me.form.phone = me.form.phone ? me.form.phone.toUpperCase() : ''
      me.form.birthdate = me.form.birthdate ? me.form.birthdate.toUpperCase() : ''
      me.form.email = me.form.email ? me.form.email.toUpperCase() : ''

      this.$v.$touch()
      if (this.$v.$invalid) {
        return
      } else {
        //Crear
        me.sending = true
        if (me.event) {
          let params = {
            url: 'users',
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
              me.$store.dispatch('config/getUsers')
              me.hideModal()
            }
          }, 2000)
        } else {
          me.updating = true
          //actualizar
          let params = {
            url: `users/${me.form.id}`,
            data: me.form,
            action: 'config/getUsers'
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
  validations() {
    let form = {
      form: {
        name: {
          required,
          maxLength: maxLength(200)
        },
        identification: {
          required,
          maxLength: maxLength(20)
        },
        address: {
          required,
          maxLength: maxLength(20)
        },
        birthdate: {
          required
        },
        phone: {
          required,
          maxLength: maxLength(20)
        },
        email: {
          required,
          maxLength: maxLength(200)
        },
        phone: {
          required,
          maxLength: maxLength(20)
        },
        gender_id: {
          required
        },
        state_id: {
          required
        }
      }
    }
    return form
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
  watch: {
    items(){
      //console.log('items')
      this.form.id = this.items.id
      this.form.name = this.items.name
      this.form.identification = this.items.identification
      this.form.address = this.items.address
      this.form.phone = this.items.phone
      this.form.birthdate = this.items.birthdate
      this.form.email = this.items.email
      this.form.gender_id = this.items.gender_id
      this.form.state_id = this.items.state_id

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
