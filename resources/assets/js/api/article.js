import axios from 'axios'

const API_URL = process.env.MIX_VUE_API_URL

export default {
    postArticels: function (params) {
        return axios.post(API_URL + 'articles', params)
    },
    getArticle: function (articleId) {
        return axios.get(API_URL + 'articles/' + articleId)
    },
    updateArticle: function (params) {
        return axios.patch(API_URL + 'articles/' + params.articleId, params)
    },
    deleteArticle: function (articleId) {
        return axios.delete(API_URL + 'articles/' + articleId)
    }
}