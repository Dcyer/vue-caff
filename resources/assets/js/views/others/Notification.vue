<template>
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-body">

                    <h3 class="text-center">
                        <span class="glyphicon glyphicon-bell" aria-hidden="true"></span> 我的通知
                    </h3>
                    <hr>

                    <div class="notification-list" v-if="notification_count > 0" v-for="(notification,index) in notifications">
                        <div class="media">
                            <div class="avatar pull-left">
                                <router-link :to="`/users/${notification.data.user_id}/articles`">
                                    <img class="media-object img-thumbnail" :src="notification.data.user_avatar"  style="width:48px;height:48px;"/>
                                </router-link>
                            </div>

                            <div class="infos">
                                <div class="media-heading">
                                    <router-link :to="`/users/${notification.data.user_id}/articles`">
                                        {{ notification.data.user_name }}
                                    </router-link>
                                    评论了
                                    <router-link :to="notification.data.article_link">
                                        {{ notification.data.article_title }}
                                    </router-link>

                                    <span class="meta pull-right" title="2018-02-01">
                                        <span class="glyphicon glyphicon-clock" aria-hidden="true"></span>
                                        {{ notification.created_at }}
                                    </span>
                                </div>
                                <div class="reply-content" v-html="notification.data.comment_body"></div>
                            </div>
                        </div>
                    </div>

                    <div class="empty-block" v-else>没有消息通知！</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    export default {
        name: "Notification",
        computed: mapState({
            notification_count: state => state.users.me.notification_count,
        }),
        data() {
            return {
                notifications: []
            }
        },
        created() {
            this.$store.dispatch('getNotifications').then(response => {
                this.notifications = response.data.data
            })
        },
    }
</script>

<style scoped>

</style>