<template>
    <div class="panel panel-default list-panel search-results">
        <div class="panel-heading">
            <h3 class="panel-title">
                <i class="fa fa-search"></i>
                关于 “<span class="highlight">{{ keyword }}</span>” 的搜索结果, 共 {{ results.length }} 条
                <!-- 排序方式列表 -->
                <div class="pull-right" style="margin-top:-10px">
                    <button v-for="item in filters"
                            :disabled="item.filter === filter"
                            class="btn btn-default btn-sm"
                            href="javascript:;"
                            @click="getArticlesByKeyword(keyword, item.filter)"
                    >
                        <i :class="`fa fa-${item.icon}`"></i>
                        {{ item.title }}
                    </button>
                </div>
            </h3>
        </div>
        <div class="panel-body">
            <div v-for="result in results" class="result">
                <h2 class="title">
                    <router-link :to="`/users/${result.user.id}/articles/${result.id}/content`">
                        <span v-html="result.title"></span>
                    </router-link>
                    <small>by</small>
                    <router-link :to="`/users/${result.user.id}/articles`">
                        <img :src="result.user.avatar" class="avatar avatar-small">
                        <small>{{ result.user.name }}</small>
                    </router-link>
                </h2>
                <div class="info">
                    <span class="url">
                        <router-link :to="`/users/${result.user.id}/articles/${result.id}/content`">
                            {{ result.url }}
                        </router-link>
                    </span>
                    <span class="date">
                        {{ result.created_at }} ⋅
                        <i class="fa fa-thumbs-o-up"></i> {{ result.vote_count }} ⋅
                        <i class="fa fa-comments-o"></i> {{ result.reply_count }}
                    </span>
                </div>
                <div class="desc" v-html="result.body"></div>
                <hr>
            </div>
            <div v-if="!results.length" class="empty-block">
                没有任何数据~~
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Search',
        data() {
            return {
                keyword: '', // 关键字
                filter: 'default', // 默认排序方式
                filters: [ // 排序方式列表
                    {
                        filter: 'default',
                        title: '相关性排序',
                        icon: 'random'
                    },
                    {
                        filter: 'vote',
                        title: '点赞数排序',
                        icon: 'thumbs-up'
                    }
                ],
                results: []
            }
        },
        watch: {
            '$route'(to) {
                this.getArticlesByKeyword(to.query.q)
            }
        },
        beforeRouteEnter(to, from, next) {
            next(vm => {
                // 确认渲染该组件的对应路由时，获取搜索结果
                vm.getArticlesByKeyword(to.query.q)
            })
        },
        // 当前路由改变，该组件被复用时，获取搜索结果
        beforeRouteUpdate(to, from, next) {
            this.getArticlesByKeyword(to.query.q)
            next()
        },
        // 离开该组件的对应路由时，清空搜索值
        beforeRouteLeave(to, from, next) {
            this.$store.dispatch('updateSearchValue', '')
            next()
        },
        methods: {
            // 使用关键字 keyword 获取搜索结果
            getArticlesByKeyword(keyword, filter = 'default') {
                this.keyword = keyword
                this.filter = filter
                if (keyword) {
                    // 需要提交事件类型，以更新搜索框的值
                    this.$store.dispatch('updateSearchValue', keyword)

                    this.$store.dispatch('getArticles', {search: keyword, order: filter}).then(response => {
                        let articles = response.data.data
                        // 搜索结果
                        let results = []

                        if (Array.isArray(articles)) {
                            articles.forEach((article) => {
                                let {id, title, body, user_id} = article
                                // 该正则表示文章标题或内容中的关键字
                                const regex = new RegExp(`(${this.keyword})`, 'gi')

                                if (title.indexOf(this.keyword) !== -1 || body.indexOf(this.keyword) !== -1) {
                                    // url 是文章中没有的数据，我们结合 articleId 拼出完整的路径
                                    const url = `${location.origin}/users/${user_id}/articles/${id}/content`
                                    // 给文章标题中的关键字加上高亮，$1 匹配第一个括号的内容
                                    title = title.replace(regex, '<span class="highlight">$1</span>')
                                    // 给文章内容中的关键字加上高亮，只取内容前 100 个字
                                    body = body.substr(0, 100).replace(regex, '<span class="highlight">$1</span>')
                                    // 等价于 results.push(Object.assign({}, article, { url: url, title: title, content: content }))
                                    results.push({...article, ...{url, title, body}})
                                }
                            })
                        }

                        this.results = results
                    })
                }
            },
        }
    }
</script>

<style scoped>
    .result a:hover, .result a:focus {
        color: #d6514d;
        transition: color .15s ease;
    }

    .panel-title .btn {
        margin-left: 5px;
    }
</style>