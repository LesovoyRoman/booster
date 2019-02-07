<template>
    <aside class="aside-menu">
        <div v-if="!this.$root.authenticated">
            <b-nav pills vertical>
                <router-link v-for="myroute in routes" v-bind:key="myroute.name" v-bind:to="myroute.to">{{ myroute.name }}</router-link>
            </b-nav>
        </div>
        <div v-if="this.$root.authenticated">
            <b-nav pills vertical>
                <a @click="logout()" href="" onclick="event.preventDefault();">Logout</a>
            </b-nav>
        </div>
    </aside>
</template>

<script>
    export default {
        name      : 'Caside',
        data() {
            return {
                routes: [
                    {to: '/login', name: 'Login'},
                    {to: '/registration', name: 'Registration'},
                ]
            }
        },
        methods: {

        },
    }
</script>