// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.

let role_meta = document.querySelector('meta[name="user_role"]').getAttribute('content'); // setting user
localStorage.setItem('user_role', role_meta);
const storage_path = document.querySelector('meta[name="public_img_path"]').getAttribute('content');

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

let vm = {};

getRole();
router.beforeEach((to, from, next) => {
    const role_influencer = to.matched.some(record => record.meta.role_influencer)
    const role_admin = to.matched.some(record => record.meta.role_admin)
    const role_performer = to.matched.some(record => record.meta.role_performer)

    if (role_admin && role_meta !== 'admin') {
        next('dashboard')
    } else if (role_influencer && role_meta !== 'influencer' && role_meta !== 'admin') {
        next('dashboard')
    } else if (role_performer && role_meta !== 'performer' && role_meta !== 'admin') {
        next('dashboard')
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
    axios.post('/roleCheck',
    ).then(response => {
        if(response.data === 500) {
          // notRegistered
            document.querySelector('meta[name="user_role"]').setAttribute('content', '0'); // setting user
        } else {
            //console.log('user_role ' + response.data.role)
            document.querySelector('meta[name="user_role"]').setAttribute('content', response.data.role); // setting user
            localStorage.setItem('user_role', response.data.role);
        }
    })
    .catch(error => {
        localStorage.setItem('user_role', false);
        document.querySelector('meta[name="user_role"]').setAttribute('content', '0'); // setting user

        // @todo break app!
    });
}


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
        storage_path: storage_path,
        configEnums: {},
    }
  },
    created(){
      vm = this;
      axios.post('/getConfigEnums').then(response => {
          this.configEnums = response.data.enums;
          //console.log(this.configEnums);
      })
    },
    methods: {
        check(){
            return new Promise((resolve, reject) => {
                vm.$swal({
                    title: 'Are you sure?',
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                }).then((result) => {
                    if (result.value) {
                        return resolve(true);
                    } else if(result.dismiss === vm.$swal.DismissReason.cancel) {
                        return reject(false);
                    }
                })
            });
        },
    }
})
