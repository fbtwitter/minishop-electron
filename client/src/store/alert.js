export default {
  namespaced: true,
  state: {
    status: false,
    color: 'success',
    text: ''
  },
  mutations: {
    set : (state, payload) => {
      state.status = payload.status
      state.text = payload.text
      state.color = payload.color
    },
  },
  actions: {
    set : ({commit}, payload) => {
      commit('set', payload);
    }
  },
  getters: {
    status: state => {
      return state.status;
    },
    color: state => {
      return state.color;
    },
    text: state => {
      return state.text;
    },
  }
}