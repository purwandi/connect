import stub from '@/stores/stubs/user' 

const state = {
  current: Object.assign({}, stub)
}

const getters = {
  UserGetCurrentUser: state => state.current,
  UserIsAuthenticated: (state, getters) => {
    return getters.UserGetCurrentUser.id !== ''
  }
}

const actions = {
  UserLogin ({ commit, state }, payload) {
    commit(types.USER_LOGIN, payload)
  }
}

const mutations = {
  [types.USER_LOGIN] (state, payload) {
    state.current = payload
  }
}

export default {
  state, getters, actions, mutations
}