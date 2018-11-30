import api from '../../api/authorization'
import ls from '../../utils/localStorage'

export default {
    actions: {
        login({commit}, params) {
            return api.login(params).then(response => {
                ls.setItem('jwt-token', response.data)
            })
        },
        logout({commit}) {
            return api.logout().then(response => {
                commit('SET_ME', {})
                commit('SET_AUTH', false)
                ls.removeItem('jwt-token')
            })
        }
    },
}