<template>
    <div class="blog-container" style="margin-top:20px">
        <div class="blog-pages">
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
                            <!-- 编辑删除图标 -->
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
                article: {}
            }
        },
        created() {
            const articleId = this.$route.params.articleId

            this.$store.dispatch('getArticle', articleId).then(response => {
                this.article = response.data
            }).catch(error => {
                this.$message.error('文章丢失了/(ㄒoㄒ)/~~')
                this.$router.push('/')
            })

            this.articleId = articleId
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
            }
        }
    }
</script>

<style scoped>

</style>