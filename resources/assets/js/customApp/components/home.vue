<template>

    <div id="home">
        <div class="title m-b-md">
            Home
        </div>

        <div v-if="auth">
            <div v-for="(user_data, index) in user" v-if="user.length > 0">
                <h3>
                    Welcome to Home, <span id="currUser">{{ user_data.name }}</span>
                </h3>
            </div>
        </div>
        <div v-if="!auth">
            Welcome to Home, guest
        </div>
    </div>

</template>

<script>
    let auth;

    export default {
        name: 'home',
        beforeCreate() {
        },
        created() {
            auth = this.$root.authenticated;
            //this.getUserRole();

        },
        data() {
            return {
                user: [],
                auth: this.$root.authenticated
            }
        },
        methods: {
            /*getUserRole() {
                if(auth) {
                    return axios.post('/userrole', {})
                        .then(response => {
                            if (response.data.user) {
                                return this.user = response.data.user;
                            }
                        })
                        .catch(error => {
                            console.log(error.response);
                            this.$root.updateCrsf();
                        });
                }
            },*/
        },
    }
</script>
