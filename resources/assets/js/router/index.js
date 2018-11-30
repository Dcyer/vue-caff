import Vue from 'vue'
import Router from 'vue-router'
import ls from '../utils/localStorage'

Vue.use(Router)

const routes = [
    {
        path: '/auth/register',
        name: 'Register',
        component: require('../views/auth/Register')
    },
    {
        path: '/auth/login',
        name: 'Login',
        component: require('../views/auth/Login')
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

// 全局前置守卫
router.beforeEach((to, from, next) => {
    const auth = ls.getItem('jwt-token')

    if (
        (auth && to.path.indexOf('/auth/') !== -1) ||
        (!auth && to.meta.auth)
    ) {
        next('/')
    } else {
        next()
    }
})

export default router