<template>
  <div>
    <!-- Info modal -->
    <b-modal
      ref="modal-cancel"
      id="modal-cancel"
      no-close-on-esc
      no-close-on-backdrop

      hide-footer>
      <template v-slot:modal-title>
        <i
          class="fas fa-ban"/>
        Anular Registro
      </template>
      <b-form
        @submit="sendData"
        v-if="show">
          <b-form-group
            id="groupusers"
            label="Motivo de cancelación:"
            label-for="cancellation_reason_id"
            >
            <v-select
              id="cancellation_reason_id"
              v-model="form.cancellation_reason_id"
              :class="{ 'is-invalid': $v.form.cancellation_reason_id.$error}"
              :options="cancellationReasons"
              placeholder="Seleccionar..."
              :reduce="cancellationReasons => cancellationReasons.id"
              label="name"
              name="user"
            >
              <div slot="no-options">No hay Resultados!</div>
            </v-select>
            <template v-if="$v.form.cancellation_reason_id.$error">
              <div class="invalid-feedback" v-if="!$v.form.cancellation_reason_id.required">
                Seleccione Usuario
              </div>
            </template>
          </b-form-group>
          <b-form-group
            id="groupname"
            label="Observaciones:"
            label-for="description">
            <b-form-textarea
              id="description"
              v-model="form.description"
              :class="{ 'is-invalid': $v.form.description.$error}"
              rows="3"
              max-rows="6"
            />
            <template v-if="$v.form.description.$error">
              <div class="invalid-feedback" v-if="!$v.form.description.required">
                Observaciones
              </div>
              <div class="invalid-feedback" v-if="!$v.form.description.maxLength">
                Exede los 500 Caracteres
              </div>
            </template>
          </b-form-group>

        <div
          class="text-center">
          <b-button
            :disabled="sending"
            type="submit"
            variant="success">
            <span v-if="sending">
              <b-spinner small type="grow"></b-spinner>
                Anulando...
            </span>
            <span v-else>
              <i class="fas fa-save"/> Anular
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
    id: {
      type: Number,
      default: ()=> 0
    },
    tittleModal: {
      type: String,
      default: ()=> 'Titulo'
    }
  },
  data() {
    return {
      show: true,
      sending: false,
      form: {
        description: '',
        cancellation_reason_id: '',
        payment_id: ''
      }
    }
  },
  computed: {
    cancellationReasons(){
      return this.$store.state.config.cancellationReason
    }
  },
  validations() {
    let form = {
      form: {
        cancellation_reason_id: {
          required
        },
        description: {
          required,
          maxLength: maxLength(200)
        }
      }
    }
    return form
  },
  methods: {
    hideModal() {
      this.form.cancellation_reason_id = ''
      this.form.description = ''
      this.$bvModal.hide('modal-cancel')
      this.$v.$reset()
      EventBus.$emit('clear-data-modal')
    },
    sendData(evt) {
      evt.preventDefault()
      let me = this
      me.form.payment_id = me.id
      me.form.description = me.form.description ? me.form.description.toUpperCase() : ''
      this.$v.$touch()
      if (this.$v.$invalid) {
        return
      } else {
        me.sending = true
        let params = {
          url: `/cancel-payment/${me.id}`,
          data: me.form,
          files: false,
          action: 'getPayment'
        }
        me.$store.dispatch('cancelPayment', params)
        setTimeout(() => {
          me.sending = false
          /* me.$store.dispatch('config/getStates') */
          me.hideModal()
        }, 1000)
      }
    }
  },
  created() {
    EventBus.$on('show-modal-cancel', () => {
      this.$bvModal.show('modal-cancel')
    })
    this.$store.dispatch('getCancellationReason')
  },
  watch: {
    items(){
      this.form.id = this.items.id
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
