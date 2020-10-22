<template>
  <div class="p-4 state_component">
    <div class="card">
      <div class="card-header">
        <h1>Componente de Estados</h1>
      </div>
      <div class="card-body">
        <div>
          <button class="btn btn-primary mb-3" @click="newState" data-toggle="modal" data-target="#exampleModal">Nuevo</button>
        </div>
        <div class="body_table pt-3">
          <TableCustom
            :fields="fields"
            :items="allStates"
            :rows="allRow"
            :per-page="10"/>
        </div>
      </div>
    </div>
    <!-- modal bootstrap -->
    <div class="modal fade" id="exampleModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3 v-if="!viewOnlly && event" class="modal-title" id="exampleModalLabel"><i class="fas fa-plus-circle"/> {{ tittleModal }}</h3>
            <h3 v-else-if="!viewOnlly && !event" class="modal-title" id="exampleModalLabel"><i class="fas fa-edit"/> {{ tittleModal }}</h3>
            <h3 v-else class="modal-title" id="exampleModalLabel"><i class="fas fa-plus-circle"/><i class="fas fa-eye"/> {{ tittleModal }}</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <b-form
              v-if="show">
              <b-form-group
                id="groupname"
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
            </b-form>
          </div>
          <div class="modal-footer">
            <div
              v-if="!viewOnlly"
              class="text-center">
              <b-button
                v-if="event"
                @click="sendData"
                :disabled="sending"
                variant="success"
                data-dismiss="modal">
                <span v-if="sending">
                  <b-spinner small label="Spinning"/> Guardando...
                </span>
                <span v-else>
                  <i class="fas fa-save"/> Guardar
                </span>
              </b-button>
              <b-button
                v-else
                @click="sendData"
                :disabled="updating"
                variant="success"
                data-dismiss="modal">
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
              <button id="close" type="button" class="btn btn-danger" @click="hideModal()" data-dismiss="modal">Cancelar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
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
      show: true,
      allRow: this.row,
      form: {
        id: '',
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
      updating: false,
      event: '',
      viewOnlly: false,
      tittleModal : ''
    }
  },
  computed: {
    allStates(){
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
    sendData(){
      console.log('guardando')
    },
    hideModal() {
      setTimeout(() => {
        //this.$v.$reset()
        this.viewOnlly = false
        this.updating = false
        this.sending = false
        this.form = {
          id: null,
          name: null,
          state: null
        }
        //this.$store.dispatch('api/clearErrors') //clean errors of back
      }, 500)
    },
    newState(view) {
      this.form.id = null
      this.form.name = null
      this.form.state = null
      this.tittleModal = 'Nuevo Registro'
      this.event = 1
      this.sending = false
      this.updating = false
    },
    modalEdit(item, index, button, view) {
      if (view) {
        this.tittleModal = 'Ver ' + item.names
        this.viewOnlly = true
      } else {
        this.viewOnlly = false
        this.tittleModal = 'Editar ' + item.names
      }
      //this.$store.dispatch('api/clearErrors') //clean errors of back
      //this.$store.dispatch('config/getGender')
      //this.$store.dispatch('config/getTypeIdentification')
      this.form.id = item.id
      this.form.identification = item.identification
      this.form.names = item.names
      this.form.telephone = item.telephone
      this.form.address = item.address
      this.form.state = item.state
      this.form.type = item.type
      this.form.dependence_id = item.dependence_id
      this.form.type_identification_id = item.type_identification_id
      this.form.gender_id = item.gender_id
      this.event = 0
      this.sending = false
      this.updating = false
      this.$refs['modal-dependence'].show()
    },
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
