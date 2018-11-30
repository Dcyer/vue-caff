<template>
    <div id="wrap">
        <TheHeader/>
        <div id="main-container" class="container main-container">
            <router-view/>
        </div>
        <TheFooter/>
    </div>
</template>

<script>
    import TheHeader from './components/layouts/TheHeader'
    import TheFooter from './components/layouts/TheFooter'

    export default {
        name: "App",
        components: {
            TheHeader,
            TheFooter
        },
        created() {
            let jwt = this.$ls.getItem('jwt-token')
            if (jwt) {
                this.$store.dispatch('getMe')
            }
        }
    }
</script>

<style scoped>

</style>