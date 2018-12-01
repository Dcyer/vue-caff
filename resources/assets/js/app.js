require('./bootstrap');

window.Vue = require('vue');
import App from './App.vue'
import router from './router'
import store from './store'
import zh_CN from 'vee-validate/dist/locale/zh_CN'
import VeeValidate, { Validator } from 'vee-validate'
import ls from './utils/localStorage'
import './components'
import './directives'
import axios from 'axios'

// 请求拦截
axios.interceptors.request.use(function (request) {
    let jwt = ls.getItem('jwt-token')
    if (jwt) {
        request.headers['Authorization'] = jwt.token_type + ' ' + jwt.access_token
    }
    return request
}, function (error) {
    return Promise.reject(error)
})

// 响应拦截
axios.interceptors.response.use(response => {
    return response
}, error => {
    let jwt = ls.getItem('jwt-token')
    switch (error.response.status) {
        case 401:
            if (jwt) {
                ls.removeItem('jwt-token')
                router.push('/auth/login')
            }
            break;

    }
    return Promise.reject(error)
})

Vue.use(VeeValidate)
Validator.localize('zh_CN', zh_CN)

Vue.prototype.$ls = ls
Vue.config.productionTip = false

new Vue({
    el: '#app',
    components: {App},
    template: '<App/>',
    router,
    store,
});
