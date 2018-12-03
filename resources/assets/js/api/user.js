import axios from 'axios'

const API_URL = process.env.MIX_VUE_API_URL

export default {
    postUsers: function (params) {
        return axios.post(API_URL + 'users', params)
    },
    getMe: function () {
        return axios.get(API_URL + 'user')
    },
    updateMe: function (params) {
        return axios.patch(API_URL + 'user', params)
    },
    updatePassword: function (params) {
        return axios.patch(API_URL + 'user/password', params)
    }
}