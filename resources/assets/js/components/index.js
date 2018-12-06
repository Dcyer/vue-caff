import Vue from 'vue'
import Modal from './Modal'

const components = {
    Modal
}

for (const [key, value] of Object.entries(components)) {
    Vue.component(key, value)
}