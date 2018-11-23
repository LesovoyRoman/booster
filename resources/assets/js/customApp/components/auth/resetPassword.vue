<template>
    <div id="resetPassword">
        <div v-if="!auth">
            <form action="" id="form_login" v-model="actionURI">
                <div class="form-group">
                    <label for="email" class="col-form-label text-md-right">Email</label>
                    <input type="text" class="form-control" id="email" name="email" v-model.trim="user.email">
                </div>
                <div class="form-group">
                    <router-link class="float-link" v-bind:to="'/login'">Login</router-link>

                    <button type="submit" class="btn btn-primary" onclick="event.preventDefault()"  @click="resetPassword()">reset</button>
                </div>
                <div class="form-group">
                    <router-link class="" v-bind:to="'/registration'"><span class="color-dark">Do not have an account?</span> REGISTRATION</router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    let vm = {};

    const emailValid = (email) => {
        const emailRegex = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,4})$/;
        return emailRegex.test(email);
    }

    export default {
        name: 'resetPassword',
        data(){
            return {
                user: {
                    email: '',
                },

                auth: this.$root.authenticated,
                actionURI: location.href,
            }
        },
        methods: {
            resetPassword(){
                if(!emailValid(vm.user.email)) return vm.$swal('Oops:', 'Email is not valid', 'error')
                axios.post(vm.actionURI, {
                    email: vm.user.email
                }).then(response => {
                    console.log(response);
                    if(!response.data.errors) return vm.$swal('Success:', 'Your new password was sent to email', 'success')
                    /**
                     * errors
                     */
                    if (response.data.errors) {
                        let strErrors = '';
                        let count = 0;
                        for (let val in response.data.errors) {
                            count++;
                            strErrors += '<span>' + count + ') ' + response.data.errors[val] + '</span> ' + '<br>';
                        }
                        vm.$swal('There are some problems:', strErrors, 'error')
                    }
                }).catch(err => {
                    console.log(err)
                })
            }
        },
        created(){
            vm = this;
        }
    }
</script>