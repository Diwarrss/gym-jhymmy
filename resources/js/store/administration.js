//store para usuario
//import axios from 'axios'
export default {
  state: {
    tracings: [],//seguiminetos
    payment: [],//pagos
    access_control: [],
    allRow: 0
  },
  mutations: {
    setTracings(state, data) {
      state.tracings = data
      state.allRow = data.length
    },
    setPayment(state, data) {
      state.payment = data
      state.allRow = data.length
    },
    setAccessControl(state, data) {
      state.access_control = data
      state.allRow = data.length
    }
  },
  actions: {
    getTracing: async function({ commit }, param) {
      const data = await axios.get('/tracings', { params: { user: param } })
      commit('setTracings', data.data)
    },
    getPayment: async function({ commit }) {
      const data = await axios.get('/payments')
      commit('setPayment', data.data)
    },
    getAccessControl: async function({ commit }) {
      const data = await axios.get('/access-controlls')
      commit('setAccessControl', data.data)
    }
  },
  getters: {}
}
