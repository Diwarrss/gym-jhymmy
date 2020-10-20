//store para usuario
import axios from 'axios'
export default {
  state: {
    states: [],
    genders: [],
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
    }
  },
  getters: {}
}
