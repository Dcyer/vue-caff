export default {
    state: {
        searchValue: '',
    },
    actions: {
        updateSearchValue({commit}, searchValue) {
            commit('UPDATE_SEARCH_VALUE', searchValue)
        }
    },
    mutations: {
        UPDATE_SEARCH_VALUE(state, searchValue) {
            state.searchValue = searchValue
        }
    }
}