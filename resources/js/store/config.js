//store para usuario
import axios from 'axios'
export default {
  state: {
    states: [],
    genders: [],
    cancellationReason: [],
    allRow: 0
  },
  mutations: {
    setStates(state, data) {
      state.states = data
      state.allRow = data.length
    },
    setGenders(state, data) {
      state.genders = data
      state.allRow = data.length
    },
    setCancellationReason(state, data) {
      state.cancellationReason = data
      state.allRow = data.length
    }
  },
  actions: {
    getStates: async function({ commit }) {
      const data = await axios.get('/states')
      commit('setStates', data.data)
    },
    getGenders: async function({ commit }) {
      const data = await axios.get('/genders')
      commit('setGenders', data.data)
    },
    getCancellationReason: async function({ commit }) {
      const data = await axios.get('/cancellation-reasons')
      commit('setCancellationReason', data.data)
    }
  },
  getters: {}
}
