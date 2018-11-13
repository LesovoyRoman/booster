<template>
    <div class="wrapper" id="account">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>
                        <form action="" @submit.prevent>
                            <p class="card-text header_card_simple">Common information</p>

                            <b-row>
                                <b-col md="3" lg="3">
                                    <div class="block_logo_user">
                                        <img :src="urlImage" alt="" id="logo">
                                        <label for="logo_user" id="label_logo_user"></label>
                                        <b-form-file name="logo_user" @change="changeLogo" v-model="user.file" hidden id="logo_user" type="file" accept="image/*"></b-form-file>
                                    </div>
                                </b-col>

                                <b-col md="9" lg="9">
                                    <b-tabs pills card>
                                        <b-tab title="Email" active>
                                            <b-form-group
                                                    id="fieldset_user_email"
                                                    description=""
                                            >
                                                <label for="user_email">New email</label>
                                                <b-form-input id="user_email" placeholder="Enter email"  v-model.trim="user.email"></b-form-input>
                                            </b-form-group>

                                            <div>
                                                <b-button
                                                        class="font500 float-right uppercase" @click="changeEmail"
                                                        variant="primary">save</b-button>
                                                <div class="clearfix"></div>
                                            </div>
                                        </b-tab>
                                        <b-tab title="Password">

                                            <b-form-group
                                                    id="fieldset_user_old_pass"
                                                    description="">
                                                <label for="user_pass">Old password</label>

                                                <b-form-input id="user_pass_old" type="password" placeholder="Enter old password"  v-model.trim="user.old_password"></b-form-input>
                                            </b-form-group>

                                            <b-form-group
                                                    id="fieldset_user_new_pass"
                                                    description="">
                                                <label for="user_pass">New password</label>

                                                <b-form-input id="user_pass_new" type="password" placeholder="Enter password"  v-model.trim="user.new_password"></b-form-input>
                                            </b-form-group>

                                            <b-form-group
                                                    id="fieldset_user_pass_confirmation"
                                                    description="">
                                                <label for="user_pass">Password confirmation</label>

                                                <b-form-input id="user_pass_confirmation" type="password" placeholder="Enter password confirmation"  v-model.trim="user.password_confirmation"></b-form-input>
                                            </b-form-group>

                                            <div>
                                                <b-button
                                                        class="font500 float-right uppercase" @click="changePass"
                                                        variant="primary">save</b-button>
                                                <div class="clearfix"></div>
                                            </div>
                                        </b-tab>

                                    </b-tabs>
                                </b-col>
                            </b-row>

                        </form>
                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    import Loading from 'vue-loading-spinner/src/components/Circle10'

    const emailValid = (email) => {
        const emailRegex = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,4})$/;
        return emailRegex.test(email);
    }

    let vm = {};

    export default {
        name: 'Profile',
        components: {
            Loading
        },
        data() {
            return {
                header: 'My profile',
                loading: false,
                urlImage: '',

                storage_path: '',

                error_pass_new: 'New password empty or less than 8 sybmols',
                error_pass_confirmation: 'Password confirmation does not match',
                error_old_pass: 'Old password less than 8 symbols',

                error_email: 'Email is not correct',

                errors: [],

                user: {
                    email: '',
                    old_password: '',
                    new_password: '',
                    file: {},
                    password_confirmation: '',
                }
            }
        },
        created(){
            vm = this;
            this.loading = true;
            this.storage_path = this.$root.storage_path;
            this.urlImage = this.storage_path + '/' + 'images/noimage.jpg';
            axios.post('/currentAssistantGetData').then(response => {
                this.loading = false;
                let user = response.data.user;
                vm.user.email = user.email;
                if(user.photo_path) {
                    this.urlImage = this.storage_path + '/' + user.photo_path;
                }
            })
        },
        methods: {
            changeEmail(event){
                if (!emailValid(vm.user.email)) {
                    vm.$swal('There are some problems:', vm.error_email, 'error')
                } else {
                    vm.sendAxiosRequest({email: vm.user.email}, '/currentUserChangeEmail')
                }
            },
            changePass(event){
                if (vm.validatorData('password') === 0) {
                    let data = {
                        old_password: vm.user.old_password,
                        new_password: vm.user.new_password,
                        password_confirmation: vm.user.password_confirmation
                    };

                    vm.sendAxiosRequest(data, '/currentUserChangePass');
                }
            },
            changeLogo(event){
                const file = event.target.files[0];
                let formData = new FormData();
                formData.append('file', document.getElementById('logo_user').files[0]);
                this.loading = true;
                axios.post('/currentUserChangeAvatar', formData).then(response => {
                    this.loading = false;
                    if (response.status === 200) {
                        vm.$swal('Congratulates:', 'You have updated avatar!', 'success')
                    }
                    if (response.status === 206) {
                        alert(response.data.exception)
                    }
                    if (response.data.errors) {
                        let strErrors = '';
                        let count = 0;
                        for (let val in response.data.errors) {
                            count++;
                            strErrors += '<span>' + count + ') ' + response.data.errors[val] + '</span> ' + '<br>';
                        }
                        vm.$swal('There are some problems:', strErrors, 'error')
                    }
                }).catch(error => {
                    this.loading = false;
                });

                this.urlImage = URL.createObjectURL(file);
            },
            sendAxiosRequest(data, url) {
                this.loading = true;
                axios.post(url, data).then(response => {
                    this.loading = false;
                    if(response.data.response) {
                        vm.$swal( 'Congratulates:', response.data.response, 'success')
                    }
                    if(response.data.errors) {
                        let strErrors = '';
                        let count = 0;
                        for(let val in response.data.errors){
                            count++;
                            strErrors += '<span>' + count + ') ' + response.data.errors[val] + '</span> ' + '<br>';
                        }
                        vm.$swal( 'There are some problems:', strErrors, 'error')
                    }
                })
            },
            validatorData(url){
                vm.errors = [];

                if(url === 'password'){
                    if(vm.user.old_password.length < 8) {
                        vm.errors.push(vm.error_old_pass)
                    }
                    if(vm.user.new_password.length < 8) {
                        vm.errors.push(vm.error_pass_new)
                    }
                    if(vm.user.password_confirmation !== vm.user.new_password) {
                        vm.errors.push(vm.error_pass_confirmation)
                    }
                }

                if(vm.errors.length !== 0){
                    let count = 0;
                    let strErrors = '';
                    vm.errors.forEach(function(item){
                        count++;
                        strErrors += '<span>' + count + ') ' + item + '</span> ' + '<br>';
                    })
                    vm.$swal( 'There are some problems:', strErrors, 'error')
                }

                return vm.errors.length
            },
        }
    }
</script>