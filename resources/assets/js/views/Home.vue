<template>
    <div>
        <Message :show.sync="msgShow" :type="msgType" :msg="msg"/>
    </div>
</template>

<script>
    export default {
        name: 'Home',
        data() {
            return {
                msg: '', // 消息
                msgType: '', // 消息类型
                msgShow: false // 是否显示消息，默认不显示
            }
        },
        beforeRouteEnter(to, from, next) {
            const fromName = from.name

            next(vm => {
                switch (fromName) {
                    case 'Register':
                        if (localStorage.getItem('jwt-token')) {
                            vm.showMsg('注册成功')
                        }
                        break
                }
            })
        },
        methods: {
            showMsg(msg, type = 'success') {
                this.msg = msg
                this.msgType = type
                this.msgShow = true
            }
        }
    }
</script>

<style scoped>

</style>