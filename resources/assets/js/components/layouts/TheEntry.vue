<template>
    <div class="navbar-right">
        <ul v-if="auth" class="nav navbar-nav github-login">
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
                this.$store.dispatch('logout')
            }
        },
    }
</script>

<style scoped>

</style>