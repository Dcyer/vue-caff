<template>
    <div class="blog-container">
        <div class="blog-pages">
            <div class="col-md-12 panel">
                <div class="panel-body">
                    <h2 class="text-center">创作文章</h2>
                    <hr>
                    <div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="请填写标题">
                        </div>
                        <div class="form-group">
                            <mavon-editor
                                    v-model="content"
                                    code-style="monokai"
                                    :ishljs="true"
                                    :subfield="false"
                                    placeholder="请使用 Markdown 格式书写 ;-)，代码片段黏贴时请注意使用高亮语法。"
                            />
                        </div>
                        <br>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">发 布</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mavonEditor} from 'mavon-editor'
    import 'mavon-editor/dist/css/index.css'

    export default {
        name: 'Create',
        components: {
            mavonEditor
        },
        data() {
            return {
                title: '',
                content: ''
            }
        },
        created() {

        }
    }
</script>

<style scoped>
    .blog-container {
        max-width: 980px;
        margin: 0 auto;
        margin-top: 20px;
    }

    textarea {
        height: 200px;
    }
</style>