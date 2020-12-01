//store para usuario
import axios from 'axios'
export default {
  state: {
    permissions: [],
    roles: [],
    users: [],
    allRoles: [],
    allRow: 0
  },
  mutations: {
    setUsers(state, data) {
      state.users = data
      state.allRow = data.length
    }
  },
  actions: {
    getUsers: async function({ commit }) {
      const data = await axios.get('/users')
      commit('setUsers', data.data)
    }
  },
  getters: {}
}
