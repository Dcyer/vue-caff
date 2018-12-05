<template>
    <div class="col-md-9 left-col pull-right">
        <div class="panel article-body content-body">
            <h1 class="text-center">{{ article.title }}</h1>
            <div class="article-meta text-center">
                <i class="fa fa-clock-o"></i>
                <abbr>{{ article.created_at }}</abbr>
            </div>
            <div class="entry-content">
                <div class="content-body entry-content panel-body ">
                    <div class="markdown-body" v-html="article.body"></div>

                    <div v-if="auth && user_id === article.user_id" class="panel-footer operate">
                        <div class="actions">
                            <a @click="deleteArticle" class="admin" href="javascript:;"><i
                                    class="fa fa-trash-o"></i></a>
                            <a @click="editArticle" class="admin" href="javascript:;"><i
                                    class="fa fa-pencil-square-o"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 点赞 -->
        <div class="votes-container panel panel-default padding-md">
            <div class="panel-body vote-box text-center">
                <div class="btn-group">
                    <a @click="vote" href="javascript:;" class="vote btn btn-primary popover-with-html" :class="voteClass">
                        <i class="fa fa-thumbs-up"></i> {{ voteClass ? '已赞' : '点赞' }}
                    </a>
                </div>
                <div class="voted-users">
                    <div class="user-lists">
                        <span v-for="voteUser in voteUsers">
                            <!-- 点赞用户是当前用户时，加上类 animated 和 swing 以显示一个特别的动画  -->
                            <img :src="voteUser && voteUser.avatar" class="img-thumbnail avatar avatar-middle" :class="{ 'animated swing' : voteUser.id === user_id }">
                        </span>
                    </div>
                    <div v-if="!voteUsers.length" class="vote-hint">成为第一个点赞的人吧 ?</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        name: 'Content',
        computed: mapState({
            auth: state => state.users.auth,
            user_id: state => state.users.me.id
        }),
        data() {
            return {
                article: {},
                voteUsers: [], // 点赞用户列表
                voteClass: '', // 点赞样式
            }
        },
        watch: {
            $route: {
                handler() {
                    const articleId = this.$route.params.articleId

                    this.$store.dispatch('getArticle', articleId).then(response => {
                        this.article = response.data
                        this.voteUsers = response.data.votes
                        this.voteClass = this.voteUsers.some(voteUser => voteUser.id === this.user_id) ? 'active' : ''
                    }).catch(error => {
                        this.$message.error('文章丢失了/(ㄒoㄒ)/~~')
                        this.$router.push('/')
                    })

                    this.articleId = articleId
                },
                immediate: true
            }
        },
        methods: {
            editArticle() {
                this.$router.push({name: 'Edit', params: {articleId: this.articleId}})
            },
            deleteArticle() {
                this.$swal({
                    text: '你确定要删除此内容吗?',
                    confirmButtonText: '删除'
                }).then((res) => {
                    if (res.value) {
                        this.$store.dispatch('deleteArticle', this.articleId).then(response => {
                            this.$message.success('删除成功')
                            this.$router.push({name: 'Home', params: {showMsg: true}})
                        })
                    }
                })
            },
            vote(e) {
                // 未登录时，提示登录
                if (!this.auth) {
                    this.$swal({
                        text: '需要登录以后才能执行此操作。',
                        confirmButtonText: '前往登录'
                    }).then((res) => {
                        if (res.value) {
                            this.$router.push('/auth/login')
                        }
                    })
                } else {
                    const target = e.currentTarget
                    // 点赞按钮是否含有 active 类，我们用它来判断是否已赞
                    const active = target.classList.contains('active')

                    if (active) {
                        // 清除已赞样式
                        this.voteClass = ''
                        this.$store.dispatch('deleteVotes', this.articleId).then(response => {
                            this.voteUsers = response.data.users
                        })
                    } else {
                        // 添加已赞样式
                        this.voteClass = 'active animated rubberBand'
                        this.$store.dispatch('postVotes', this.articleId).then(response => {
                            this.voteUsers = response.data.users
                        })
                    }
                }
            },
        }
    }
</script>

<style scoped>

</style>