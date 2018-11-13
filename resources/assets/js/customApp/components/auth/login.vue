<template>

    <div id="login">
        <div v-if="!auth">
            <form action="" id="form_login" v-model="actionURI">
                <!--<div class="title m-b-md">
                    Login
                </div>-->
                <div class="form-group">
                    <label for="email" class="col-form-label text-md-right">Email</label>
                    <input type="text" class="form-control" id="email" name="email" v-model="credentials.email">
                </div>
                <div class="form-group">
                    <label for="password" class="col-form-label text-md-right">Password</label>
                    <input type="password" class="form-control" id="password" name="password" v-model="credentials.password">
                </div>
                <div class="form-group">
                    <router-link class="float-link" v-bind:to="'/password-rescue'">Forgot password?</router-link>

                    <button type="submit" class="btn btn-primary" onclick="event.preventDefault()"  @click="loginData()">submit</button>
                </div>

                <div class="form-group">
                    <router-link class="" v-bind:to="'/register-performer'"><span class="color-dark">Do not have an account?</span> REGISTRATION</router-link>
                </div>
            </form>
        </div>
    </div>

</template>

<script>
    let vmThis = {};

    export default {
        name: 'login',
        data() {
            return {
                credentials: {
                    email: '',
                    password: '',
                },
                actionURI: location.href,
                auth: this.$root.authenticated
            }
        },
        methods: {
            loginData: function () {
                let dataCredentials = {
                    email: this.credentials.email,
                    password: this.credentials.password
                };
                axios.post(this.actionURI, dataCredentials, {
                    headers: {
                        "Access-Control-Allow-Origin": "*",
                        "Access-Control-Allow-Credentials": "true",
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    withCredentials: true
                }).then(function (response) {
                    //console.log('response->');
                    //console.log(response)
                    if(response.data === 1) {
                        // admin
                        window.location.href = '/dashboard';
                    } else if (response.data === 2) {
                        // performer
                        window.location.href = '/dashboard';
                    }  else if (response.data === 3) {
                        // influencer
                        window.location.href = '/dashboard';
                    }  else if (response.data === 4) {
                        // assistant
                        window.location.href = '/dashboard';
                    } else {
                        // user
                        switch (response.status) {
                            case 200:
                                vmThis.$root.statusAuth(true, '/');
                                break;

                            default:
                                break
                        }
                    }
                })
            },
        },
        created () {
            vmThis = this;
            this.$root.changeHeight();
        },
        updated() {
            this.$root.changeHeight();
        }
    }
</script>