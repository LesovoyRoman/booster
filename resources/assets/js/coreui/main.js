// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.

let role_meta = document.querySelector('meta[name="user_role"]').getAttribute('content'); // setting user
localStorage.setItem('user_role', role_meta);

import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import Datepicker from 'vuejs-datepicker'
import { id } from 'vuejs-datepicker/dist/locale'
import Notifications from 'vue-notification'
import Sweetalert from 'vue-sweetalert2'
import Loading from './components/Loading'
import App from './App'
import router from './router'
import store from './store'

Vue.use(BootstrapVue)
Vue.use(Notifications)
Vue.use(Sweetalert)

console.log('router user role -> ' + role_meta)

router.beforeEach((to, from, next) => {
    if (to.meta.role_admin && role_meta !== 'admin') {
        next({ name: 'dashboard' })
    } else {
        next();
    }
});

Vue.component('b-loading', Loading)
Vue.component('b-datepicker', {
  extends: Datepicker,
  props  : {
    bootstrapStyling: {
      type   : Boolean,
      default: true,
    },
    language: {
      type   : Object,
      default: () => id,
    },
  },
})

function getRole() {
    axios.post('/authCheck',
    ).then(response => {
        if(response.data === 500) {
          // notRegistered
        } else {
          console.log('user_role ' + response.data)
          localStorage.setItem('user_role', response.data);
        }
    })
    .catch(error => {
        localStorage.setItem('user_role', false);

        // @todo break app!
    });

}
getRole();

window.Vue = new Vue({
  el        : '#app',
  router    : router,
  store     : store,
  template  : '<App/>',
  components: {
    App,
  },
  data(){
    return {

    }
  }
})
