//store para usuario
//import axios from 'axios'
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
    getStates: async function({ commit }, param) {
      const data = await axios.get('/states', { params: { active: param} })
      commit('setStates', data.data)
    },
    getGenders: async function({ commit }, param) {
      const data = await axios.get('/genders', { params: { active: param} })
      commit('setGenders', data.data)
    },
    getCancellationReason: async function({ commit }, param) {
      const data = await axios.get('/cancellation-reasons', { params: { active: param} })
      commit('setCancellationReason', data.data)
    }
  },
  getters: {}
}
