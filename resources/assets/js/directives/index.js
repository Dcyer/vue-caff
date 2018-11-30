import Vue from 'vue'
import dropdown from './dropdown'

const directives = {
    dropdown
}

for (const [key, value] of Object.entries(directives)) {
    Vue.directive(key, value)
}