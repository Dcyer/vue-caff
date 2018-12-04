<template>
    <div class="blog-container" style="margin-top:20px">
        <div class="blog-pages">
            <div class="col-md-9 left-col pull-right">
                <div class="panel article-body content-body">
                    <h1 class="text-center">{{ article.title }}</h1>
                    <div class="article-meta text-center">
                        <i class="fa fa-clock-o"></i>
                    </div>
                    <div class="entry-content">
                        <div class="content-body entry-content panel-body ">
                            <div class="markdown-body" v-html="article.body"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import 'mavon-editor/dist/css/index.css'

    export default {
        name: 'Content',
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

        }
    }
</script>

<style scoped>

</style>