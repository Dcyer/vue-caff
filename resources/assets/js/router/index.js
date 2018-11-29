import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const routes = [
    {
        path: '/auth/register',
        name: 'Register',
        component: require('../views/auth/Register')
    },
    {
        path: '/',
        name: 'Home',
        component: require('../views/Home')
    },
    {
        path: '*',
        redirect: '/'
    }
]

const router = new Router({
    // mode: 'history',
    routes,
})

export default router