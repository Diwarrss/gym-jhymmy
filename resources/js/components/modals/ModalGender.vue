<template>
  <div>
    <!-- Info modal -->
    <b-modal
      ref="modal-genders"
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
        <b-form-group
          id="groupname"
          label="Nombre:"
          label-for="name">
          <b-form-input
            id="name"
            v-model="form.name"
            :class="{ 'is-invalid': $v.form.name.$error || errors.name }"
            :disabled="viewOnlly"
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
          <template v-if="errors.name">
            <div class="invalid-feedback">
              {{ errors.name[0] }}
            </div>
          </template>
        </b-form-group>
        <b-form-group
          id="groupname"
          label="Iniciales:"
          label-for="initials">
          <b-form-input
            id="initials"
            v-model="form.initials"
            :class="{ 'is-invalid': $v.form.initials.$error || errors.initials }"
            :disabled="viewOnlly"
          />
          <template v-if="$v.form.initials.$error">
            <div class="invalid-feedback" v-if="!$v.form.initials.required">
              Digite las Iniciales
            </div>
            <div class="invalid-feedback" v-if="!$v.form.initials.maxLength">
              Exede los 5 Caracteres
            </div>
          </template>
          <template v-if="errors.initials">
            <div class="invalid-feedback">
              {{ errors.initials[0] }}
            </div>
          </template>
        </b-form-group>
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
      show: true,
      allRow: this.row,
      sending: false,
      updating: false,
      allData: this.items,
      form: {
        id: '',
        name: '',
        initials: '',
        state: null
      },
      states: [
        { "id": 1, "name": "Activo"},
        { "id": 0, "name": "Inactivo"}
      ],
    }
  },
  validations() {
    let form = {
      form: {
        name: {
          required,
          maxLength: maxLength(200)
        },
        initials: {
          required,
          maxLength: maxLength(5)
        },
        state: {
          required
        }
      }
    }
    return form
  },
  computed: {
    allGenders(){
      return this.$store.state.config.genders
    },
    row() {
      return this.$store.state.config.allRow
    },
    errors() {
      return this.$store.state.actions.errors
    }
  },
  created() {
    EventBus.$on('show-modal-gender-table', () => {
      this.$bvModal.show('modal-gender-table')
      //console.log(this.items)
    })
    EventBus.$on('show-modal-gender', () => {
      this.$bvModal.show('modal-gender')
    })
    //this.$store.dispatch('getGenders')
  },
  methods: {
    hideModal() {
      this.$bvModal.hide(this.modal)
      this.form.id = ''
      this.form.name = ''
      this.form.initials = ''
      this.form.state = ''
      this.$v.$reset()
      EventBus.$emit('clear-data-modal')
    },
    sendData(evt) {
      evt.preventDefault()
      let me = this
      me.form.name = me.form.name ? me.form.name.toUpperCase() : ''
      me.form.initials = me.form.initials ? me.form.initials.toUpperCase() : ''
      this.$v.$touch()
      if (this.$v.$invalid) {
        return
      } else {
        //Crear
        me.sending = true
        if (me.event) {
          let params = {
            url: '/genders',
            data: me.form,
            files: false,
            action: 'getGenders'
          }
          me.$store.dispatch('create', params)
          setTimeout(() => {
            if (Object.keys(me.errors).length >= 1) {
              //validation back
              me.sending = false
              return
            } else {
              me.sending = false
              //me.$store.dispatch('config/getGender')
              me.hideModal()
            }
          }, 2000)
        } else {
          me.updating = true
          //actualizar
          let params = {
            url: `/genders/${me.form.id}`,
            data: me.form,
            files: false,
            action: 'getGenders'
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
  watch: {
    items(){
      //console.log('items')
      this.form.id = this.items.id
      this.form.initials = this.items.initials
      this.form.name = this.items.name
      this.form.state = this.items.state
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

