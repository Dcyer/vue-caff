<template>
    <div class="navbar navbar-default topnav">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" @click="toggleNav">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <router-link to="/" class="navbar-brand">
                    <span class="title">{{ logo.title }}</span>
                    <img :src="logo.src" :alt="logo.title">
                </router-link>
            </div>

            <div id="top-navbar-collapse" :class="['collapse', 'navbar-collapse', { in: showCollapsedNav }]">
                <!-- 导航分类 -->
                <ul class="nav navbar-nav">
                    <li v-for="(category, index) in categories" :class="{active: index === activeCategoryIndex}">
                        <a href="#" @click="changeCategoryIndex(index)">{{ category }}</a>
                    </li>
                </ul>

                <!-- 入口组件 -->
                <div class="navbar-right">
                    <TheEntry/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import TheEntry from './TheEntry'

    export default {
        name: "TheHeader",
        components: {
            TheEntry,
        },
        data() {
            return {
                logo: {
                    src: `${this.uploadsUrl}sites/ByvFbNlQYVwhvTyBgLdqitchoacDNznN.jpg`,
                    title: 'VuejsCaff'
                },
                // categories: ['社区', '头条', '问答', '教程'],
                activeCategoryIndex: 0,
                showCollapsedNav: false,
            }
        },
        beforeCreate() {
            this.uploadsUrl = 'https://vuejscaffcdn.phphub.org/uploads/'
        },
        computed: mapState({
            categories: state => state.categories.categories
        }),
        created() {
            this.$store.dispatch('getCategories')
        },
        methods: {
            changeCategoryIndex(index) {
                this.activeCategoryIndex = index
            },
            toggleNav() {
                this.showCollapsedNav = !this.showCollapsedNav
            }
        }
    }
</script>

<style scoped>
    .title {
        display: none;
    }

    .navbar-default .navbar-nav > .active > a {
        background: rgba(0, 0, 0, .03);
    }
</style>