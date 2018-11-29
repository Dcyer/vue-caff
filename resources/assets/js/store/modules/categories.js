import api from '../../api/category'

export default {
    state: {
        categories: [],
    },
    actions: {
        getCategories({commit}) {
            api.getCategories().then(response => {
                commit('SETCATEGORIES', response.data)
            })
        }
    },
    mutations: {
        SETCATEGORIES(state, categories) {
            state.categories = categories
        }
    },
    getters: {
        categories(state) {
            return state.categories
        }
    }
}