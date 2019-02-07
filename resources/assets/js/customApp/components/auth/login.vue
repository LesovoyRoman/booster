<template>

    <div id="login">
        <div v-if="!auth">
            <div class="title m-b-md">
                Login
            </div>
            <form action="" id="form_login" v-model="actionURI">
                <div class="form-group row">
                    <label for="email" class="col-form-label text-md-right">Email</label>
                    <input type="text" class="form-control" id="email" name="email" v-model="credentials.email">
                </div>
                <div class="form-group row">
                    <label for="password" class="col-form-label text-md-right">Password</label>
                    <input type="password" class="form-control" id="password" name="password" v-model="credentials.password">
                </div>
                <div class="form-group row">
                    <button type="submit" class="btn btn-primary" onclick="event.preventDefault()"  @click="loginData()">submit</button>
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
                    if(response.data === 1111) {
                        window.location.href = '/dashboard';
                    } else {
                        switch (response.status) {
                            case 200:
                                vmThis.$root.statusAuth(true, '/');
                                break;

                            default:
                                break
                        }
                    }
                })
                    .catch(error => {
                        console.log(error.response);
                        vmThis.$root.updateCrsf();
                    });
            },
        },
        created () {
            vmThis = this;
        },
    }
</script>