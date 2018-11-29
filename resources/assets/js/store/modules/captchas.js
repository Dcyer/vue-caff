import api from '../../api/captcha'
import ls from '../../utils/localStorage'

export default {
    actions: {
        postCaptchas({commit}) {
            return api.postCaptchas().then(response => {
                ls.setItem('captchas', response.data)
            })
        }
    },
}