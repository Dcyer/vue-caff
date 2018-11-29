import axios from 'axios'

const API_URL = 'http://dcynsd.test/api/'

export default {
    getCategories: function () {
        return axios.get(API_URL + 'categories')
    }
}