// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import store from './store'
import MuseUI from 'muse-ui'
import 'muse-ui/dist/muse-ui.css'
import App from './App'
import router from './router'
import ajax from './ajax/config'
import VueLocalStorage from 'vue-localstorage'
import touch from 'vue-directive-touch'
import util from './util/util'

Vue.config.productionTip = false
Vue.prototype.$http = ajax
Vue.use(MuseUI)
Vue.use(VueLocalStorage)
Vue.use(touch)
Vue.prototype.$util = util

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store: store,
  components: { App },
  template: '<App/>',
  watch: {
    $route(to,from){
      this.$store.state.navigator_value = to.path //导航栏active状态
    },
  },
})

