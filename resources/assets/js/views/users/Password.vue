<template>
    <div class="col-md-9 left-col">
        <div class="panel panel-default padding-md">
            <div class="panel-body">
                <h2><i class="fa fa-lock"></i> 修改密码</h2>
                <hr>
                <div class="form-horizontal">
                    <div class="form-group" :class="{'has-error': errors.has('password')}">
                        <label class="col-sm-2 control-label">密 码</label>
                        <div class="col-sm-6">
                            <input
                                    v-model="password"
                                    v-validate="'required|min:6'"
                                    data-vv-as="密码"
                                    name="password" type="password" class="form-control" placeholder="请填写密码" ref="password">
                            <span class="help-block" v-show="errors.has('password')">{{ errors.first('password') }}</span>
                        </div>
                    </div>
                    <div class="form-group" :class="{'has-error': errors.has('password_confirmation')}">
                        <label class="col-sm-2 control-label">确认密码</label>
                        <div class="col-sm-6">
                            <input
                                    v-model="password_confirmation"
                                    v-validate="'required|confirmed:password'"
                                    data-vv-as="确认密码"
                                    name="password_confirmation" type="password" class="form-control" placeholder="请填写确认密码">
                            <span class="help-block" v-show="errors.has('password_confirmation')">{{ errors.first('password_confirmation') }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-6">
                            <button type="submit" class="btn btn-primary" @click="updatePassword">应用修改</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'EditPassword',
        data() {
            return {
                password: '',
                password_confirmation: '',
            }
        },
        created() {
            const user = this.$store.state.user

            if (user && typeof user === 'object') {
                this.password = user.password
            }
        },
        methods: {
            updatePassword() {
                this.$validator.validate().then(result => {
                    if (result) {
                        const params = {
                            password: this.password,
                            password_confirmation: this.password_confirmation,
                        }

                        this.$store.dispatch('updatePassword', params).then(response => {
                            this.$message.success('修改成功，请重新登录')
                            this.$store.commit('SET_ME', {})
                            this.$store.commit('SET_AUTH', false)
                            localStorage.clear()
                            this.$router.push('/auth/login')
                        })
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>