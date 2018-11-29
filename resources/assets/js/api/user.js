import axios from 'axios'

const API_URL = 'http://dcynsd.test/api/'

export default {
    postUsers: function (params) {
        return axios.post(API_URL + 'users', params)
    }
}