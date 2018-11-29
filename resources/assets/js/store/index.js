import Vue from 'vue'
import Vuex from 'vuex'

import categories from './modules/categories'
import captchas from './modules/captchas'
import users from './modules/users'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        categories,
        captchas,
        users,
    }
})