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
                    <li :class="{active: 'all' === activeCategoryIndex}">
                        <a @click="getAll">全部文章</a>
                    </li>
                    <li v-for="(category, index) in categories" :class="{active: index === activeCategoryIndex}">
                        <a @click="changeCategoryIndex(index, category.id)">{{ category.name }}</a>
                    </li>
                </ul>

                <!-- 入口组件 -->
                <div class="navbar-right">
                    <SearchInput/>
                    <TheEntry/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import TheEntry from './TheEntry'
    import SearchInput from './SearchInput'

    export default {
        name: "TheHeader",
        components: {
            TheEntry,
            SearchInput
        },
        data() {
            return {
                logo: {
                    src: `${this.uploadsUrl}sites/ByvFbNlQYVwhvTyBgLdqitchoacDNznN.jpg`,
                    title: 'VuejsCaff'
                },
                activeCategoryIndex: 'all',
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
            changeCategoryIndex(index, categoryId) {
                this.activeCategoryIndex = index
                this.$router.push('/?categoryId=' + categoryId)
            },
            getAll() {
                this.activeCategoryIndex = 'all'
                this.$router.push('/?categoryId=' + 0)
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