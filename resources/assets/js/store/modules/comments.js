import api from '../../api/comment'

export default {
    actions: {
        postComments({commit}, params) {
            return api.postComments(params)
        },
        deleteComment({commit}, params) {
            return api.deleteComment(params)
        }
    },
}