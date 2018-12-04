import api from '../../api/article'

export default {
    actions: {
        postArticles({commit}, params) {
            return api.postArticels(params)
        },
    },
}