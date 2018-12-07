<template>
    <div class="navbar-form navbar-left hidden-sm">
        <div class="form-group">
            <input
                    v-model.trim="searchValue"
                    type="text"
                    class="form-control search-input mac-style"
                    placeholder="搜索"
                    @keyup.enter="search"
                    @input="updateSearchValue"
            >
        </div>
    </div>
</template>

<script>
    export default {
        name: 'SearchInput',
        data() {
            return {
                value: '' // 搜索值
            }
        },
        computed: {
            searchValue: {
                get() {
                    return this.$store.state.searchs.searchValue
                },
                set(newValue) {
                    this.value = newValue
                }
            },
            searchResults: {
                get() {
                    return this.$store.state.searchs.searchResults
                },
                set(value) {
                    this.$store.state.searchs.searchResults = value
                }
            }
        },
        methods: {
            search() {
                const value = this.value

                if (value !== '') {
                    this.$router.push({name: 'Search', query: {q: value}})
                }
            },
            updateSearchValue() {
                this.$store.dispatch('updateSearchValue', this.value)
            }
        }
    }
</script>

<style scoped>
    .search-input {
        background-image: url(https://vuejscaffcdn.phphub.org/assets/images/icon-search.png)
    }
</style>