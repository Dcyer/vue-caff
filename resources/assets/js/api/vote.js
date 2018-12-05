import axios from 'axios'

const API_URL = process.env.MIX_VUE_API_URL

export default {
    postVotes: function (articleId) {
        return axios.post(API_URL + 'articles/' + articleId + '/votes')
    },
    deleteVotes: function (articleId) {
        return axios.delete(API_URL + 'articles/' + articleId + '/votes')
    }
}