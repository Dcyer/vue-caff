<template>
    <div class="navbar-right">
        <ul v-if="auth" class="nav navbar-nav github-login">
            <li>
                <a v-dropdown href="javascript:;">
                    <i class="fa fa-plus text-md"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <router-link to="/articles/create">
                            <i class="fa fa-paint-brush text-md"></i>
                            创作文章
                        </router-link>
                    </li>
                </ul>
            </li>
            <li>
                <router-link to="/notifications" class="notifications-badge" style="margin-top: -2px;">
                    <span :class="`badge badge-${user.notification_count > 0 ? 'hint' : 'fade'}`" title="消息提醒">
                        {{ user.notification_count }}
                    </span>
                </router-link>
            </li>
            <li>
                <a v-dropdown href="javascript:;">
                    <span v-if="user">
                        <img v-if="user.avatar" :src="user.avatar" class="avatar-topnav">
                        <span v-if="user.name">{{ user.name }}</span>
                    </span>
                    <span v-else>佚名</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li v-if="user">
                        <router-link :to="`/users/${user.id}/articles`">
                            <i class="fa fa-list-ul text-md i-middle"></i>
                            个人专栏
                        </router-link>
                    </li>
                    <li>
                        <router-link :to="`/users/${user.id}/edit`">
                            <i class="fa fa-cog text-md i-middle"></i>
                            编辑资料
                        </router-link>
                    </li>
                    <li><a href="javascript:;" @click="logout"><i class="fa fa-sign-out text-md"></i>退出</a></li>
                </ul>
            </li>
        </ul>
        <div v-else class="nav navbar-nav github-login">
            <router-link to="/auth/login" class="btn btn-default login-btn">
                <i class="fa fa-user"></i> 登 录
            </router-link>
            <router-link to="/auth/register" class="btn btn-default login-btn">
                <i class="fa fa-user-plus"></i> 注 册
            </router-link>
        </div>
    </div>
</template>

<script>
    import {mapState} from 'vuex'

    export default {
        name: 'TheEntry',
        computed: mapState({
            user: state => state.users.me,
            auth: state => state.users.auth
        }),
        methods: {
            logout() {
                this.$store.dispatch('logout').then(response => {
                    this.$message.success('你已退出登录')
                })
            }
        },
    }
</script>

<style scoped>
    .notifications-badge {
        margin-top: -1;
    }

    .badge-fade {
        background-color: #EBE8E8;
    }

    .badge-hint {
        background-color: #d15b47 !important;;
    }
</style>