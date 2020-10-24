<template>
  <div class="p-4 medidas_custom">
    <b-card>
      <!-- <div>
        <b-button
          variant="primary"><i class="fas fa-plus-circle"/> Nuevo</b-button>
        <b-button
          v-permission="'export_dependence'"
          variant="success"><i class="fas fa-file-csv"/> Exportar</b-button>
      </div> -->
      <div>
        <button class="btn btn-primary mb-3" @click="newMedidas()">Nueva Medida</button>
      </div>
      <div class="mt-2 pt-3 body_medidas">
        <template>
          <div class="container-fluid overflow-auto">
            <b-row>
              <!-- sector de filtrar -->
              <b-col
                lg="4"
                class="my-1">
                <b-form-group
                  label="Filtrar:"
                  label-cols-sm="3"
                  label-align-sm="right"
                  label-size="mb"
                  label-for="filterInput"
                  class="mb-0"
                >
                  <b-input-group size="mb">
                    <b-form-input
                      id="filterInput"
                      v-model="filter"
                      type="search"
                      placeholder="Buscar..."
                    />
                    <b-input-group-append>
                      <b-button
                        variant="info"
                        :disabled="!filter"
                        @click="filter = ''">Limpiar</b-button>
                    </b-input-group-append>
                  </b-input-group>
                </b-form-group>
              </b-col>
              <!-- Perpage -->
              <!-- <b-col
                lg="4"
                class="my-1">
                <b-form-group
                  label="Por página"
                  label-cols-sm="3"
                  label-align-sm="right"
                  label-size="mb"
                  label-for="perPageSelect"
                  class="mb-0"
                >
                  <b-form-select
                    id="perPageSelect"
                    v-model="perPage"
                    :options="pageOptions"
                    class="select_custom"
                    size="mb"/>
                </b-form-group>
              </b-col> -->
            </b-row>
            <!-- Pintar Tabla -->
            <b-table
              id="table-dependence"
              :fields="fields"
              :items="items"
              :filter="filter"
              :current-page="currentPage"
              :sort-by.sync="sortBy"
              :sort-desc.sync="sortDesc"
              class="mt-3 table_custom"
              striped
              small
              responsive
              @filtered="onFiltered">
              <!-- se pinta el componente para el slot acciones -->
              <template v-slot:cell(acciones)="row">
                <b-button
                  variant="primary"
                  @click="modalEdit(row.item, row.index, $event.target, true)"><i class="fas fa-eye mr-md-1"/><span class="d-none d-md-inline-block">Ver</span></b-button>
                <b-button
                  variant="warning"
                  @click="modalEdit(row.item, row.index, $event.target, false)"><i class="fas fa-edit mr-md-1"/><span class="d-none d-md-inline-block">Editar</span></b-button>
                <b-button
                  v-if="row.item.isActive"
                  variant="danger"
                  @click="status(row.item.id, 'disable')"><i class="fas fa-times-circle mr-md-1"/><span class="d-none d-md-inline-block">Inactivar</span></b-button>
                <b-button
                  v-if="!row.item.isActive"
                  variant="success"
                  @click="status(row.item.id, 'enable')"><i class="fas fa-check-circle mr-md-1"/><span class="d-none d-md-inline-block">Activar</span></b-button>
              </template>
              <template v-slot:cell(state)="data">
                <h5 v-if="data.item.isActive">
                  <b-badge
                    variant="success">{{ data.item.isActive ? 'Activo' : 'Inactivo' }} </b-badge>
                </h5>
                <h5 v-else>
                  <b-badge
                    variant="danger">{{ data.item.isActive ? 'Activo' : 'Inactivo' }} </b-badge>
                </h5>
              </template>
            </b-table>
            <!-- Info Paginacion -->
            <b-pagination
              class="mt-4"
              v-model="currentPage"
              :total-rows="rows"
              :per-page="perPage"
              aria-controls="table-dependence"
            />
          </div>
        </template>
      </div>
    </b-card>
    <b-modal
      size="lg"
      ref="modal-medidas"
      id="modal-medidas"
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
        <b-row >
          <b-col cols="md-6">
          <b-form-group
            id="groupstate"
            label="Usuario:"
            label-for="user"
            >
            <b-form-select
              id="user"
              v-model="form.user"
            >
              <b-form-select-option :value="null" disabled>Seleccionar...</b-form-select-option>
                <b-form-select-option
                  v-for="(item, index) in users"
                  :key="index"
                  :value="item.id"
                >{{ item.name }}
              </b-form-select-option>
            </b-form-select>
          </b-form-group>
          </b-col>
          <!-- estado -->
          <b-col cols="md-6">
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
                autofocus
              />
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
                autofocus
              />
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
                autofocus
              />
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
                autofocus
              />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <!-- Adbdomen -->
            <b-form-group
              id="groupname"
              label="Abdomen:"
              label-for="abdomen">
              <b-form-input
                id="abdomen"
                v-model="form.abdomen"
                autofocus
              />
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
                autofocus
              />
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
                autofocus
              />
            </b-form-group>
          </b-col>
          <b-col cols="4">
            <!-- Peso -->
            <b-form-group
              id="groupname"
              label="Peso:"
              label-for="weigth">
              <b-form-input
                id="weigth"
                v-model="form.weigth"
                autofocus
              />
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
                autofocus
              />
            </b-form-group>
          </b-col>
        </b-row>
        <div
          class="text-center">
          <button class="btn btn-primary" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
          </button>
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
export default {
  data() {
    return {
      // Note `isActive` is left out and will not appear in the rendered table
      show: true,
      sending: false,
      updating: false,
      event: '',
      viewOnlly: false,
      tittleModal : '',
      rows: 4,
      sortBy: 'first_name',
      sortDesc: false,
      filter: null,
      pageOptions: [10, 20, 30],
      perPage: 10,
      currentPage: 1,
      form: {
        user: '',
        state:'',
        back: '',
        calf: '',
        leg: '',
        abdomen: '',
        arm: '',
        waist: '',
        weigth: '',
        size: ''
      },
      fields: [
        {
          key: 'first_name',
          label: 'Nombre',
          sortable: true
        },
        {
          key: 'last_name',
          label: 'Apellido',
          sortable: true
        },
        {
          key: 'age',
          label: 'Edad',
          sortable: true
        },
        {
          key: 'isActive',
          label: 'Estado',
          sortable: true,
          formatter: value => {
            return value ? 'Activo' : 'Inactivo'
          }
        },
        {
          key: 'acciones',
          label: 'Acciones',
          visible: false,
          sortable: false
        }
      ],
      items: [
        { isActive: true, age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
        { isActive: false, age: 21, first_name: 'Larsen', last_name: 'Shaw' },
        { isActive: false, age: 89, first_name: 'Geneva', last_name: 'Wilson' },
        { isActive: true, age: 38, first_name: 'Jami', last_name: 'Carney' }
      ]
    }
  },
  computed: {
    monitoring(){
      return this.$store.state.administration.monitoring
    }
  },
  created() {
    this.$store.dispatch('getMonitoring')
  },
  methods: {
    count(){
      this.$store.dispatch('count')
    },
    onFiltered(filteredItems) {
      // actualiza la paginacion cuando se usa el filtro
      this.rows = filteredItems.length
      this.currentPage = 1
    },
    hideModal() {
      this.$refs['modal-medidas'].hide()
      setTimeout(() => {
        //this.$v.$reset()
        this.viewOnlly = false
        this.updating = false
        this.sending = false
        this.form = {
          user: null,
          back: null,
        }
        //this.$store.dispatch('api/clearErrors') //clean errors of back
      }, 500)
    },
    newMedidas(view) {
      this.form.user = null
      this.form.state = null
      this.form.back = null
      this.form.calf = null
      this.form.leg = null
      this.form.abdomen = null
      this.form.arm = null
      this.form.waist = null
      this.form.weigth = null
      this.form.size = null
      this.tittleModal = 'Nuevo Registro'
      this.event = 1
      this.sending = false
      this.updating = false
      this.$refs['modal-medidas'].show()
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
      this.form.user = item.user
      this.form.state = item.state
      this.form.back = item.back
      this.form.calf = item.calf
      this.form.leg = item.leg
      this.form.abdomen = item.abdomen
      this.form.arm = item.arm
      this.form.waist = item.waist
      this.form.weigth = item.weigth
      this.form.size = item.size
      this.event = 0
      this.sending = false
      this.updating = false
      this.$refs['modal-medidas'].show()
    },
  },

}
</script>
<style lang="scss">
  .medidas_custom {
    .card-header {
      h1{
        margin-bottom: 0px;
        font-size: 18px;
      }
    }
    .body_medidas {
      border-top: 1px solid #d0c9c9;
    }
    .table_custom {
      th {
        font-size: 16px;
        font-weight: 700;
      }
    }
  }
</style>
