import axios from 'axios'

const API_URL = process.env.MIX_VUE_API_URL

export default {
    postArticels: function (params) {
        return axios.post(API_URL + 'articles', params)
    },
}