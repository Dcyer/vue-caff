import axios from 'axios'

const API_URL = process.env.MIX_VUE_API_URL

export default {
    postCaptchas: function () {
        return axios.post(API_URL + 'captchas')
    }
}