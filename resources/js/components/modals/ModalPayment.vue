<template>
  <div>
    <b-modal
      ref="modal-payments"
      id="modal-payments"
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
          id="groupstate"
          label="Usuario:"
          label-for="user"
          >
          <v-select
            id="user"
            v-model="form.user_id"
            :options="users"
            placeholder="Seleccionar..."
            :reduce="users => users.id"
            label="name"
            name="user"
          >
            <div slot="no-options">No hay Resultados!</div>
          </v-select>
        </b-form-group>
        <!-- fecha de pago -->
        <b-form-group
          id="groupname"
          label="Fecha de Inicio:"
          label-for="from_date">
        <template>
          <date-pick v-model="form.from_date"></date-pick>
        </template>
        </b-form-group>
          <!-- valor pagar -->
        <b-form-group
          id="groupname"
          label="Valor a Pagar:"
          label-for="payment">
          <b-form-input
            id="payment"
            v-model="form.payment"
            autofocus
          />
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
          <b-button
            v-if="event && !viewOnlly"
            :disabled="sending"
            @click="sendData()"
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
            @click="sendData()"
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
import EventBus from '../../bus'
import DatePick from 'vue-date-pick';
import 'vue-date-pick/dist/vueDatePick.css';
export default {
  components: {
    DatePick
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
  computed: {
    users() {
      return this.$store.state.user.users
    }
  },
  methods: {
    hideModal() {
      this.$bvModal.hide('modal-payments')
    }
  },
  created() {
    EventBus.$on('show-modal-payment', () => {
      this.$bvModal.show('modal-payments')
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
    .vdpComponent.vdpWithInput>input {
      height: 46px;
      width: 100%;
      border-radius: 5px;
      border: 1px solid #cac7c7;
      font-size: 16px;
      padding-left: 10px;
      color: black;
    }
    .vdpComponent {
      width: 100%;
    }
  }

</style>
