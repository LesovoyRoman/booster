import './../bootstrap'
import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue);

import appBase from './vue/app.vue'

import VueRouter from 'vue-router'
Vue.use(VueRouter);

import Sweetalert from 'vue-sweetalert2'
Vue.use(Sweetalert)

import home from './components/home.vue'
import login from './components/auth/login.vue'
import notFound from './components/notFound.vue'
//import registerPerformer from './components/auth/registerPerformer.vue'
//import registerBlogger from './components/auth/registerBlogger.vue'
import register from './components/auth/register.vue'

const defaultPage = 'login';
const homePage = 'home';

let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let authenticated = false;
let router;
let routes = [];
let vm = {};
let bgimages_routes = [
    {path: '/login', img: '/images/bglogin1.png'},
    {path: '/registration', img: '/images/bgregister1.png'},
];

function authCheck() {
    axios.post('/authCheck',
    ).then(response => {
        authenticated = response.data === 200;
        localStorage.setItem('authenticated', true);
        routesAllowToUse(authenticated);
    })
        .catch(error => {
            authenticated = false;
            localStorage.setItem('authenticated', false);
            routesAllowToUse(authenticated);
        });

}
authCheck();

function routesAllowToUse() {
    routes = [
        { path: '/', component: home, name: 'home', meta: { nothingImg: true } },
        { path: "*", component: notFound, name: 'notFound', meta: { nothingImg: true } },
        { path: '/login', component: login, name: 'login',  meta: { redirectHome: true } },
        { path: '/registration', component: register, name: 'Register', meta: { redirectHome: true } },

        /*
         * redirectHome - if authenticated then redirect
         * */
    ];

    router = new VueRouter({
        routes,
        mode: 'history'
    });

    checkRoutes();
}

function checkRoutes() {
    router.beforeEach((to, from, next) => {
        const isAuth = localStorage.getItem('authenticated');
        if (to.meta.requiresAuth) {

        } else {
            if(to.meta.redirectHome && JSON.parse(isAuth)) {
                next({name: homePage})
            } else {
                if(to.meta.nothingImg) {
                    document.getElementById('bg_app').style.background = 'url("/images/bglogin1.png") no-repeat center/cover';
                }
                next();
            }

        }
    });

    app();
}

function app() {
    const app = new Vue({
        el: '#app',
        template: '<appBase></appBase>',
        components: { appBase },
        router,
        data() {
            return {
                authenticated: authenticated,
                vmThis: this,
            }
        },
        created() {
            vm = this;
            bgimages_routes.forEach(function (item) {
                if(item.path === vm.$route.path) {
                    vm.changeBg(item.img);
                }
            })
        },
        mounted() {
            this.$nextTick(function () {
                document.getElementById('bg_app').style.height = document.getElementById('app').offsetHeight + 'px';
            })
        },
        methods: {
            changeHeight(){
                document.getElementById('bg_app').style.height = document.getElementById('app').offsetHeight + 'px';
            },
            statusAuth (data, redirectTo) {
                this.authenticated = data;
                authenticated = data;
                localStorage.setItem('authenticated', data);

                this.updateCrsf(redirectTo);
            },
            changeBg(path, position) {
                position = position || 'center';
                document.getElementById('bg_app').style.backgroundImage = 'url(' + path + ')';
                document.getElementById('bg_app').style.backgroundPosition = position;
            },
            updateCrsf(redirect) {
                axios.get('/sessionSetCsrf',
                ).then(response => {
                    console.log('old ' + token);
                    console.log('new ' + response.data);
                    token = response.data;
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', token);
                    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
                    if (token) { window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token; } else { }
                    if(redirect) {
                        this.$router.push(redirect);
                    }
                })
                    .catch(error => {
                        console.log(error.response);
                    });
            }
        },
        watch:{
            $route (to, from){
                bgimages_routes.forEach(function (item) {
                    if(item.path === to.path) {
                        vm.changeBg(item.img);
                    }
                })
            }
        }
    }).$mount('#app');
}
