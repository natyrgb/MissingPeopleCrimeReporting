require('./bootstrap')
import ViewUI from 'vue-design'
import Router from 'vue-router'
import router from './router'
import { Form, HasError, AlertError } from 'vform'
window.Vue = require('vue')
import Axios from 'axios'
import store from './store'
import VueSweetalert2 from 'vue-sweetalert2';

// axios setup
Vue.prototype.$http = Axios
const token = localStorage.getItem('token')
if (token) {
    Vue.prototype.$http.defaults.headers.common['Authorization'] = 'Bearer '+token
}


Vue.use(ViewUI)
Vue.use(Router)
Vue.use(VueSweetalert2);


window.Form =Form;

Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component('navbar', require ('./components/Navbar.vue').default)
Vue.component('pagination', require('laravel-vue-pagination'));

const app = new Vue({
    el: '#apps',
    router,
    store
})
