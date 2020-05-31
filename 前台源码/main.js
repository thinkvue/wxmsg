import Vue from 'vue'
import Vuex from 'vuex'
import {mapGetters,mapMutations} from 'vuex'
import store from './store'
import App from './App'
import http from './unit/http.js'
import _g from './unit/global.js'
import config from './config.js'
import './js_sdk/ican-H5Api/ican-H5Api.js'

window._g = _g

//color标题栏组件
import cuCustom from './colorui/components/cu-custom.vue'
Vue.component('cu-custom',cuCustom)

Vue.config.productionTip = false
Vue.prototype.$fire = new Vue();
Vue.prototype.$store = store;
Vue.prototype.$http = http;
Vue.prototype.$config=config;

App.mpType = 'app'

const app = new Vue({
    ...App
})
app.$http.mount(app)
app.$mount()