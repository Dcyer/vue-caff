import axios from 'axios'

const API_URL = process.env.MIX_VUE_API_URL

export default {
    postComments: function (params) {
        return axios.post(API_URL + 'articles/' + params.articleId + '/comments', params)
    },
    deleteComment: function (params) {
        return axios.delete(API_URL + 'articles/' + params.articleId + '/comments/' + params.commentId)
    }
}