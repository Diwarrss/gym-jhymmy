<template>
  <div class="p-4 state_component">
    <div class="card">
      <div class="card-header">
        <h1>Componente de Estados</h1>
      </div>
      <div class="card-body">
        <div>
          <button class="btn btn-primary mb-3" @click="count">Nuevo</button>
        </div>
        <div class="body_table pt-3">
          <TableCustom
            :fields="fields"
            :items="states"
            :rows="allRow"
            :per-page="10"/>
        </div>
      </div>
    </div>
    <!-- NEW MODAL -->
    <b-modal
        no-close-on-esc
        no-close-on-backdrop
        ref="modal-contextType"
        :id="form.modal"
        :title="``"
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
          v-if="show"
          @submit="sendData">
          <b-form-group
            id="groupname"
            class="col-md-6"
            label="Nombre:"
            label-for="name">
            <b-form-input
              id="name"
              v-model="form.name"
              autofocus
            />
            <!-- <template v-if="$v.form.name.$error">
              :class="{'is-invalid': $v.form.name.$error}"
              <div
                v-if="!$v.form.name.required"
                class="invalid-feedback">
                Digite el Número de nameo
              </div>
              <div
                v-if="!$v.form.name.maxLength"
                class="invalid-feedback">
                Exede los 15 Caracteres
              </div>
            </template> -->
          </b-form-group>
          <b-form-group
            id="groupstate"
            class="col-md-6"
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
            v-if="!viewOnlly"
            class="text-center">
            <b-button
              v-if="event"
              type="submit"
              :disabled="sending"
              variant="success">
              <span v-if="sending">
                <b-spinner small label="Spinning"/> Guardando...
              </span>
              <span v-else>
                <i class="fas fa-save"/> Guardar
              </span>
            </b-button>
            <b-button
              v-else
              type="submit"
              :disabled="updating"
              variant="success">
              <span v-if="updating">
                <b-spinner small label="Spinning"/> Actualizando...
              </span>
              <span v-else>
                <i class="fas fa-save"/> Actualizar
              </span>
            </b-button>
            <!-- <b-button
              v-else
              type="submit"
              variant="success"><i class="fas fa-sync-alt"/> Actualizar</b-button> -->
            <b-button
              variant="danger"
              @click="hideModal"><i class="fas fa-times-circle"/> Cancelar</b-button>
          </div>
        </b-form>
    </b-modal>
  </div>
</template>
<script>
import TableCustom from '../components/table/TableCustom'
export default {
  components: {
    TableCustom
  },
  data() {
    return {
      allRow: this.row,
      form: {
        name: '',
        state: ''
      },
      states: [
        { "id": 1, "name": "Activo"},
        { "id": 2, "name": "Inactivo"}
      ],
      fields: [
        {
          key: 'id',
          label: 'ID'
        },
        {
          key: 'name',
          label: 'Nombre'
        },
        {
          key: 'acciones',
          label: 'Acciones'
        }
      ],
      sending: false,
      event: '',
      viewOnlly: false
    }
  },
  computed: {
    states(){
      return this.$store.state.config.states
    },
    row() {
      return this.$store.state.config.allRow
    }
  },
  created() {
    this.$store.dispatch('getStates')
  },
  methods: {
    count(){
      this.$store.dispatch('count')
    },
    sendData(){
      console.log('guardando')
    }
  },
  watch: {
    row() {
      this.allRow = this.row
    }
  },
}
</script>
<style lang="scss">
  .state_component {
    .body_table {
      border-top: 1px solid #cec6c6;
    }
  }
</style>
