import axios from 'axios'

export default {
    getCategories: function () {
        return axios.get('/categories')
    }
}