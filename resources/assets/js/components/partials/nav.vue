<template>

    <div id="navVue">
        <header>
            <div v-if="!this.$root.authenticated">
                <div class="links">
                    <router-link v-bind:to="'/login'">Login</router-link>
                    <router-link v-bind:to="'/register'">Registration</router-link>
                    <router-link v-bind:to="'/'">Home</router-link>
                </div>
            </div>
            <div  v-if="this.$root.authenticated">
                <div class="links">
                    <router-link v-bind:to="'/'">Home</router-link>

                    <a @click="logout()" href="" onclick="event.preventDefault();">Logout</a>
                </div>
            </div>
        </header>
    </div>

</template>

<script>
    export default {
        name: 'navVue',
        methods: {
            logout: function() {

                return axios.post('/logout',
                    {

                    }).then(response => {
                        this.$root.statusAuth(false, '/login');
                    })
                    .catch(error => {
                        console.log(error.response);
                        vmThis.$root.updateCrsf();
                    });
            },
        },
    }
</script>