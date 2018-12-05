<template>
    <div class="col-md-9 left-col">
        <div class="panel panel-default padding-md">
            <div class="panel-body">
                <h2><i class="fa fa-picture-o"></i> 请输入头像地址</h2>
                <hr>
                <div>
                    <el-upload drag :show-file-list="false" :http-request="uploadAvatar" action="">
                        <i class="el-icon-upload"></i>
                        <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
                    </el-upload>
                </div>
                <div>
                    <div class="form-group">
                        <label>头像预览：</label>
                        <div>
                            <img :src="avatar" class="avatar-preview-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'EditAvatar',
        computed: {
            avatar: {
                get() {
                    return this.$store.state.users.me.avatar
                }
            }
        },
        methods: {
            uploadAvatar(e) {
                let param = new FormData()
                param.append('file',e.file)
                this.$store.dispatch('postAvatars', param).then(response => {
                    this.$message.success('修改成功')
                })
            }
        }
    }
</script>

<style>
    .avatar-preview-img {
        min-width: 200px;
        min-height: 200px;
        max-width: 50%;
    }
    .el-icon-plus input[type=file] {
        display: none;
    }
    .el-upload__input[type=file] {
        display: none !important;
    }
</style>