<template>
  <div class="component_profile p-4">
    <div class="card">
      <div class="card-header first_card">
        <h1><i class="fas fa-user-cog"/> Mi Cuenta</h1>
      </div>
      <div class="card-body body_profile">
        <b-row>
          <b-col cols="md-6" class="mb-4">
            <div class="card">
              <div class="card-header">
                <h1><i class="fas fa-user-circle" /> Perfil</h1>
              </div>
              <div class="card-body">
                  <div>
                    <b-form v-if="show">
                      <!-- Nombre -->
                      <b-form-group
                      id="groupname"
                      label="Nombre de Usuario:"
                      label-for="name"
                      >
                        <b-form-input
                          id="name"
                          v-model="form.name"
                          :class="{ 'is-invalid': $v.form.name.$error }"
                          placeholder="Ingrese Nombre"
                        ></b-form-input>
                        <template v-if="$v.form.name.$error">
                          <div
                            v-if="!$v.form.name.required"
                            class="invalid-feedback">
                            Digite el Nombre
                          </div>
                          <div
                            v-if="!$v.form.name.maxLength"
                            class="invalid-feedback">
                            El Nombre Exede los 130 Caracteres
                          </div>
                        </template>
                      </b-form-group>
                      <!-- Email -->
                      <b-form-group
                        id="groupname"
                        label="E-mail:"
                        label-for="email"
                      >
                        <b-form-input
                          id="email"
                          v-model="form.email"
                          :class="{'is-invalid': $v.form.email.$error || errors.email}"
                          placeholder="Ingrese Correo Electronico"
                          type="email"
                        ></b-form-input>
                        <template v-if="$v.form.email.$error">
                          <div
                            v-if="!$v.form.email.required"
                            class="invalid-feedback">
                            Digite el E-mail
                          </div>
                          <div
                            v-if="!$v.form.email.maxLength"
                            class="invalid-feedback">
                            El E-mail Exede los 130 Caracteres
                          </div>
                          <div
                            v-if="!$v.form.email.email"
                            class="invalid-feedback">
                            El E-mail es Invalido
                          </div>
                        </template>
                        <template v-if="errors.email">
                          <div class="invalid-feedback">
                            {{ errors.email[0] }}
                          </div>
                        </template>
                      </b-form-group>
                      <!-- Rol -->
                      <b-form-group
                      id="groupname"
                      label="Rol:"
                      label-for="rol"
                      >
                        <b-form-input
                          id="rol"
                          class="input-roll"
                          v-model="form.rol"
                          disabled
                        ></b-form-input>
                      </b-form-group>
                      <div class="text-center">
                        <b-button @click="sendData('dataUser')" variant="dark"><i class="far fa-save"></i> Actualizar Datos</b-button>
                      </div>
                    </b-form>
                  </div>
              </div>
            </div>
          </b-col>
          <b-col cols="md-6" class="mb-4">
            <div class="card">
              <div class="card-header">
                <h1><i class="fas fa-key"/> Contraseña</h1>
              </div>
              <div class="card-body">
                <form action="">
                  <!-- Anterios Contraseña -->
                      <b-form-group
                      id="groupname"
                      label="Contraseña Anterior:"
                      label-for="password"
                      >
                        <b-form-input
                          id="password"
                          v-model="form.old_password"
                          :class="{'is-invalid': $v.form.old_password.$error}"
                          type="password"
                          placeholder="Ingrese Contraseña Anterior"
                          required

                        ></b-form-input>
                        <template v-if="$v.form.old_password.$error">
                          <div
                            v-if="!$v.form.old_password.required"
                            class="invalid-feedback">
                            Digite la Contraseña
                          </div>
                          <div
                            v-if="!$v.form.old_password.maxLength"
                            class="invalid-feedback">
                            La Contraseña Exede los 130 Caracteres
                          </div>
                          <div
                            v-if="!$v.form.old_password.minLength"
                            class="invalid-feedback">
                            El Contraseña Debe Tener Mínimo 8 Caracteres
                          </div>
                        </template>
                      </b-form-group>
                      <!-- Contraseña -->
                      <b-form-group
                        id="groupname"
                        label="Contraseña Nueva:"
                        label-for="passNew"
                      >
                        <b-form-input
                          id="passNew"
                          v-model="form.password_new"
                          :class="{'is-invalid': $v.form.password_new.$error}"
                          type="password"
                          placeholder="Ingrese Contraseña Nueva"
                          required

                        ></b-form-input>
                        <template v-if="$v.form.password_new.$error">
                          <div
                            v-if="!$v.form.password_new.required"
                            class="invalid-feedback">
                            Digite la Contraseña
                          </div>
                          <div
                            v-if="!$v.form.password_new.maxLength"
                            class="invalid-feedback">
                            La Contraseña Exede los 130 Caracteres
                          </div>
                          <div
                            v-if="!$v.form.password_new.minLength"
                            class="invalid-feedback">
                            El Contraseña Debe Tener Mínimo 8 Caracteres
                          </div>
                        </template>
                      </b-form-group>
                      <!-- Confirmar contraseña -->
                      <b-form-group
                      id="groupname"
                      label="Confirmar Contraseña:"
                      label-for="confirm_password"
                      >
                        <b-form-input
                          id="confirm_password"
                          v-model="form.confirm_password"
                          :class="{'is-invalid': $v.form.confirm_password.$error}"
                          type="password"
                          placeholder="Confirme Contraseña"
                          required

                        ></b-form-input>
                        <template v-if="$v.form.confirm_password.$error">
                          <div
                            v-if="!$v.form.confirm_password.sameAsPassword"
                            class="invalid-feedback">
                            Las Contraseñas no Coindicen
                          </div>
                        </template>
                      </b-form-group>
                      <div class="text-center">
                        <b-button @click="sendData('changePassword')" variant="dark" ><i class="far fa-save"></i> Actualizar Contraseña</b-button>
                      </div>
                </form>
              </div>
            </div>
          </b-col>
        </b-row>
      </div>
    </div>
  </div>
</template>
<script>
import {
  required,
  minLength,
  maxLength,
  between,
  integer,
  sameAs,
  email
} from 'vuelidate/lib/validators'
export default {
  props: {
    user: String
  },
  data() {
    return {
      typeData: '',
      form: {
        email: '',
        name: '',
        //food: null,
        //checked: []
        rol: null,
        old_password: '',
        password_new: '',
        confirm_password: ''
      },
      /* foods: [{ text: '', value: null }, 'Soltero', 'Casado', 'Muerto', 'No sabe'], */
      show: true,
      errors: []
    }
  },
  computed: {
    userAuth() {
      return JSON.parse(this.user)
    }
  },
  mounted() {
    this.form.name = this.userAuth.name
    this.form.email = this.userAuth.email
    this.form.rol = this.userAuth.roles[0]['name']
  },
  validations() {
    if (this.typeData === 'dataUser') {
      let form = {
        form: {
          name: {
            required,
            maxLength: maxLength(130)
          },
          email: {
            required,
            maxLength: maxLength(130),
            email
          },
          old_password: {},
          password_new: {},
          confirm_password: {}
        }
      }
      return form
    } else if (this.typeData === 'changePassword') {
      let form = {
        form: {
          name: {},
          email: {},
          old_password: {
            required,
            //minLength: minLength(8),
            maxLength: maxLength(255)
          },
          password_new: {
            required,
            minLength: minLength(8),
            maxLength: maxLength(255)
          },
          confirm_password: {
            sameAsPassword: sameAs('password_new')
          }
        }
      }
      return form
    }
    let form = {
      form: {
        name: {},
        email: {},
        old_password: {},
        password_new: {},
        confirm_password: {}
      }
    }
    return form
  },
  methods: {
    sendData(type) {
      let me = this
      me.errors = []
      me.form.name = me.form.name ? me.form.name.toUpperCase() : ''
      me.typeData = type //para realizar validación de formulario dinamicamente
      //validamos q no tenga errores el formulario
      me.$v.$touch()
      if (me.$v.$invalid) {
        return //retornamos errores
      } else {
        //actualizar
        if (type === 'dataUser') {
          //al actualizar los datos basicos
          me.updating = true
          let params = {
            name: me.form.name,
            email: me.form.email
          }
          axios
            .post('/change-data', params)
            .then(res => {
              setTimeout(() => {
                Vue.swal({
                  icon: 'success',
                  title: res.data.message,
                  showConfirmButton: true,
                  timer: 2000
                })
                me.updating = false
                this.$auth.fetchUser()
                this.$v.$reset()
              }, 1000)
            })
            .catch(err => {
              if (err.response.status == 422) {
                me.errors = err.response.data.errors
              }
              me.updating = false
            })
        } else if (type === 'changePassword') {
          //al cambiar la contraseña
          me.updatingPassword = true
          let params = {
            old_password: me.form.old_password,
            password_new: me.form.password_new,
            confirm_password: me.form.confirm_password
          }
          axios
            .post('/change-password', params)
            .then(res => {
              setTimeout(() => {
                Vue.swal({
                  icon: 'success',
                  title: res.data.message,
                  showConfirmButton: true,
                  timer: 2000
                })
                me.updatingPassword = false
                me.form.old_password = ''
                me.form.password_new = ''
                me.form.confirm_password = ''
                this.$v.$reset()
              }, 1000)
            })
            .catch(err => {
              console.error(err)
            })
        }
      }
    },
    onSubmit(evt) {
      evt.preventDefault()
      alert(JSON.stringify(this.form))
    },
    onReset(evt) {
      evt.preventDefault()
      // Reset our form values
      this.form.email = ''
      this.form.name = ''
      this.form.food = null
      this.form.checked = []
      // Trick to reset/clear native browser form validation state
      this.show = false
      this.$nextTick(() => {
        this.show = true
      })
    }
  }
}
</script>
<style lang="scss">
.component_profile{
  .first_card{
    border-bottom: 1px solid #e0e0e0;
  }
  h1{
    margin-bottom: unset;
  }
  //background-color: #dedede;
  .card{
    //box-shadow: 4px 4px 4px -6px black;
    border: 1px solid #e0e0e0;
   }
  .body_profile{
    .card-header{
      background: #5e71e3;
    }
    .card-body {
      .input-roll {
        background-color: #8898aa00;
      }
    }
  }
}
</style>
