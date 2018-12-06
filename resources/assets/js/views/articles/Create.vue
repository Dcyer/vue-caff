<template>
    <div class="blog-container">
        <div class="blog-pages">
            <div class="col-md-12 panel">
                <div class="panel-body">
                    <h2 class="text-center">{{ this.articleId !== undefined ? '编辑' : '创作' }}文章</h2>
                    <hr>
                    <div>
                        <div class="form-group">
                            <el-input placeholder="请输入标题" v-model="title" class="input-with-select">
                                <el-select v-model="category_id" slot="prepend" clearable placeholder="请选择文章分类">
                                    <el-option v-for="(category, index) in categories" :key="category.id"
                                               :label="category.name" :value="category.id"></el-option>
                                </el-select>
                            </el-input>
                        </div>
                        <div class="form-group">
                            <mavon-editor
                                    :value="defaultValue"
                                    code-style="paraiso-dark"
                                    :ishljs="true"
                                    :subfield="false"
                                    placeholder="请使用 Markdown 格式书写 ;-)，代码片段黏贴时请注意使用高亮语法。"
                                    @change="markBody"
                                    @imgAdd="$imgAdd"
                                    @imgDel="$imgDel"
                                    ref="md"
                            />
                        </div>
                        <br>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" @click="handle">{{ this.articleId ===
                                undefined ? '发 布' : '更 新' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mavonEditor} from 'mavon-editor'
    import emoji from 'markdown-it-emoji'

    mavonEditor.mixins[0].data().markdownIt.set({emoji})

    export default {
        name: 'Create',
        components: {
            mavonEditor
        },
        data() {
            return {
                title: '',
                body: '',
                category_id: '',
                articleId: undefined,
                defaultValue: ''
            }
        },
        computed: {
            categories: {
                get() {
                    return this.$store.state.categories.categories
                },
            },
        },
        created() {
            this.articleId = this.$route.params.articleId
            if (this.articleId !== undefined) {
                this.$store.dispatch('getArticle', this.articleId).then(response => {
                    this.title = response.data.title
                    this.category_id = response.data.category_id
                    this.body = response.data.body
                    this.defaultValue = response.data.excerpt
                })
            }
        },
        methods: {
            markBody(value, render) {
                this.body = render
                this.excerpt = value
            },
            handle() {
                if (this.articleId === undefined) {
                    this.publishArticles()
                } else {
                    this.updateArticle()
                }
            },
            publishArticles() {
                this.$store.dispatch('postArticles', {
                    title: this.title,
                    category_id: this.category_id,
                    body: this.body,
                    excerpt: this.excerpt,
                }).then(response => {
                    this.$message.success('发布成功')
                    this.$router.push({name: 'Content', params: {userId: this.$store.state.users.me.id, articleId: response.data.article_id}})
                }).catch(error => {
                    if (error.response.status === 422) {
                        for (let item in error.response.data.errors) {
                            setTimeout(() => {
                                this.$notify.error({
                                    title: '发布失败',
                                    message: error.response.data.errors[item][0],
                                    duration: 5000,
                                    offset: 80
                                });
                            }, 100)
                        }
                    }
                })
            },
            updateArticle() {
                this.$store.dispatch('updateArticle', {
                    articleId: this.articleId,
                    title: this.title,
                    category_id: this.category_id,
                    body: this.body,
                    excerpt: this.excerpt,
                }).then(response => {
                    this.$message.success('更新成功')
                    this.$router.push({name: 'Content', params: {articleId: this.articleId}})
                }).catch(error => {
                    if (error.response.status === 422) {
                        for (let item in error.response.data.errors) {
                            setTimeout(() => {
                                this.$notify.error({
                                    title: '发布失败',
                                    message: error.response.data.errors[item][0],
                                    duration: 5000,
                                    offset: 80
                                });
                            }, 100)
                        }
                    }
                })
            },
            $imgAdd(pos, $file) {
                var formdata = new FormData();
                formdata.append('file', $file);

                this.$store.dispatch('postArticleImages', formdata).then(response => {
                    this.$refs.md.$img2Url(pos, response.data.path);
                })
            },
            $imgDel(pos, $file) {

            },
        },
    }
</script>

<style>
    .blog-container {
        max-width: 980px;
        margin: 0 auto;
        margin-top: 20px;
    }

    textarea {
        height: 200px;
    }

    .el-select .el-input {
        width: 155px;
    }

    .input-with-select .el-input-group__prepend {
        background-color: #fff;
    }

    .v-note-wrapper {
        height: 500px;
    }
</style>