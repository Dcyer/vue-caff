import api from '../../api/user'

export default {
    actions: {
        postUsers({commit}, params) {
            return api.postUsers(params)
        }
    },
}