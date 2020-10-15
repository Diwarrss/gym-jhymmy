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
      console.log("sumando numeros a")
    }
  },
  getters: {
    doubleCount (state) {
      return state.count * 2
    }
  }
}
