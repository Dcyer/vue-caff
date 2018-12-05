import api from '../../api/article'

export default {
    actions: {
        postArticles({commit}, params) {
            return api.postArticels(params)
        },
        getArticle({commit}, articleId) {
            return api.getArticle(articleId)
        },
        updateArticle({commit}, params) {
            return api.updateArticle(params)
        },
        deleteArticle({commit}, articleId) {
            return api.deleteArticle(articleId)
        },
        getUserArticles({commit}, userId) {
            return api.getUserArticles(userId)
        }
    },
}