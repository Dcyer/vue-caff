require('./bootstrap');

window.Vue = require('vue');
import App from './App.vue'
import router from './router'
import store from './store'
import zh_CN from 'vee-validate/dist/locale/zh_CN'
import VeeValidate, { Validator } from 'vee-validate'
import ls from './utils/localStorage'
import './directives'
import './components'
import axios from 'axios'
import ElementUI from 'element-ui';
import {Message} from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import 'mavon-editor/dist/css/index.css'
import hljs from 'highlight.js'
import 'highlight.js/styles/paraiso-dark.css'
import VueSweetalert2 from './plugins/vue-sweetalert2'

window.hljs = hljs

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
    switch (error.response.status) {
        case 401:
            if (ls.getItem('jwt-token')) {
                ls.removeItem('jwt-token')
                router.push('/auth/login')
            }
            break;
        case 403:
            Message.error('你没有权限哦！~_~')
            router.push('/')
            break

    }
    return Promise.reject(error)
})

Vue.use(VueSweetalert2)
Vue.use(ElementUI);
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
