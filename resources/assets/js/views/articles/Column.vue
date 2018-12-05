<template>
    <div class="blog-container">
        <div class="blog-pages">
            <!-- 用于渲染『文章列表』和『文章内容』 -->
            <router-view/>

            <div class="col-md-3 main-col pull-left">
                <div class="panel panel-default corner-radius">
                    <div class="panel-body text-center topic-author-box blog-info">
                        <div class="image blog-cover">
                            <router-link :to="`/users/${user.id}/articles`">
                                <img :src="user.avatar" class="avatar-112 avatar img-thumbnail">
                            </router-link>
                        </div>
                        <div class="blog-name">
                            <h4>
                                <router-link :to="`/users/${user.id}/articles`">{{ user.name }} 的专栏</router-link>
                            </h4>
                        </div>
                        <hr>
                        <router-link :to="`/users/${user.id}/articles`">
                            <li class="list-group-item">
                                <i class="text-md fa fa-list-ul"></i> 专栏文章（{{ user.post_counts }}）
                            </li>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Column',
        data() {
            return {
                user: {}
            }
        },
        watch: {
            $route: {
                handler() {
                    const userId = this.$route.params.userId

                    this.$store.dispatch('getUser', userId).then(response => {
                        this.user = response.data
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
    .blog-container {
        margin-top: 20px;
    }
</style>