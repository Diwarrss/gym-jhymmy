<template>
  <div class="p-4 medidas_custom">
    <b-card>
      <div>
        <b-button
          variant="primary"><i class="fas fa-plus-circle"/> Nuevo Pago</b-button>
        <!-- <b-button
          v-permission="'export_dependence'"
          variant="success"><i class="fas fa-file-csv"/> Exportar</b-button> -->
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
               <!--  <b-button
                  v-if="row.item.isActive"
                  variant="danger"
                  @click="status(row.item.id, 'disable')"><i class="fas fa-times-circle mr-md-1"/><span class="d-none d-md-inline-block">Inactivar</span></b-button>
                <b-button
                  v-if="!row.item.isActive"
                  variant="success"
                  @click="status(row.item.id, 'enable')"><i class="fas fa-check-circle mr-md-1"/><span class="d-none d-md-inline-block">Activar</span></b-button>
               --></template>
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
  </div>
</template>
<script>
export default {
  data() {
    return {
      // Note `isActive` is left out and will not appear in the rendered table
      rows: 4,
      sortBy: 'first_name',
      sortDesc: false,
      filter: null,
      pageOptions: [10, 20, 30],
      perPage: 10,
      currentPage: 1,
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
          key: 'date',
          label: 'Fecha de Pago',
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
        { isActive: true, date: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
        { isActive: false, date: 21, first_name: 'Larsen', last_name: 'Shaw' },
        { isActive: false, date: 89, first_name: 'Geneva', last_name: 'Wilson' },
        { isActive: true, date: 38, first_name: 'Jami', last_name: 'Carney' }
      ]
    }
  },
  computed: {
    payment(){
      return this.$store.state.administration.payment
    }
  },
  created() {
    this.$store.dispatch('getPayment')
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
