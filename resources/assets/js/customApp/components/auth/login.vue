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
                    <router-link class="float-link" v-bind:to="'/resetPassword'">Forgot password?</router-link>

                    <button type="submit" class="btn btn-primary" onclick="event.preventDefault()"  @click="loginData()">submit</button>
                </div>

                <div class="form-group">
                    <router-link class="" v-bind:to="'/registration'"><span class="color-dark">Do not have an account?</span> REGISTRATION</router-link>
                </div>
            </form>
        </div>
    </div>

</template>

<script>
    let vmThis = {};
    import Loading from 'vue-loading-spinner/src/components/Circle10'

    export default {
        name: 'login',
        components: {
            Loading
        },
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
                    if (response.data.errors) {
                        let strErrors = '';
                        let count = 0;
                        for (let val in response.data.errors) {
                            count++;
                            strErrors += '<span>' + count + ') ' + response.data.errors[val] + '</span> ' + '<br>';
                        }
                        vmThis.$swal('There are some problems:', strErrors, 'error')
                    } else {
                        switch (response.data) {
                            case 1:
                                // admin
                                window.location.href = '/dashboard';
                                break;
                            case 2:
                                // performer
                                window.location.href = '/dashboard';
                                break;
                            case 3:
                                // influencer
                                window.location.href = '/dashboard';
                                break;
                            case 4:
                                // assistant
                                window.location.href = '/dashboard';
                                break;
                            default:
                                break;
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