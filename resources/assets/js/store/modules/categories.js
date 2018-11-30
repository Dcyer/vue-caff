import api from '../../api/category'

export default {
    state: {
        categories: [],
    },
    actions: {
        getCategories({commit}) {
            api.getCategories().then(response => {
                commit('SET_CATEGORIES', response.data.categories)
            })
        }
    },
    mutations: {
        SET_CATEGORIES(state, categories) {
            state.categories = categories
        }
    },
    getters: {
        categories(state) {
            return state.categories
        }
    }
}