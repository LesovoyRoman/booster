<template>
    <div id="register">
        <div v-if="!auth">
            <div class="title m-b-md">
                Register
            </div>

            <form action="" v-model="actionURI" id="form_register">
                <div class="form-group row">
                    <label for="name" class="col-form-label text-md-right">Name</label>
                    <input type="text" class="form-control" id="name" name="email" v-model="credentials.name">
                </div>
                <div class="form-group row">
                    <label for="email" class="col-form-label text-md-right">Email</label>
                    <input type="text" class="form-control" id="email" name="email" v-model="credentials.email">
                </div>
                <div class="form-group row">
                    <label for="password" class="col-form-label text-md-right">Password</label>
                    <input type="password" class="form-control" id="password" name="password" v-model="credentials.password">
                </div>
                <div class="form-group row">
                    <label for="password-confirm" class="col-form-label text-md-right">Password confirm</label>
                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" v-model="credentials.password_confirmation">
                </div>
                <div class="form-group row">
                    <button type="submit" onclick="event.preventDefault()" class="btn btn-primary" @click="registerData()">submit</button>
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
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                actionURI: location.href,
                auth: this.$root.authenticated
            }
        },
        methods: {
            registerData: function () {
                let dataCredentials = {
                    name: this.credentials.name,
                    email: this.credentials.email,
                    password: this.credentials.password,
                    password_confirmation: this.credentials.password_confirmation
                };
                axios.post(this.actionURI, dataCredentials, {
                    headers: {
                        "Access-Control-Allow-Origin": "*",
                        "Access-Control-Allow-Credentials":"true",
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    withCredentials: true
                }).then(function (response) {
                    switch(response.status) {
                        case 200:
                            vmThis.$root.statusAuth(false, '/login');
                            break;

                        default:
                            break
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