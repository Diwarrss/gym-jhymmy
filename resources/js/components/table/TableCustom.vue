<template>
  <div>
    <b-row>
      <!-- sector de filtrar -->
      <b-col
        v-if="showFilter"
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
        lg="5"
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
      id="table-custom"
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
          v-if="butonView"
          variant="primary"
          @click="modalEdit(row.item, row.index, $event.target, true)"><i class="fas fa-eye mr-md-1"/><span class="d-none d-md-inline-block">Ver</span></b-button>
        <b-button
          v-if="butonEdit"
          variant="warning"
          @click="modalEdit(row.item, row.index, $event.target, false)"><i class="fas fa-edit mr-md-1"/><span class="d-none d-md-inline-block">Editar</span></b-button>
        <b-button
          v-if="row.item.state == 1 && !cancelState && statusState"
          variant="danger"
          @click="status(row.item.id, 'disable')"><i class="fas fa-times-circle mr-md-1"/><span class="d-none d-md-inline-block">Inactivar</span></b-button>
        <b-button
          v-if="row.item.state == 0 && !cancelState && statusState"
          variant="success"
          @click="status(row.item.id, 'enable')"><i class="fas fa-check-circle mr-md-1"/><span class="d-none d-md-inline-block">Activar</span></b-button>
        <b-button
          v-if="cancelState"
          variant="danger"
          @click="cancelItem(row.item.id)"><i class="fas fa-check-circle mr-md-1"/><span class="d-none d-md-inline-block">Anular</span></b-button>
      </template>
      <template #empty="scope">
        <h4 class="text-center text-primary"><b-spinner variant="primary" label="Spinning"></b-spinner> Sin Resultados</h4>
      </template>
      <template v-slot:cell(state)="data">
        <h5 v-if="data.item.state">
          <b-badge
            variant="success">Activo</b-badge>
        </h5>
        <h5 v-else>
          <b-badge
            variant="danger">Inactivo</b-badge>
        </h5>
      </template>
      <template v-slot:cell(state.name)="data">
        <h5 v-if="data.item.state_id == 1">
          <b-badge
            variant="success">Activo</b-badge>
        </h5>
        <h5 v-else-if="data.item.state_id == 2">
          <b-badge
            variant="danger">Inactivo</b-badge>
        </h5>
        <h5 v-else>
          <b-badge
            variant="info">{{ data.item.state.name }}</b-badge>
        </h5>
      </template>
    </b-table>
    <!-- Info Paginacion -->
    <b-pagination
      v-model="currentPage"
      :total-rows="rows"
      :per-page="perPage"
      aria-controls="table-custom"
    />
    <ModalGenderTable v-if="typePage=='gender'" :viewOnlly="viewOnlly" :event="false" :tittleModal="tittleModal" :items="dataModal" modal="modal-gender-table"/>
    <ModalUserTable v-if="typePage=='user'" :viewOnlly="viewOnlly" :event="false" :tittleModal="tittleModal" :items="dataModal" modal="modal-users-table"/>
    <ModalTracingTable v-if="typePage=='tracing'" :viewOnlly="viewOnlly" :event="false" :tittleModal="tittleModal" :items="dataModal" modal="modal-tracing-table"/>
    <ModalStateTable v-if="typePage=='state'" :viewOnlly="viewOnlly" :event="false" :tittleModal="tittleModal" :items="dataModal" modal="modal-state-table"/>
    <ModalPaymentTable v-if="typePage=='payment'" :viewOnlly="viewOnlly" :event="false" :tittleModal="tittleModal" :items="dataModal" modal="modal-payment-table"/>
    <ModalCancellationReasonTable v-if="typePage=='cancellationReason'" :viewOnlly="viewOnlly" :event="false" :tittleModal="tittleModal" :items="dataModal" modal="modal-cancellationReason-table"/>
    <ModalAccessControlTable v-if="typePage=='access'" :viewOnlly="viewOnlly" :event="false" :tittleModal="tittleModal" :items="dataModal" modal="modal-access-table"/>
    <ModalCancel :tittleModal="tittleModal" :id="data_id" />
  </div>
</template>
<script>
import ModalGenderTable from '../modals/ModalGender'
import ModalUserTable from '../modals/ModalUser'
import ModalTracingTable from '../modals/ModalTracing'
import ModalStateTable from '../modals/ModalState'
import ModalPaymentTable from '../modals/ModalPayment'
import ModalCancellationReasonTable from '../modals/ModalCancellationReason'
import ModalAccessControlTable from '../modals/ModalAccessControl'
import ModalCancel from '../modals/ModalCancel'
import EventBus from '../../bus'
export default {
  components: {
    ModalGenderTable,
    ModalUserTable,
    ModalTracingTable,
    ModalStateTable,
    ModalPaymentTable,
    ModalCancellationReasonTable,
    ModalAccessControlTable,
    ModalCancel
  },
  props: {
    cancelState: {
      type: Boolean,
      default: false
    },
    typePage: {
      type: String,
      default: () => ''
    },
    statusState: {
      type: Boolean,
      default: () => true
    },
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

    },
    showFilter: {
      type: Boolean,
      default: () => true
    },
    perPagination: {
      type: Boolean,
      default: () => true
    },
    butonEdit: {
      type: Boolean,
      default: true
    },
    butonView: {
      type: Boolean,
      default: true
    }
  },
  data() {
    return {
      allData: [],
      filter: null,
      currentPage: 1,
      pageOptions: [10, 20, 30],
      sortDesc: false,
      viewOnlly: null,
      tittleModal: null,
      dataModal: {},
      data_id: 0
    }
  },
  methods: {
    onFiltered(filteredItems) {
      // actualiza la paginacion cuando se usa el filtro
      this.rows = filteredItems.length
      this.currentPage = 1
    },
    cancelItem(id) {
      let me = this
      me.data_id = id
      EventBus.$emit('show-modal-cancel')
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
    modalEdit(item, index, button, view) {
      if (view) {
        this.tittleModal = 'Ver ' + item.name
        this.viewOnlly = true
      } else {
        this.viewOnlly = false
        this.tittleModal = 'Editar ' + item.name
      }
      //this.$refs['modal-genders'].show()
      if (this.typePage == 'gender') {
        //this.modal = 'modal-gender-table'
        this.dataModal = item
        //console.log(this.dataModal)
        EventBus.$emit('show-modal-gender-table')
      }else if (this.typePage == 'user'){
        console.log(item)
        this.dataModal = item
        //console.log(this.dataModal)
        EventBus.$emit('show-modal-user-table')
      }else if (this.typePage == 'tracing'){
        this.dataModal = item
        //console.log(this.dataModal)
        EventBus.$emit('show-modal-tracing-table')
      }else if (this.typePage == 'state'){
        this.dataModal = item
        //console.log(this.dataModal)
        EventBus.$emit('show-modal-state-table')
      }else if (this.typePage == 'payment'){
        this.dataModal = item
        //console.log(this.dataModal)
        EventBus.$emit('show-modal-payment-table')
      }else if (this.typePage == 'cancellationReason'){
        this.dataModal = item
        //console.log(this.dataModal)
        EventBus.$emit('show-modal-cancellationReason-table')
      }else if (this.typePage == 'access'){
        this.dataModal = item
        //console.log(this.dataModal)
        EventBus.$emit('show-modal-access-table')
      }
    },
    status(id, type) {
      let me = this
      let actionDispatch = ''
      let urlDispatch = ''
      if (me.typePage == 'gender') {
        actionDispatch = 'getGenders'
        urlDispatch = `/genders-state/${id}`
      }else if (me.typePage == 'user'){
        actionDispatch = 'getUsers'
        urlDispatch = `/users-state/${id}`
      }else if (me.typePage == 'tracing'){
        actionDispatch = 'getTracing'
        urlDispatch = `/tracings-state/${id}`
      }else if (me.typePage == 'state'){
        actionDispatch = 'getStates'
        urlDispatch = `/states-state/${id}`
      }else if (me.typePage == 'payment'){
        actionDispatch = 'getPayment'
        urlDispatch = `/payments-state/${id}`
      }else if (me.typePage == 'cancellationReason'){
        actionDispatch = 'getCancellationReason'
        urlDispatch = `/cancellation-reasons-state/${id}`
      }else if (me.typePage == 'access'){
        actionDispatch = 'getAccessControl'
        urlDispatch = `/access-cancel/${id}`
      }
      try {
        Vue.swal({
          title: '¿Estás seguro?',
          text: '¡No podrás revertir esto!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#4dbd74',
          cancelButtonColor: '#d33',
          confirmButtonText:
            type == 'disable'
              ? '<i class="far fa-check-circle"></i> Si, Inactivar!'
              : '<i class="far fa-check-circle"></i> Si, Activar!',
          cancelButtonText: '<i class="far fa-times-circle"></i> Cancelar'
        }).then(result => {
          if (result.value) {
            //Inactivar
            if (id) {
              let params = {
                url: urlDispatch,
                action: actionDispatch
              }
              me.$store.dispatch('status', params)
            }
          }
        })
      } catch (error) {
        console.log(error)
      }
    },
  },
  watch: {
    items() {
      this.allData = this.items
    },
  },
  created() {
    EventBus.$on('clear-data-modal', () => {
      this.dataModal = {}
    })
  },
}
</script>
