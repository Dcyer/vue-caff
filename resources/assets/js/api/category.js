import axios from 'axios'

export default {
    getCategories: function () {
        return axios.get('http://dcynsd.test/api/v1/categories')
    }
}