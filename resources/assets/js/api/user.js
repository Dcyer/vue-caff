import axios from 'axios'

const API_URL = process.env.MIX_VUE_API_URL

export default {
    postUsers: function (params) {
        return axios.post(API_URL + 'users', params)
    }
}