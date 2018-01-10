import Vue from 'vue'
import Vuex from 'vuex'
import createLogger from '../../../src/plugins/logger'

import user from '@/stores/modules/user'
import project from '@/stores/modules/project'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex({
  modules: {
    user,
    project
  },
  strict: debug,
  plugins: debug ? [createLogger()] : []
})