<template>
    <div>
        <!-- 帖子列表 -->
        <div class="col-md-9 topics-index main-col">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="list-inline topic-filter">
                        <li v-for="item in filters">
                            <router-link
                                    v-title="item.title"
                                    :class="{ active: filter === item.filter }"
                                    :to="`/articles?filter=${item.filter}`">
                                {{ item.name }}
                            </router-link>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body remove-padding-horizontal">
                    <ul class="list-group row topic-list">
                        <li v-for="article in articles" :key="article.id" class="list-group-item">
                            <router-link :to="`/users/${article.user.id}/articles/${article.id}/content`" tag="div"
                                         class="reply_count_area hidden-xs pull-right">
                                <div class="count_set">
                                    <span class="count_of_votes" title="投票数">{{ article.vote_count }}</span>
                                    <span class="count_seperator">/</span>
                                    <span class="count_of_replies" title="回复数">{{ article.reply_count }}</span>
                                    <span class="count_seperator">|</span>
                                    <abbr class="timeago">{{ article.created_at }}</abbr>
                                </div>
                            </router-link>
                            <router-link :to="`/users/${article.user.id}/articles`" tag="div" class="avatar pull-left">
                                <img :src="article.user.avatar" class="media-object img-thumbnail avatar avatar-middle">
                            </router-link>
                            <router-link :to="`/users/${article.user.id}/articles/${article.id}/content`" tag="div"
                                         class="infos">
                                <div class="media-heading">
                                    {{ article.title }}
                                </div>
                            </router-link>
                        </li>
                    </ul>
                </div>

                <!-- 分页组件 -->
                <div class="panel-footer text-right remove-padding-horizontal pager-footer">
                    <Pagination :currentPage="currentPage" :total="pagination.total"
                                :pageSize="pagination.per_page" :onPageChange="changePage"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Home',
        data() {
            return {
                articles: [],
                pagination: {},
                filter: 'default', // 默认过滤方式
                filters: [ // 过滤方式列表
                    {filter: 'default', name: '活跃', title: '最后回复排序'},
                    {filter: 'excellent', name: '精华', title: '只看加精的话题'},
                    {filter: 'vote', name: '投票', title: '点赞数排序'},
                    {filter: 'recent', name: '最近', title: '发布时间排序'},
                    {filter: 'noreply', name: '零回复', title: '无人问津的话题'}
                ],
            }
        },
        beforeRouteEnter(to, from, next) {
            next(vm => {
                // 确认渲染该组件的对应路由时，设置相关数据
                vm.setDataByFilter(to.query.filter)
            })
        },
        computed: {
            currentPage() {
                return parseInt(this.$route.query.page) || 1
            },
        },
        watch: {
            '$route'(to) {
                this.setDataByFilter(to.query.filter)
            }
        },
        created() {
            this.getArticles(this.filter)
        },
        methods: {
            getArticles(filter) {
                this.$store.dispatch('getArticles', {order: filter, page: this.currentPage}).then(response => {
                    this.articles = response.data.data
                    this.pagination = response.data.meta.pagination
                })
            },
            setDataByFilter(filter = 'default') {
                this.filter = filter
                this.getArticles(filter)
            },
            changePage(page) {
                this.$router.push({query: {...this.$route.query, page}})
            }
        }
    }
</script>

<style scoped>

</style>