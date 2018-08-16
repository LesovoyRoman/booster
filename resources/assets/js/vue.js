import appBase from './vue/app.vue'

import VueRouter from 'vue-router'
Vue.use(VueRouter);

import VueResource from "vue-resource"
Vue.use(VueResource);

import home from './components/home.vue'
import login from './components/auth/login.vue'
import notFound from './components/notFound.vue'
import register from './components/auth/register.vue'

const defaultPage = 'login';
const homePage = 'home';

let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
let authenticated = false;
let router;
let routes = [];

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
        { path: '/', component: home, name: 'home' },
        { path: "*", component: notFound, name: 'notFound' },
        { path: '/login', component: login, name: 'login',  meta: { redirectHome: true } },
        { path: '/register', component: register, name: 'Register', meta: { redirectHome: true } },

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
            }
        },
        methods: {
            statusAuth (data, redirectTo) {
                this.authenticated = data;
                localStorage.setItem('authenticated', data);
                this.$router.push(redirectTo);

                this.updateCrsf();

            },
            updateCrsf() {
                axios.get('/sessionSetCsrf',
                ).then(response => {
                    token = response.data;
                    document.querySelector('meta[name="csrf-token"]').setAttribute('content', token);
                    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
                    if (token) { window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token; } else { }
                })
                    .catch(error => {
                        console.log(error.response);
                    });
            }
        }
    }).$mount('#app');
}
