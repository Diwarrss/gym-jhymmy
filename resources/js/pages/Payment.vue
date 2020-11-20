<template>
  <div class="p-4 payments_component">
    <div class="card">
      <div class="card-header">
        <h1>Pagos</h1>
      </div>
      <div class="card-body">
        <div>
          <button class="btn btn-primary mb-3" @click="newPay()">Nuevo Pago</button>
        </div>
        <div class="body_table pt-3">
          <TableCustom
          type-page="payment"
            :fields="fields"
            :items="payments"
            :rows="allRow"
            :per-page="10"
            :cancel-state="true"
            />
        </div>
      </div>
    </div>
    <ModalPayment :viewOnlly="false" :event="true" tittleModal="Nuevo Registro" :modal="modal"/>
  </div>
</template>
<script>
import TableCustom from '../components/table/TableCustom'
import ModalPayment from '../components/modals/ModalPayment'
import EventBus from '../bus'
import moment from "moment"
moment.locale("es")
export default {
  components: {
    TableCustom,
    ModalPayment
  },
  data() {
    return {
      allRow: this.row,
      modal: 'modal-payment',
      event: null,
      viewOnlly: false,
      tittleModal : '',
      form: {
        id: '',
        user_id: '',
        from_date: '',
        state: ''
      },
      fields: [
        {
          key: 'id',
          label: 'ID'
        },
        {
          key: 'user_cli.name',
          label: 'Nombre',
          sortable: true
        },
        {
          key: 'value',
          label: 'Valor',
          sortable: true
        },
        {
          key: 'created_at',
          label: 'Fecha de Pago',
          sortable: true,
          formatter: value => {
            return moment(value).format("YYYY-MM-DD")
          }
        },
        {
          key: 'acciones',
          label: 'Acciones',
          visible: false,
          sortable: false
        }
      ],
    }
  },
  computed: {
    payments(){
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
    hideModal() {
      this.$refs['modal-payments'].hide()
      setTimeout(() => {
        //this.$v.$reset()
        this.viewOnlly = false
        this.updating = false
        this.sending = false
        this.form = {
          id: null,
          user_id: null,
          date: null,
          create_ad: null,
          state: null
        }
        //this.$store.dispatch('api/clearErrors') //clean errors of back
      }, 500)
    },
    newPay(view) {
      EventBus.$emit('show-modal-payment')
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
      this.form.user_id = item.user_id
      this.form.from_date = item.created_ad
      this.form.state = item.state
      this.event = 0
      this.sending = false
      this.updating = false
      this.$refs['modal-payments'].show()
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
  .payments_component {
    .body_table {
      border-top: 1px solid #cec6c6;
    }
  }
  .modal-header {
    border-bottom: 1px solid #cac4c4;
    h5 {
      font-size: 18px;
    }
  }
  .modal-backdrop {
    background-color: #0000001c;
  }
</style>
