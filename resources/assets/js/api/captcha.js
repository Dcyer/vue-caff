import axios from 'axios'

const API_URL = 'http://dcynsd.test/api/'

export default {
    postCaptchas: function () {
        return axios.post(API_URL + 'captchas')
    }
}