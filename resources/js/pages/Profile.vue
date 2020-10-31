<template>
  <div class="component_profile p-4">
    <div class="card">
      <div class="card-header first_card">
        <h1 class="fas fa-user-cog"> Cuenta</h1>
      </div>
      <div class="card-body body_profile">
        <b-row>
          <b-col cols="md-4" class="mb-4">
            <div class="card">
              <div class="card-header">
                <h1 class="fas fa-user-circle" > Mi perfil</h1>
              </div>
              <div class="card-body">
                  <div>
                    <b-form v-if="show">
                      <!-- Nombre -->
                      <b-form-group
                      id="groupname"
                      label="Nombre de Usuario:"
                      label-for="name"
                      >
                        <b-form-input
                          id="name"
                          v-model="form.name"
                          placeholder="Ingrese Nombre"
                          required
                          autofocus
                        ></b-form-input>
                      </b-form-group>
                      <!-- Email -->
                      <b-form-group
                        id="groupname"
                        label="E-mail:"
                        label-for="email"
                      >
                        <b-form-input
                          id="email"
                          v-model="form.email"
                          placeholder="Ingrese Correo Electronico"
                          type="email"
                          required
                          autofocus
                        ></b-form-input>
                      </b-form-group>
                      <!-- Rol -->
                      <b-form-group
                      id="groupname"
                      label="Rol:"
                      label-for="rol"
                      >
                        <b-form-input
                          id="rol"
                          v-model="form.rol"
                          required
                          autofocus
                        ></b-form-input>
                      </b-form-group>
                      <!-- Dependencia -->
                      <!-- <b-form-group
                        id="groupname"
                        label="Dependencia:"
                        label-for="dependencia">
                        <b-form-select
                          id="groupname"
                          v-model="form.dependencia"
                          :options="foods"
                          placeholder="Seleecione Uno"
                          required
                        ></b-form-select>
                      </b-form-group> -->
                      <div class="text-center">
                        <b-button type="submit" variant="dark" class="far fa-save"> Actualizar Datos</b-button>
                      </div>
                    </b-form>
                  </div>
              </div>
            </div>
          </b-col>
          <b-col cols="md-4" class="mb-4">
            <div class="card">
              <div class="card-header">
                <h1 class="fas fa-image" > Mi Foto</h1>
              </div>
              <div class="card-body">
                <form action="">
                  <label class="d-block">Imagen Perfil:</label>
                  <b-form-group>

                  </b-form-group>
                  <div class="text-center">
                    <b-button type="submit" variant="dark" class="far fa-save"> Actualizar Imagen</b-button>
                  </div>
                </form>
              </div>
            </div>
          </b-col>
          <b-col cols="md-4" class="mb-4">
            <div class="card">
              <div class="card-header">
                <h1 class="fas fa-key"> Mi Contraseña</h1>
              </div>
              <div class="card-body">
                <form action="">
                  <!-- Anterios Contraseña -->
                      <b-form-group
                      id="groupname"
                      label="Contraseña Anterior:"
                      label-for="password"
                      >
                        <b-form-input
                          id="password"
                          v-model="form.old_password"
                          type="password"
                          placeholder="Ingrese Contraseña Anterior"
                          required
                          autofocus
                        ></b-form-input>
                      </b-form-group>
                      <!-- Contraseña -->
                      <b-form-group
                        id="groupname"
                        label="Contraseña Nueva:"
                        label-for="passNew"
                      >
                        <b-form-input
                          id="passNew"
                          v-model="form.password_new"
                          type="password"
                          placeholder="Ingrese Contraseña Nueva"
                          required
                          autofocus
                        ></b-form-input>
                      </b-form-group>
                      <!-- Confirmar contraseña -->
                      <b-form-group
                      id="groupname"
                      label="Confirmar Contraseña:"
                      label-for="confirm_password"
                      >
                        <b-form-input
                          id="confirm_password"
                          v-model="form.confirm_password"
                          type="password"
                          placeholder="Confirme Contraseña"
                          required
                          autofocus
                        ></b-form-input>
                      </b-form-group>
                      <div class="text-center">
                        <b-button type="submit" variant="dark" class="far fa-save"> Actualizar Contraseña</b-button>
                      </div>
                </form>
              </div>
            </div>
          </b-col>
        </b-row>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        form: {
          email: '',
          name: '',
          //food: null,
          //checked: []
          rol: null,
          old_password: '',
          password_new: '',
          confirm_password: ''
        },
        /* foods: [{ text: '', value: null }, 'Soltero', 'Casado', 'Muerto', 'No sabe'], */
        show: true
      }
    },
    methods: {
      onSubmit(evt) {
        evt.preventDefault()
        alert(JSON.stringify(this.form))
      },
      onReset(evt) {
        evt.preventDefault()
        // Reset our form values
        this.form.email = ''
        this.form.name = ''
        this.form.food = null
        this.form.checked = []
        // Trick to reset/clear native browser form validation state
        this.show = false
        this.$nextTick(() => {
          this.show = true
        })
      }
    }
  }
</script>
<style lang="scss">
.component_profile{
  .first_card{
    border-bottom: 1px solid #e0e0e0;
  }
  h1{
    margin-bottom: unset;
  }
  //background-color: #dedede;
  .card{
    //box-shadow: 4px 4px 4px -6px black;
    border: 1px solid #e0e0e0;
   }
  .body_profile{
    .card-header{
      background: #9e76ff;
    }
  }
}
</style>
