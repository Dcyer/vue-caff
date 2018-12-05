<template>
    <div class="col-md-9 left-col pull-right">
        <div class="panel article-body article-index">
            <div class="panel-body">
                <h1 class="all-articles">
                    专栏文章
                    <router-link v-if="auth" to="/articles/create" class="btn btn-primary pull-right">
                        <i class="fa fa-paint-brush"></i>
                        创作文章
                    </router-link>
                </h1>

                <ul class="list-group">
                    <li v-for="article in articles" class="list-group-item">
                        <img v-if="article.user" :src="article.user.avatar" class="avatar avatar-small">
                        <router-link :to="`/users/${article.user.id}/articles/${article.id}/content`" class="title">
                            {{ article.title }}
                        </router-link>
                        <span class="meta pull-right">
                            <span class="timeago">{{ article.created_at }}</span>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        name: 'List',
        computed: mapState({
            auth: state => state.users.auth
        }),
        data() {
            return {
                articles: []
            }
        },
        watch: {
            $route: {
                handler() {
                    const userId = this.$route.params.userId

                    this.$store.dispatch('getUserArticles', userId).then(response => {
                        this.articles = response.data.data
                    }).catch(error => {
                        this.$message.error('用户不存在/(ㄒoㄒ)/~~')
                        this.$router.push('/')
                    })
                },
                immediate: true
            }
        },
    }
</script>

<style scoped>

</style>