<template>
  <div>
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
      <b-col
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
      </b-col>
    </b-row>
    <!-- Pintar Tabla -->
    <b-table
      show-empty
      id="table-dependence"
      :fields="fields"
      :items="allData"
      :per-page="perPage"
      :filter="filter"
      :current-page="currentPage"
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      class="mt-2"
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
          v-if="row.item.status == 1"
          variant="danger"
          @click="status(row.item.id, 'disable')"><i class="fas fa-times-circle mr-md-1"/><span class="d-none d-md-inline-block">Inactivar</span></b-button>
        <b-button
          v-if="row.item.status == 0"
          variant="success"
          @click="status(row.item.id, 'enable')"><i class="fas fa-check-circle mr-md-1"/><span class="d-none d-md-inline-block">Activar</span></b-button>
      </template>
      <template #empty="scope">
        <h4 class="text-center text-primary"><b-spinner variant="primary" label="Spinning"></b-spinner> Cargando</h4>
      </template>
      <!-- <template v-slot:cell(state)="data">
        <h5 v-if="data.item.status">
          <b-badge
            variant="success">{{ data.item.status ? 'Activo' : 'Inactivo' }} </b-badge>
        </h5>
        <h5 v-else>
          <b-badge
            variant="danger">{{ data.item.status ? 'Activo' : 'Inactivo' }} </b-badge>
        </h5>
      </template> -->
    </b-table>
    <!-- Info Paginacion -->
    <b-pagination
      v-model="currentPage"
      :total-rows="rows"
      :per-page="perPage"
      aria-controls="table-dependence"
      @change="getData"
    />
    <!-- <b-pagination-nav
      :link-gen="linkGen"
      :number-of-pages="data.last_page"
      use-router
      @change="getData">
    </b-pagination-nav> -->
  </div>
</template>
<script>
export default {
  props: {
    items: {
      type: Array,
      default: ()=> [
        { isActive: true, age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
        { isActive: false, age: 21, first_name: 'Larsen', last_name: 'Shaw' },
        { isActive: false, age: 89, first_name: 'Geneva', last_name: 'Wilson' },
        { isActive: true, age: 38, first_name: 'Jami', last_name: 'Carney' }
      ]
    },
    fields: {
      type: Array,
      default: ()=> ['first_name', 'last_name', 'age']
    },
    rows: {
      type: Number,
      default: ()=> 0
    },
    sortBy: {
      type: String,
      default: ()=> 'first_name'
    },
    perPage: {
      type: Number,
      default: ()=> 15
    },
    url: {
      type: String,
      default: ()=> ''
    },
    data: {

    }
  },
  data() {
    return {
      allData: [],
      filter: null,
      currentPage: 1,
      pageOptions: [10, 20, 30],
      sortDesc: false
    }
  },
  methods: {
    onFiltered(filteredItems) {
      // actualiza la paginacion cuando se usa el filtro
      this.rows = filteredItems.length
      this.currentPage = 1
    },
    getData() {
      let me = this
      me.allData = []
      setTimeout(() => {
        this.$axios.get(me.url +'?page=' + this.currentPage)
        .then(res => {
          me.allData = res.data.data.data
          console.log(res);
        })
        //console.log('cambio de pagina', this.currentPage)
      }, 100);
    },
    /* linkGen(pageNum) {
      return pageNum === 1 ? '?' : `?page=${pageNum}`
    } */
  },
  watch: {
    items() {
      this.allData = this.items
    },
  },

}
</script>
