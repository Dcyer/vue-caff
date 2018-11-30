<template>
    <div class="row">
        <div class="col-md-4 col-md-offset-4 floating-box">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">请登录</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label">邮箱</label>
                        <input v-model="email" type="text" class="form-control" placeholder="请填写邮箱">
                    </div>
                    <div class="form-group">
                        <label class="control-label">密码</label>
                        <input v-model.trim="password" type="password" class="form-control" placeholder="请填写密码">
                    </div>
                    <br>
                    <button @click="login" type="submit" class="btn btn-lg btn-success btn-block">
                        <i class="fa fa-btn fa-sign-in"></i> 登录
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Login',
        data() {
            return {
                email: '',
                password: '',

            }
        },
        methods: {
            login(e) {
                const params = {
                    email: this.email,
                    password: this.password
                }

                this.$store.dispatch('login', params).then(response => {
                    this.$router.push('/')
                })
            },
        }
    }
</script>

<style scoped>

</style>