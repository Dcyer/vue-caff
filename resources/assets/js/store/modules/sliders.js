import api from '../../api/slider'

export default {
    actions: {
        getLinks({commit}) {
            return api.getLinks()
        },
    },
}