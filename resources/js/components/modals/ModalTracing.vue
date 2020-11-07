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
      class="form-modal-tracing"
        @submit="sendData"
        v-if="show">
        <!-- usuario -->
        <b-row >
          <b-col cols="md-6">
            <b-form-group
              id="groupusers"
              label="Usuario:"
              label-for="user_id"
              >
              <v-select
                id="user_id"
                v-model="form.user_id"
                :class="{ 'is-invalid': $v.form.user_id.$error || errors.user_id}"
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
              <template v-if="errors.user_id">
                <div class="invalid-feedback">
                  {{ errors.user_id[0] }}
                </div>
              </template>
            </b-form-group>
          </b-col>
          <!-- estado -->
          <!-- <b-col cols="md-6">
          <b-form-group
            id="groupstate"
            label="Estado:"
            label-for="state"
            >
            <b-form-select
              id="state"
              v-model="form.state"
              :class="{ 'is-invalid': $v.form.state.$error }"
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
             <template v-if="$v.form.state.$error">
              <div class="invalid-feedback" v-if="!$v.form.state.required">
                Seleccione el Estado
              </div>
            </template>
          </b-form-group>
          </b-col> -->
          <!-- Fecha -->
          <b-col cols="md-6">
            <b-form-group
              id="groupname"
              label="Fecha de Inicio:"
              label-for="created_at">
              <!-- <b-form-input
                id="birthdate"
                :disabled="viewOnlly"
                v-model="form.birthdate"
                :class="{ 'is-invalid': $v.form.birthdate.$error }"
              /> -->
              <date-picker
                valueType="format"
                id="created_at"
                :disabled="viewOnlly"
                v-model="form.created_at"
                :class="{ 'is-invalid': $v.form.created_at.$error }"
                />
              <template v-if="$v.form.created_at.$error">
                <div class="invalid-feedback" v-if="!$v.form.created_at.required">
                  Fecha
                </div>
              </template>
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
                :class="{ 'is-invalid': $v.form.back.$error }"
                :disabled="viewOnlly"
              />
              <template v-if="$v.form.back.$error">
                <div class="invalid-feedback" v-if="!$v.form.back.required">
                  Digite la Medida
                </div>
              </template>
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
                :class="{ 'is-invalid': $v.form.chest.$error }"
                :disabled="viewOnlly"
              />
              <template v-if="$v.form.chest.$error">
                <div class="invalid-feedback" v-if="!$v.form.chest.required">
                  Digite la Medida
                </div>
              </template>
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
                :class="{ 'is-invalid': $v.form.calf.$error }"
                :disabled="viewOnlly"
              />
              <template v-if="$v.form.calf.$error">
                <div class="invalid-feedback" v-if="!$v.form.calf.required">
                  Digite la Medida
                </div>
              </template>
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
                :class="{ 'is-invalid': $v.form.leg.$error }"
                :disabled="viewOnlly"
              />
              <template v-if="$v.form.leg.$error">
                <div class="invalid-feedback" v-if="!$v.form.leg.required">
                  Digite la Medida
                </div>
              </template>
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
                :class="{ 'is-invalid': $v.form.arm.$error }"
                :disabled="viewOnlly"
              />
              <template v-if="$v.form.arm.$error">
                <div class="invalid-feedback" v-if="!$v.form.arm.required">
                  Digite la Medida
                </div>
              </template>
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
                :class="{ 'is-invalid': $v.form.waist.$error }"
                :disabled="viewOnlly"
              />
              <template v-if="$v.form.waist.$error">
                <div class="invalid-feedback" v-if="!$v.form.waist.required">
                  Digite la Medida
                </div>
              </template>
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
                :class="{ 'is-invalid': $v.form.weight.$error }"
                :disabled="viewOnlly"
              />
              <template v-if="$v.form.weight.$error">
                <div class="invalid-feedback" v-if="!$v.form.weight.required">
                  Digite la Medida
                </div>
              </template>
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
                :class="{ 'is-invalid': $v.form.size.$error }"
                :disabled="viewOnlly"
              />
              <template v-if="$v.form.size.$error">
                <div class="invalid-feedback" v-if="!$v.form.size.required">
                  Digite la Medida
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
import { required, minLength, maxLength, between, integer, email } from 'vuelidate/lib/validators'
import EventBus from '../../bus'
export default {
  components: {
    DatePicker
  },
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
        user_id: '',
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
  validations() {
    let form = {
      form: {
        user_id: {
          required
        },
        back: {
          required
        },
        chest: {
          required
        },
        calf: {
          required
        },
        leg: {
          required
        },
        created_at: {
          required
        },
        arm: {
          required
        },
        waist: {
          required
        },
        weight: {
          required
        },
        size: {
          required
        }
      }
    }
    return form
  },
  computed: {
    users() {
      return this.$store.state.user.users
    },
    errors() {
      return this.$store.state.actions.errors
    }
  },
  methods: {
    hideModal() {
      this.form.id = ''
      this.form.user = ''
      //this.form.state = ''
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
            url: '/tracings',
            data: me.form,
            files: false,
            action: 'getTracing'
          }
          me.$store.dispatch('create', params)
          setTimeout(() => {
            if (Object.keys(me.errors).length >= 1) {
              //validation back
              me.sending = false
              return
            } else {
              me.sending = false
              //me.$store.dispatch('config/getTracing')
              me.hideModal()
            }
          }, 2000)
        } else {
          me.updating = true
          //actualizar
          let params = {
            url: `tracings/${me.form.id}`,
            data: me.form,
            action: 'config/getTracing'
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
  created() {
    EventBus.$on('show-modal-tracing-table', () => {
      this.$bvModal.show('modal-tracing-table')
      //this.$store.dispatch('getUsers')
      console.log(this.items)
    })
    EventBus.$on('show-modal-tracing', () => {
      this.$bvModal.show('modal-tracing')
      //this.$store.dispatch('getUsers')
    })
    //this.$store.dispatch('getTracing')
  },
  watch: {
    items(){
      //console.log('items')
      this.form.id = this.items.id
      this.form.user = this.items.user
      //this.form.state = this.items.state
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
  .form-modal-tracing {
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
