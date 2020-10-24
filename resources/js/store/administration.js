//store para usuario
import axios from 'axios'
export default {
  state: {
    monitoring: [],//seguiminetos
    payment: [],//pagos
    allRow: 0
  },
  mutations: {
    setMonitoring(state, data) {
      state.monitoring = data
      state.allRow = data.length
    },
    setPayment(state, data) {
      state.payment = data
      state.allRow = data.length
    },
    setAccess(state, data) {
      state.access = data
      state.allRow = data.length
    }
  },
  actions: {
    getMonitoring: async function({ commit }) {
      const data = await axios.get('/follow')
      commit('setMonitoring', data.data)
    },
    getPayment: async function({ commit }) {
      const data = await axios.get('/payments')
      commit('setPayment', data.data)
    },
    getAccess: async function({ commit }) {
      const data = await axios.get('/accesses')
      commit('setAccess', data.data)
    }
  },
  getters: {}
}
