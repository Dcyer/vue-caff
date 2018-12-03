<template>
    <div class="row">
        <div class="col-md-4 col-md-offset-4 floating-box">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">请登录</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group" :class="{'has-error': errors.has('email')}">
                        <label class="control-label">邮箱</label>
                        <input
                                v-model="email"
                                v-validate="'required|email'"
                                data-vv-as="邮箱"
                                name="email" type="text" class="form-control" placeholder="请填写邮箱">
                        <span class="help-block" v-show="errors.has('email')">{{ errors.first('email') }}</span>
                    </div>
                    <div class="form-group" :class="{'has-error': errors.has('password')}">
                        <label class="control-label">密码</label>
                        <input
                                v-model="password"
                                v-validate="'required|min:6'"
                                data-vv-as="密码"
                                name="password" type="password" class="form-control" placeholder="请填写密码" ref="password">
                        <span class="help-block" v-show="errors.has('password')">{{ errors.first('password') }}</span>
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
            login() {
                this.$validator.validate().then(result => {
                    if (result) {
                        const params = {
                            email: this.email,
                            password: this.password
                        }

                        this.$store.dispatch('login', params).then(response => {
                            this.$store.dispatch('getMe')
                            this.$message.success('登录成功')
                            this.$router.push('/')
                        }).catch(error => {
                            if (error.response.status === 422) {
                                for (let item in error.response.data.errors) {
                                    this.$validator.errors.add({field: item, msg: error.response.data.errors[item][0]});
                                }
                            } else if (error.response.status === 401) {
                                this.$validator.errors.add({field: 'password', msg: error.response.data.message});
                            }
                        })
                    }
                })
            },
        }
    }
</script>

<style scoped>

</style>