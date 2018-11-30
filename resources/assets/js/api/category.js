import axios from 'axios'

const API_URL = process.env.MIX_VUE_API_URL

export default {
    getCategories: function () {
        return axios.get(API_URL + 'categories')
    }
}