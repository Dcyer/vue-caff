require('./bootstrap');

window.Vue = require('vue');
import App from './App.vue'
import router from './router'
import store from './store'
import zh_CN from 'vee-validate/dist/locale/zh_CN'
import VeeValidate, { Validator } from 'vee-validate'
import ls from './utils/localStorage'

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
