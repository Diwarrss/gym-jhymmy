<template>
  <div class="p-4 tracing_component">
    <div class="card">
      <div class="card-header">
        <h2 class="mb-0">Seguimientos</h2>
      </div>
      <div class="card-body">
        <b-row>
          <b-col>
            <b-form>
              <b-form-group
                v-if="rol_id == 1"
                id="group1"
                label-cols-md="3"
                label="Seleccionar cliente:"
                label-for="user_id"
                size="sm"
              >
                <v-select
                  id="user_id"
                  v-model="form.user_id"
                  :options="users"
                  placeholder="Seleccionar..."
                  :reduce="users => users.id"
                  label="name"
                  name="user"
                  @input="changeUser"
                  size="sm"
                >
                  <div slot="no-options">No hay Resultados!</div>
                </v-select>
              </b-form-group>
              <b-form-group
                v-else
                id="group1"
                label-cols-md="3"
                label="Cliente:"
                label-for="user_id"
              >
                <b-form-input v-model="user_name" disabled />
              </b-form-group>
            </b-form>
          </b-col>
          <b-col sm="12" md="12" lg="6">
            <b-button
              size="md"
              variant="primary"
              class="mb-3"
              @click="newTracing()"
              :disabled="endDate"
              ><i class="fas fa-plus-circle"></i> Nuevo</b-button
            >
          </b-col>
          <b-col md="12" v-if="endDate">
            <div class="alert alert-warning mt-1 text-center" role="alert">
              Su pago ha expirado, por favor realice el pago!
            </div>
          </b-col>
        </b-row>
        <div class="body_table pt-3">
          <TableCustom
            type-page="tracing"
            :fields="fields"
            :items="tracings"
            :rows="allRow"
            :per-page="10"
            :show-filter="false"
            :per-pagination="false"
            :status-state="false"
          />
        </div>
      </div>
    </div>
    <ModalTracing
      :viewOnlly="false"
      :event="true"
      tittleModal="Nuevo Registro"
      :modal="modal"
      :user="form.user_id"
    />
  </div>
</template>
<script>
import TableCustom from "../components/table/TableCustom";
import ModalTracing from "../components/modals/ModalTracing";
import EventBus from "../bus";
import moment from "moment";
moment.locale("es");
export default {
  components: {
    TableCustom,
    ModalTracing
  },
  props: {
    user: String
  },
  data() {
    return {
      endDate: false,
      // Note `isActive` is left out and will not appear in the rendered table
      states: [
        { id: "1", name: "Activo" },
        { id: "2", name: "Inactivo" }
      ],
      user_id: "",
      user_name: "",
      show: true,
      sending: false,
      updating: false,
      event: "",
      viewOnlly: false,
      tittleModal: "",
      allRow: this.row,
      rol_id: 0,
      rows: 4,
      modal: "modal-tracing",
      form: {
        user_id: 0,
        back: "",
        calf: "",
        leg: "",
        date: "",
        arm: "",
        waist: "",
        weigth: "",
        size: ""
      },
      fields: [
        {
          key: "id",
          label: "ID",
          sortable: true
        },
        {
          key: "back",
          label: "Espalda (cm)",
          sortable: true
        },
        {
          key: "chest",
          label: "Pecho (cm)",
          sortable: true
        },
        {
          key: "leg",
          label: "Pierna (cm)",
          sortable: true
        },
        {
          key: "arm",
          label: "Brazo (cm)",
          sortable: true
        },
        {
          key: "waist",
          label: "Cintura (cm)",
          sortable: true
        },
        {
          key: "weight",
          label: "Peso (kg)",
          sortable: true
        },
        {
          key: "created_at",
          label: "Fecha",
          sortable: true,
          formatter: value => {
            return moment(value).format("YYYY-MM-DD");
          }
        },
        {
          key: "acciones",
          label: "Acciones",
          visible: false,
          sortable: false
        }
      ],
      items: [
        {
          isActive: true,
          age: 40,
          first_name: "Dickerson",
          last_name: "Macdonald"
        },
        { isActive: false, age: 21, first_name: "Larsen", last_name: "Shaw" },
        { isActive: false, age: 89, first_name: "Geneva", last_name: "Wilson" },
        { isActive: true, age: 38, first_name: "Jami", last_name: "Carney" }
      ]
    };
  },
  computed: {
    tracings() {
      return this.$store.state.administration.tracings;
    },
    row() {
      return this.$store.state.administration.allRow;
    },
    users() {
      const users = this.$store.state.user.users.filter(user => {
        return user.roles.find(role => role.name !== "super_admin");
      });
      return users;
    },
    userAuth() {
      return JSON.parse(this.user);
    }
  },
  created() {
    // this.$store.dispatch('getTracing')
    this.$store.dispatch("getUsers");
  },
  mounted() {
    this.rol_id = this.userAuth.roles[0]["id"];
    this.user_name = this.userAuth.name;
    this.user_id = this.userAuth.id;
    if (this.rol_id == 2) {
      this.form.user_id = this.userAuth.id;
      this.$store.dispatch("getTracing", this.form.user_id);
    }
    setTimeout(() => {
      this.checkEndDate();
    }, 200);
  },
  methods: {
    changeUser() {
      this.$store.dispatch("getTracing", this.form.user_id);
    },
    newTracing(view) {
      EventBus.$emit("show-modal-tracing", this.rol_id);
    },
    modalEdit(item, index, button, view) {
      if (view) {
        this.tittleModal = "Ver " + item.names;
        this.viewOnlly = true;
      } else {
        this.viewOnlly = false;
        this.tittleModal = "Editar " + item.names;
      }
      //this.$store.dispatch('api/clearErrors') //clean errors of back
      //this.$store.dispatch('config/getGender')
      //this.$store.dispatch('config/getTypeIdentification')
      this.form.user_id = item.user_id;
      //this.form.state = item.state
      this.form.back = item.back;
      this.form.calf = item.calf;
      this.form.leg = item.leg;
      this.form.date = item.date;
      this.form.arm = item.arm;
      this.form.waist = item.waist;
      this.form.weigth = item.weigth;
      this.form.size = item.size;
      this.event = 0;
      this.sending = false;
      this.updating = false;
      this.$refs["modal-tracing"].show();
    },
    checkEndDate() {
      if (this.form.user_id == null) {
        return false;
      }
      const userId = this.form.user_id;

      const user = this.$store.state.user.users.find(user => user.id == userId);
      const verifyEndDate = user.payments.find(payment => payment.state);
      let date = new Date(),
        month = "" + (date.getMonth() + 1),
        day = "" + date.getDate(),
        year = date.getFullYear();

      if (month.length < 2) month = "0" + month;
      if (day.length < 2) day = "0" + day;

      date = [year, month, day].join("-");

      this.endDate = verifyEndDate.end_date < date;
    }
  },
  watch: {
    row() {
      this.allRow = this.row;
    }
  }
};
</script>
<style lang="scss">
.tracing_component {
  .card-body {
    .form-group {
      label {
        @media (min-width: 992px) {
          text-align: right;
        }
      }
      .vs__dropdown-toggle {
        height: 46px;
      }
    }
  }
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
