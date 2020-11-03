 <template>
  <div>
    <!-- Info modal -->
    <b-modal
      ref="modal-cancellationReason"
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
        v-if="show">
        <b-form-group
          id="groupname"
          label="Nombre:"
          label-for="name">
          <b-form-input
            id="name"
            v-model="form.name"
            :disabled="viewOnlly"
            autofocus
          />
        </b-form-group>
        <b-form-group
          id="groupstate"
          label="Estado:"
          label-for="state"
          >
          <b-form-select
            id="state"
            :disabled="viewOnlly"
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
            @click="sendData()"
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
      show: true,
      allRow: this.row,
      sending: false,
      updating: false,
      form: {
        id: '',
        name: '',
        state: ''
      },
      states: [
        { "id": 1, "name": "Activo"},
        { "id": 2, "name": "Inactivo"}
      ],

    }
  },
  computed: {
    allCancellationReason(){
      return this.$store.state.config.cancellationReason
    }
  },
  methods: {
    hideModal() {
      this.form.id = ''
      this.form.name = ''
      this.form.state = ''
      this.$bvModal.hide(this.modal)
      EventBus.$emit('clear-data-modal')
    }
  },
  watch: {
    items(){
      //console.log('items')
      this.form.id = this.items.id
      this.form.name = this.items.name
      this.form.state = this.items.state
    }
  },
  created() {
    EventBus.$on('show-modal-cancellationReason-table', () => {
      this.$bvModal.show('modal-cancellationReason-table')
      console.log(this.items)
    })
    EventBus.$on('show-modal-cancellationReason', () => {
      this.$bvModal.show('modal-cancellationReason')
    })
    this.$store.dispatch('getCancellationReason')
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
