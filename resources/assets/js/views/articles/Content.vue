<template>
    <div class="col-md-9 left-col pull-right">
        <div class="panel article-body content-body">
            <h1 class="text-center">{{ article.title }}</h1>
            <div class="article-meta text-center">
                <i class="fa fa-clock-o"></i>
                <abbr>{{ article.created_at }}</abbr> ● {{ article.view_count }} 阅读
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
                    <a @click="vote" href="javascript:;" class="vote btn btn-primary popover-with-html"
                       :class="voteClass">
                        <i class="fa fa-thumbs-up"></i> {{ voteClass ? '已赞' : '点赞' }}
                    </a>
                    <div class="or"></div>
                    <button @click="showQrcode = true" class="btn btn-success"><i class="fa fa-heart"></i> 打赏</button>
                </div>
                <div class="voted-users">
                    <div class="user-lists">
                        <span v-for="voteUser in voteUsers">
                            <!-- 点赞用户是当前用户时，加上类 animated 和 swing 以显示一个特别的动画  -->
                            <img :src="voteUser && voteUser.avatar" class="img-thumbnail avatar avatar-middle"
                                 :class="{ 'animated swing' : voteUser.id === user_id }">
                        </span>
                    </div>
                    <div v-if="!voteUsers.length" class="vote-hint">成为第一个点赞的人吧 ?</div>
                </div>
            </div>
        </div>

        <!-- 打赏弹窗 -->
        <Modal :show.sync="showQrcode" class="text-center">
            <div v-if="user" slot="title">
                <img :src="user.avatar" class="img-thumbnail avatar" width="48">
            </div>
            <div>
                <p class="text-md">如果你想学习更多前端的知识，VuejsCaff.com 是个不错的开始</p>
                <div class="payment-qrcode inline-block">
                    <h5>扫一扫打开 VuejsCaff.com</h5>
                    <p>
                        <qrcode-vue value="https://vuejscaff.com/" :size="160"></qrcode-vue>
                    </p>
                </div>
            </div>
            <div slot="footer">
                <div class="text-center">祝你学习愉快 :)</div>
            </div>
        </Modal>

        <!-- 评论框 -->
        <div id="reply-box" class="reply-box form box-block">
            <div class="form-group comment-editor">
                <mavon-editor
                        v-if="auth"
                        :value="excerpt"
                        code-style="paraiso-dark"
                        :ishljs="true"
                        :subfield="false"
                        :toolbarsFlag="false"
                        @change="markBody"
                        placeholder="请使用 Markdown 格式书写 ;-)，代码片段黏贴时请注意使用高亮语法。"
                        ref="md"
                />
                <textarea v-else disabled class="form-control" placeholder="需要登录后才能发表评论."
                          style="height:172px"></textarea>
            </div>
            <div class="form-group reply-post-submit">
                <button id="reply-btn" :disabled="!auth" @click="comment" class="btn btn-primary">回复</button>
                <!--<span class="help-inline">Ctrl+Enter</span>-->
            </div>
            <div v-show="commentHtml" id="preview-box" class="box preview markdown-body" v-html="commentHtml"></div>
        </div>

        <!-- 评论列表 -->
        <div class="replies panel panel-default list-panel replies-index">
            <div class="panel-heading">
                <div class="total">
                    回复数量: <b>{{ comments.length }}</b>
                </div>
            </div>
            <div class="panel-body">
                <transition-group id="reply-list" name="fade" tag="ul" class="list-group row">
                    <li v-for="(comment, index) in comments" :key="comment.id" class="list-group-item media">
                        <div class="avatar avatar-container pull-left">
                            <router-link :to="`/users/${comment.user.id}/articles`">
                                <img :src="comment.user.avatar" class="media-object img-thumbnail avatar avatar-middle">
                            </router-link>
                        </div>
                        <div class="infos">
                            <div class="media-heading">
                                <router-link :to="`/users/${comment.user.id}/articles`"
                                             class="remove-padding-left author rm-link-color">
                                    {{ comment.user.name }}
                                </router-link>

                                <!-- 编辑删除图标 -->
                                <span v-if="auth" class="operate pull-right">
                                    <span v-if="comment.user_id === user_id">
                                        <a href="javascript:;" @click="deleteComment(comment.id)"><i class="fa fa-trash-o"></i></a>
                                    </span>
                                </span>

                                <div class="meta">
                                    <a :id="`reply${index + 1}`" :href="`#reply${index + 1}`" class="anchor">#{{ index +
                                        1 }}</a>
                                    <span> ⋅ </span>
                                    <abbr class="timeago">
                                        {{ comment.created_at }}
                                    </abbr>
                                </div>
                            </div>

                            <div class="preview media-body markdown-reply markdown-body" v-html="comment.body"></div>
                        </div>
                    </li>
                </transition-group>
                <div v-show="!comments.length" class="empty-block">
                    暂无评论~~
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import QrcodeVue from 'qrcode.vue'
    import {mavonEditor} from 'mavon-editor'

    export default {
        name: 'Content',
        components: {
            QrcodeVue,
            mavonEditor
        },
        computed: mapState({
            auth: state => state.users.auth,
            user_id: state => state.users.me.id,
            user: state => state.users.me,
        }),
        data() {
            return {
                article: {},
                voteUsers: [], // 点赞用户列表
                voteClass: '', // 点赞样式
                showQrcode: false, // 是否显示打赏弹窗
                commentHtml: '',
                comments: [],
                excerpt: '',
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
                        this.renderComments(response.data.comments.data)
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
            markBody(value, render) {
                this.commentHtml = render
                this.excerpt = value
            },
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
            // 发表评论
            comment() {
                if (this.excerpt && this.commentHtml.trim() !== '') {
                    const params = {
                        articleId: this.articleId,
                        body: this.commentHtml,
                        excerpt: this.excerpt
                    }
                    this.$store.dispatch('postComments', params).then(response => {
                        this.commentHtml = ''
                        this.excerpt = ''
                        this.renderComments(response.data.data)
                    }).catch(error => {
                        if (error.response.status === 422) {
                            for (let item in error.response.data.errors) {
                                setTimeout(() => {
                                    this.$notify.error({
                                        title: '评论失败',
                                        message: error.response.data.errors[item][0],
                                        duration: 5000,
                                        offset: 80
                                    });
                                }, 100)
                            }
                        }
                    })
                    // 使回复按钮获得焦点
                    document.querySelector('#reply-btn').focus()
                    // 将最后的评论滚动到页面的顶部
                    this.$nextTick(() => {
                        const lastComment = document.querySelector('#reply-list li:last-child')
                        if (lastComment) lastComment.scrollIntoView(true)
                    })
                }
            },
            // 删除评论
            deleteComment(commentId) {
                this.$swal({
                    text: '你确定要删除此评论吗?',
                    confirmButtonText: '删除'
                }).then((res) => {
                    if (res.value) {
                        const params = {
                            articleId: this.articleId,
                            commentId: commentId,
                        }
                        this.$store.dispatch('deleteComment', params).then(response => {
                            this.renderComments(response.data.data)
                        })
                    }
                })
            },
            // 渲染评论
            renderComments(comments) {
                if (Array.isArray(comments)) {
                    this.comments = comments
                }
            },
        }
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>