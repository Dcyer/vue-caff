<template>
    <div class="col-md-9 left-col">
        <div class="panel panel-default padding-md">
            <div class="panel-body">
                <h2><i class="fa fa-cog"></i> 编辑个人资料</h2>
                <hr>
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名</label>
                        <div class="col-sm-6">
                            <input v-model="name" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">个人简介</label>
                        <div class="col-sm-6">
                            <textarea v-model="introduction" type="text" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-6">
                            <button type="submit" class="btn btn-primary" @click="updateProfile">应用修改</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'EditProfile',
        computed: {
            name: {
                get() {
                    return this.$store.state.users.me.name
                },
                set(value) {
                    this.$store.state.users.me.name = value
                }
            },
            introduction: {
                get() {
                    return this.$store.state.users.me.introduction
                },
                set(value) {
                    this.$store.state.users.me.introduction = value
                }
            }
        },
        methods: {
            updateProfile() {
                this.$store.dispatch('updateMe', {
                    name: this.name,
                    introduction: this.introduction,
                })
                this.$msg.show('修改成功')
            }
        }
    }
</script>

<style scoped>

</style>