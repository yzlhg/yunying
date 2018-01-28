// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import App from './App'
import router from './router'
import store from '@/vuex/store'
import axios from 'axios'
import {post,fetch,patch,put} from './utils/http'
Vue.use(ElementUI)
//定义全局变量
Vue.prototype.$post=post;
Vue.prototype.$fetch=fetch;
Vue.prototype.$patch=patch;
Vue.prototype.$put=put;

new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
