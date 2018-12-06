import Vue from 'vue'
import Vuex from 'vuex'

import categories from './modules/categories'
import captchas from './modules/captchas'
import users from './modules/users'
import authorizations from './modules/authorizations'
import uploads from './modules/uploads'
import articles from './modules/articles'
import votes from './modules/votes'
import comments from './modules/comments'
import sliders from './modules/sliders'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        categories,
        captchas,
        users,
        authorizations,
        uploads,
        articles,
        votes,
        comments,
        sliders
    }
})