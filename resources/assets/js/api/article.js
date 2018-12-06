import axios from 'axios'

const API_URL = process.env.MIX_VUE_API_URL

export default {
    postArticels: function (params) {
        return axios.post(API_URL + 'articles', params)
    },
    getArticle: function (articleId) {
        return axios.get(API_URL + 'articles/' + articleId + '?include=comments')
    },
    updateArticle: function (params) {
        return axios.patch(API_URL + 'articles/' + params.articleId, params)
    },
    deleteArticle: function (articleId) {
        return axios.delete(API_URL + 'articles/' + articleId)
    },
    getUserArticles: function (userId) {
        return axios.get(API_URL + 'users/' + userId + '/articles?include=user')
    },
    getArticles: function (params) {
        return axios.get(API_URL + 'articles?include=user', {params: params})
    }
}