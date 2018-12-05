import api from '../../api/vote'

export default {
    actions: {
        postVotes({commit}, articleId) {
            return api.postVotes(articleId)
        },
        deleteVotes({commit}, articleId) {
            return api.deleteVotes(articleId)
        }
    },
}