<template>
  <div>
    <!-- Info modal -->
    <b-modal
      size="lg"
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
        class="form-modal-user"
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
              :class="{ 'is-invalid': $v.form.identification.$error || errors.identification}"
            />
            <template v-if="$v.form.identification.$error">
              <div class="invalid-feedback" v-if="!$v.form.identification.required">
                Digite el Cedula
              </div>
              <div class="invalid-feedback" v-if="!$v.form.identification.maxLength">
                Exede los 20 Caracteres
              </div>
            </template>
            <template v-if="errors.identification">
              <div class="invalid-feedback">
                {{ errors.identification[0] }}
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
              <!-- <b-form-input
                id="birthdate"
                :disabled="viewOnlly"
                v-model="form.birthdate"
                :class="{ 'is-invalid': $v.form.birthdate.$error }"
              /> -->
              <date-picker
                valueType="format"
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
              :class="{ 'is-invalid': $v.form.email.$error || errors.email}"
            />
            <template v-if="$v.form.email.$error">
              <div class="invalid-feedback" v-if="!$v.form.email.required">
                Digite el E-mail
              </div>
              <div class="invalid-feedback" v-if="!$v.form.email.maxLength">
                Exede los 200 Caracteres
              </div>
            </template>
            <template v-if="errors.email">
              <div class="invalid-feedback">
                {{ errors.email[0] }}
              </div>
            </template>
          </b-form-group>
          </b-col>
          <!-- password -->
          <b-col cols="md-6">
            <b-form-group
              id="groupname"
              label="Contraseña:"
              label-for="password">
              <b-form-input
                id="password"
                ref="password"
                :disabled="viewOnlly ? true : false"
                :class="{'is-invalid': $v.form.password.$error}"
                v-model="form.password"
                type="password"
                name="password"
                />
              <template v-if="$v.form.password.$error">
                <div
                  v-if="!$v.form.password.required"
                  class="invalid-feedback">
                  Digite la Contraseña
                </div>
                <div
                  v-if="!$v.form.password.maxLength"
                  class="invalid-feedback">
                  La Contraseña Exede los 130 Caracteres
                </div>
                <div
                  v-if="!$v.form.password.minLength"
                  class="invalid-feedback">
                  El Contraseña Debe Tener Mínimo 8 Caracteres
                </div>
              </template>
            </b-form-group>
          </b-col>
          <!-- confirmacion de password -->
          <b-col class="col-md-6">
            <b-form-group
              id="groupinitial"
              label="Confirmar Contraseña:"
              label-for="confirm_password">
              <b-form-input
                id="confirm_password"
                :disabled="viewOnlly ? true : false"
                v-model="form.confirm_password"
                :class="{'is-invalid': $v.form.confirm_password.$error}"
                type="password"
                name="confirm_password"
              />
              <template v-if="$v.form.confirm_password.$error">
                <div
                  v-if="!$v.form.confirm_password.sameAsPassword"
                  class="invalid-feedback">
                  Las Contraseñas no Coindicen
                </div>
              </template>
            </b-form-group>
          </b-col>
          <!-- Genero -->
          <b-col cols="md-4">
            <b-form-group
              id="groupname"
              label="Genero:"
              label-for="gender">
              <b-form-select
                id="gender"
                :disabled="viewOnlly"
                v-model="form.gender_id"
                :class="{ 'is-invalid': $v.form.gender_id.$error }"
              >
                <b-form-select-option :value="null" disabled>Seleccionar...</b-form-select-option>
                  <b-form-select-option
                    v-for="(item, index) in genders"
                    :key="index"
                    :value="item.id"
                  >{{ item.name }}
                </b-form-select-option>
              </b-form-select>
              <template v-if="$v.form.gender_id.$error">
                <div class="invalid-feedback" v-if="!$v.form.gender_id.required">
                  Seleccione el Genero
                </div>
              </template>
            </b-form-group>
          </b-col>
          <!-- estado -->
          <b-col cols="md-4">
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
          <!-- Rol -->
          <b-col cols="md-4">
            <b-form-group
              id="groupname"
              label="Rol:"
              label-for="roles"
              >
              <b-form-select
                id="roles"
                v-model="form.rol_id"
                :class="{ 'is-invalid': $v.form.rol_id.$error }"
                :disabled="viewOnlly"
              >
                <b-form-select-option :value="null" disabled>Seleccionar...</b-form-select-option>
                <b-form-select-option :value="1">super_admin</b-form-select-option>
                <b-form-select-option :value="2">cliente</b-form-select-option>
              </b-form-select>
              <template v-if="$v.form.rol_id.$error">
                <div class="invalid-feedback" v-if="!$v.form.rol_id.required">
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
import DatePicker from 'vue2-datepicker'
import 'vue2-datepicker/index.css'
import { required, minLength, maxLength, between, integer, email, sameAs } from 'vuelidate/lib/validators'
import EventBus from '../../bus'
export default {
  components: { DatePicker },
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
        confirm_password: null,
        password: null,
        gender_id: null,
        state_id: null,
        rol_id: null,
        old_rol_id: null
      },
      sending: false,
      updating: false
      /* states: [
        { "id" : "1", "name" : "Activo"},
        { "id" : "2", "name" : "Inactivo"}
      ] */
    }
  },
  computed: {
    users(){
      return this.$store.state.user.users
    },
    row() {
      return this.$store.state.user.allRow
    },
    errors() {
      return this.$store.state.actions.errors
    },
    states(){
      return this.$store.state.config.states
    },
    genders(){
      return this.$store.state.config.genders
    }
  },
  validations() {
    if (this.event) {
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
          password: {
            required,
            minLength: minLength(8),
            maxLength: maxLength(255)
          },
          confirm_password: {
            sameAsPassword: sameAs('password')
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
          },
          rol_id: {
            required
          }
        }
      }
      return form
    } else {
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
          password: {
          },
          confirm_password: {
            sameAsPassword: sameAs('password')
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
          },
          rol_id: {
            required
          }
        }
      }
      return form
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
      this.form.password = null
      this.form.confirm_password = null
      this.form.gender_id = null
      this.form.state_id = null
      this.form.rol_id = null
      EventBus.$emit('clear-data-modal')
      this.$v.$reset()
    },
    sendData(evt) {
      evt.preventDefault()
      let me = this
      me.form.name = me.form.name ? me.form.name.toUpperCase() : ''
      this.form.old_rol_id =this.form.rol_id
      this.$v.$touch()
      if (this.$v.$invalid) {
        return
      } else {
        //Crear
        me.sending = true
        if (me.event) {
          let params = {
            url: '/users',
            data: me.form,
            files: false,
            action: 'getUsers'
          }
          me.$store.dispatch('create', params)
          setTimeout(() => {
            if (Object.keys(me.errors).length >= 1) {
              //validation back
              me.sending = false
              return
            } else {
              me.sending = false
              //me.$store.dispatch('config/getUsers')
              me.hideModal()
            }
          }, 2000)
        } else {
          me.updating = true
          //actualizar
          let params = {
            url: `/users/${me.form.id}`,
            data: me.form,
            files: false,
            action: 'getUsers'
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
          }, 2000)
        }
      }
    },
  },
  created() {
    this.$store.dispatch('getStates', 1)
    this.$store.dispatch('getGenders', 1)
    EventBus.$on('show-modal-user-table', () => {
      this.$bvModal.show('modal-users-table')
    })
    EventBus.$on('show-modal-user', () => {
      this.$bvModal.show('modal-users')
    })
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
      this.form.rol_id = this.items.rol_id

    }
  },
}
</script>
<style lang="scss">
  .form-modal-user {
    .form-group {
      .mx-datepicker {
        width: 100%;
        .mx-input {
          color: #8898aa;
          height: 46px;
        }
      }
    }
  }
</style>
