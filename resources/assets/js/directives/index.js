import Vue from 'vue'
import dropdown from './dropdown'
import title from './title'

const directives = {
    dropdown,
    title
}

for (const [key, value] of Object.entries(directives)) {
    Vue.directive(key, value)
}