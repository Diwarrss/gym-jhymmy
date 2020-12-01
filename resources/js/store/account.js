//store para usuario
import axios from 'axios'
export default {
  state: {
    profile: [],//perfil
    allRow: 0
  },
  mutations: {
    setProfile(state, data) {
      state.profile = data
      state.allRow = data.length
    },
  },
  actions: {
    getProfile: async function({ commit }) {
      const data = await axios.get('/profiles')
      commit('setProfile', data.data)
    },
  },
  getters: {}
}
