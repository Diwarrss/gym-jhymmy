//import axios from 'axios'
export default {
  state: {
    result: [],
    errors: {}
  },

  getters: {},

  actions: {
    create: function({ commit, dispatch }, params) {
      commit('setErrors', {})
      let url = params.url
      let getData = params.data
      let files = params.files
      let action = params.action
      if (files) {
        axios
          .post(url, getData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(res => {
            console.log(res)
          })
          .catch(err => {
            console.error(err)
          })
      } else {
        axios
          .post(url, getData)
          .then(res => {
            if (res.data.type === 'success') {
              setTimeout(() => {
                Vue.swal({
                  icon: 'success',
                  title: res.data.message,
                  showConfirmButton: true,
                  timer: 2000
                })
              }, 2000);
              if (params.paramDispatch) {
                dispatch(action, params.actionDispatch, {root:true})
              }else{
                dispatch(action, null, {root:true})
              }
            } else {
              setTimeout(() => {
                Vue.swal({
                  icon: 'error',
                  title: res.data.message,
                  showConfirmButton: true,
                  timer: 2000
                })
              }, 2000);
            }
          })
          .catch(err => {
            if (err.response.status == 422) {
              commit('setErrors', err.response.data.errors)
            }
            console.error(err)
          })
      }
    },
    update: function({ dispatch, commit }, params) {
      commit('setErrors', {})
      console.log(params.data)
      let url = params.url
      let getData = params.data
      let files = params.files
      let action = params.action
      if (files) {
        axios
          .post(url, getData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          })
          .then(res => {
            if (res.data.type === 'success') {
              setTimeout(() => {
                this.$swal({
                  title: res.data.message,
                  icon: 'success',
                  confirmButtonColor: '#4dbd74',
                  confirmButtonText:
                    '<i class="far fa-check-circle"></i> Aceptar',
                  timer: 2000
                })
              }, 1000)
              if (params.dispatchParams) {
                dispatch(params.action, params.actionDispatch, {root:true})
              }else{
                dispatch(params.action, null, {root:true})
              }
              commit('setResult', res.data.data)
            } else {
              this.$swal({
                title: res.data.message,
                icon: 'error',
                confirmButtonColor: '#4dbd74',
                confirmButtonText: '<i class="far fa-check-circle"></i> Aceptar',
                timer: 2000
              })
            }
            console.log(res)
          })
          .catch(err => {
            if (err.response.status == 422) {
              commit('setErrors', err.response.data.errors)
            }
            console.error(err)
          })
      } else {
        axios
          .put(url, getData)
          .then(res => {
            if (res.data.type === 'success') {
              setTimeout(() => {
                Vue.swal({
                  icon: 'success',
                  title: res.data.message,
                  showConfirmButton: true,
                  timer: 2000
                })
              }, 2000);
              if (params.dispatchParams) {
                dispatch(action, params.actionDispatch, {root:true})
              }else{
                dispatch(action, null, {root:true})
              }
              commit('setResult', res.data.data)
            } else {
              setTimeout(() => {
                Vue.swal({
                  icon: 'error',
                  title: res.data.message,
                  showConfirmButton: true,
                  timer: 2000
                })
              }, 2000);
            }
            console.log(res)
          })
          .catch(err => {
            if (err.response.status == 422) {
              commit('setErrors', err.response.data.errors)
            }
            console.error(err)
          })
      }
    },
    status: function({ dispatch, commit }, params) {
      axios
        .put(params.url)
        .then(res => {
          if (res.data.type === 'success') {
            setTimeout(() => {
              Vue.swal({
                icon: 'success',
                title: res.data.message,
                showConfirmButton: true,
                timer: 2000
              })
            }, 500);
            if (params.dispatchParams) {
              dispatch(params.action, params.actionDispatch, {root:true})
            }else{
              dispatch(params.action, null, {root:true})
            }
            commit('setResult', res.data.data)
          } else {
            setTimeout(() => {
              Vue.swal({
                icon: 'error',
                title: res.data.message,
                showConfirmButton: true,
                timer: 2000
              })
            }, 500);
          }
          console.log(res)
        })
        .catch(err => {
          console.error(err)
        })
    },
    delete: function({ commit }, params) {
      console.log(params)
      let url = params.url
      let getData = params.data
      axios
        .post(url, getData)
        .then(res => {
          if (res.data.type === 'success') {
            this.$swal({
              toast: true,
              position: 'top-end',
              icon: 'error',
              title: res.data.message,
              showConfirmButton: false,
              timer: 4000
            })
            commit('setResult', res.data.data)
          } else {
            this.$swal({
              title: res.data.message,
              icon: 'error',
              confirmButtonColor: '#4dbd74',
              confirmButtonText: 'Aceptar',
              timer: 3000
            })
          }
          console.log(res)
        })
        .catch(err => {
          console.error(err)
        })
    },
    clearErrors: function({ commit }) {
      commit('setErrors', {})
    },
    cancelFiling: function({ dispatch, commit }, params) {
      commit('setErrors', {})
      let me = this
      let url = params.url
      let getData = params.data
      axios
        .post(url, getData)
        .then(res => {
          if (res.data.type === 'success') {
            this.$swal({
              title: res.data.message,
              icon: 'success',
              confirmButtonColor: '#4dbd74',
              confirmButtonText: '<i class="far fa-check-circle"></i> Aceptar',
              timer: 4000
            })
            if (params.paramsrStatus) {
              dispatch(params.action, params.paramsr, {root:true})
            }else{
              if (params.dateRange.length > 0) {
                dispatch(params.action, params.dateRange, {root:true})
              } else {
                dispatch(params.action, null, {root:true})
              }
            }
            commit('setResult', res.data.data)
          } else {
            this.$swal({
              title: res.data.message,
              icon: 'error',
              confirmButtonColor: '#4dbd74',
              confirmButtonText: '<i class="far fa-check-circle"></i> Aceptar',
              timer: 3000
            })
          }
          console.log(res)
        })
        .catch(err => {
          console.error(err)
        })
    },
    clearResult: function ({ commit }){
      commit('setClearResult', {})
    }
  },

  mutations: {
    setResult(state, data) {
      state.result = data
    },
    setErrors(state, data) {
      state.errors = data
    },
    setClearResult(state, data) {
      state.result = []
    }
  }
}
