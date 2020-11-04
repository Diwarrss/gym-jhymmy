<template>
  <div>
    <b-modal
      ref="modal-payments"
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
          id="groupstate"
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
              Seleccione el usuario
            </div>
          </template>
        </b-form-group>
        <!-- fecha de pago -->
        <b-form-group
          id="groupname"
          label="Fecha de Inicio:"
          label-for="from_date">
          <b-form-datepicker id="from_date" v-model="form.from_date"></b-form-datepicker>
        </b-form-group>
          <!-- valor pagar -->
        <b-form-group
          id="groupname"
          label="Valor a Pagar:"
          label-for="value">
          <b-form-input
            id="value"
            v-model="form.value"
            :class="{ 'is-invalid': $v.form.value.$error }"
            :disabled="viewOnlly"
          />
          <template v-if="$v.form.value.$error">
            <div class="invalid-feedback" v-if="!$v.form.value.required">
              Digite Valor
            </div>
          </template>
        </b-form-group>
        <!-- estado -->
        <b-form-group
          v-if="event && viewOnlly"
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
        <div
          class="text-center">
          <b-button
            v-if="event && !viewOnlly"
            :disabled="sending"
            type="submit"
            variant="success">
            <span v-if="sending">
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
              Actualizando...
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
      show: true,
      sending: false,
      updating: false,
      states: [
        { "id" : "1", "name" : "Activo"},
        { "id" : "2", "name" : "Inactivo"}
      ],
      form: {
        id: '',
        user_id: '',
        to_date: '',
        from_date: '',
        state: '',
        value: ''
      },
    }
  },
  validations() {
    let form = {
      form: {
        user_id: {
          required
        },
        value: {
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
    users() {
      return this.$store.state.user.users
    }
  },
  methods: {
    hideModal() {
      this.form.id = ''
      this.form.user_id = ''
      this.form.to_date = ''
      this.form.from_date = ''
      this.form.state = ''
      this.form.value = ''
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
            url: 'payments',
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
              me.$store.dispatch('config/getPayment')
              me.hideModal()
            }
          }, 2000)
        } else {
          me.updating = true
          //actualizar
          let params = {
            url: `payments/${me.form.id}`,
            data: me.form,
            action: 'config/getPayment'
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
    EventBus.$on('show-modal-payment-table', () => {
      this.$bvModal.show('modal-payment-table')
      console.log(this.items)
    })
    EventBus.$on('show-modal-payment', () => {
      this.$bvModal.show('modal-payment')
    })
    this.$store.dispatch('getPayment')
},
watch: {
    items(){
      //console.log('items')
      this.form.id = this.items.id
      this.form.user_id = this.items.user_id
      this.form.to_date = this.items.to_date
      this.form.from_date = this.items.from_date
      this.form.state = this.items.state
      this.form.value = this.items.value
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
