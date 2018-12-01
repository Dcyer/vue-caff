import api from '../../api/user'
import ls from '../../utils/localStorage'

export default {
    state: {
        me: {},
        auth: false,
    },
    actions: {
        postUsers({commit}, params) {
            return api.postUsers(params).then(response => {
                commit('SET_ME', response.data)
                commit('SET_AUTH', true)
                ls.setItem('jwt-token', response.data.meta)
            })
        },
        getMe({commit}) {
            return api.getMe().then(response => {
                commit('SET_ME', response.data)
                commit('SET_AUTH', true)
            })
        }
    },
    mutations: {
        SET_ME(state, me) {
            ls.setItem('me', me)
            state.me = me
        },
        SET_AUTH(state, auth) {
            state.auth = auth
        }
    },
    getters: {
        getMe(state) {
            return state.me
        }
    }
}