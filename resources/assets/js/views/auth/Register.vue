<template>
    <div class="row">
        <div class="col-md-4 col-md-offset-4 floating-box">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">请注册</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group" :class="{'has-error': errors.has('name')}">
                        <label class="control-label">用户名</label>
                        <input
                                v-model="name"
                                v-validate="'required|min:4'"
                                data-vv-as="用户名"
                                name="name" type="text" class="form-control" placeholder="请填写用户名">
                        <span class="help-block" v-show="errors.has('name')">{{ errors.first('name') }}</span>
                    </div>
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
                    <div class="form-group" :class="{'has-error': errors.has('password_confirmation')}">
                        <label class="control-label">确认密码</label>
                        <input
                                v-model="password_confirmation"
                                v-validate="'required|confirmed:password'"
                                data-vv-as="确认密码"
                                name="password_confirmation" type="password" class="form-control" placeholder="请填写确认密码">
                        <span class="help-block" v-show="errors.has('password_confirmation')">{{ errors.first('password_confirmation') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="control-label">图片验证码</label>
                        <input type="text" class="form-control" placeholder="请填写验证码">
                    </div>
                    <div class="thumbnail" title="点击图片重新获取验证码">
                        <div class="captcha"></div>
                    </div>
                    <button type="submit" class="btn btn-lg btn-success btn-block">
                        <i class="fa fa-btn fa-sign-in"></i> 注册
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Register',
        data() {
            return {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                captcha_code: '',
                captcha_key: '',
            }
        },
    }
</script>

<style scoped>
    .thumbnail {
        width: 170px;
        margin-top: 10px;
        cursor: pointer;
    }

    .thumbnail .captcha {
        height: 46px;
        background: #E1E6E8;
    }
</style>