import axios from 'axios'

const API_URL = process.env.MIX_VUE_API_URL

export default {
    postAvatars: function (params) {
        return axios.post(API_URL + 'uploads/avatar', params, {'Content-Type':'multipart/form-data'})
    },
}