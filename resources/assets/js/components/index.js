import Vue from 'vue'
import Modal from './Modal'
import Pagination from './Pagination'
import Slider from './Slider'

const components = {
    Modal,
    Pagination,
    Slider
}

for (const [key, value] of Object.entries(components)) {
    Vue.component(key, value)
}