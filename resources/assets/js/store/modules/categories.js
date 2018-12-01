import api from '../../api/category'

export default {
    state: {
        categories: [],
    },
    actions: {
        getCategories({commit}) {
            api.getCategories().then(response => {
                commit('SET_CATEGORIES', response.data.data)
            })
        }
    },
    mutations: {
        SET_CATEGORIES(state, categories) {
            state.categories = categories
        }
    }
}