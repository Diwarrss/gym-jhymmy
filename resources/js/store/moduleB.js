export default {
  state: { count: 0 },
  mutations: {
    increment (state) {
      // `state` is the local module state
      state.count++
    }
  },
  actions: {
    count ({ state }) {
      console.log("sumando numeros b")
    }
  },
  getters: {
    oneCount (state) {
      return state.count * 1
    }
  }
}
