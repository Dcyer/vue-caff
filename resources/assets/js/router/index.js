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
    },
    {
        path: '/users/:id/edit',
        component: require('../views/users/Edit.vue'),
        children: [
            {
                path: '',
                name: 'EditProfile',
                component: require('../views/users/Profile.vue'),
                meta: {auth: true}
            },
            {
                path: '/users/:id/edit_avatar',
                name: 'EditAvatar',
                component: require('../views/users/Avatar'),
                meta: {auth: true}
            },
            {
                path: '/users/:id/edit_password',
                name: 'EditPassword',
                component: require('../views/users/Password'),
                meta: {auth: true}
            }
        ]
    },
    {
        path: '/articles/create',
        name: 'Create',
        component: require('../views/articles/Create'),
        meta: {auth: true}
    },
    {
        path: '/articles/:articleId/edit',
        name: 'Edit',
        component: require('../views/articles/Create'),
        meta: {auth: true}
    },
    {
        path: '/users/:userId/articles',
        component: require('../views/articles/Column'),
        children: [
            {
                path: '',
                name: 'Column',
                component: require('../views/articles/List')
            },
            {
                path: '/users/:userId/articles/:articleId/content',
                name: 'Content',
                component: require('../views/articles/Content')
            },
        ]
    },
]

const router = new Router({
    linkExactActiveClass: 'active',
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