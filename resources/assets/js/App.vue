<template>
    <div id="wrap">
        <TheHeader />
        <TheFooter />
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
    }
</script>

<style scoped>

</style>