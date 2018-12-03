import api from '../../api/upload'

export default {
    actions: {
        postAvatars({commit}, params) {
            return api.postAvatars(params).then(response => {
                commit('SET_ME', response.data)
            })
        },
    },
}