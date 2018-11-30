import axios from 'axios'

const API_URL = process.env.MIX_VUE_API_URL

export default {
    login: function (params) {
        return axios.post(API_URL + 'authorizations', params)
    },
    logout: function () {
        return axios.delete(API_URL + 'authorizations/current')
    }
}