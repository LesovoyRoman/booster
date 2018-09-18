<template>
    <div id="register">
        <div v-if="!auth">
            <form action="" v-model="actionURI" id="form_register">
                <div v-if="step === 1">
                    <div class="form-group">
                        <label class="col-form-label text-md-right">Choose the language</label>
                        <b-form-select  v-model="credentials.chosen_lang" :options="optionsLang" class="mb-3" />
                    </div>
                    <div class="form-group">
                        <button type="submit" onclick="event.preventDefault()" class="btn btn-primary float-right" @click="nextStep">next</button>
                    </div>
                </div>
                <div v-if="step === 2">
                    <div class="title m-b-md">
                        Register. Step 1
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label text-md-right">Email</label>
                        <input type="text" class="form-control" placeholder="Type you email" id="email" name="email" v-model="credentials.email">
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label text-md-right">Password</label>
                        <input type="password" class="form-control" placeholder="Type your password" id="password" name="password" v-model="credentials.password">
                    </div>
                    <div class="form-group">
                        <label for="password-confirm" class="col-form-label text-md-right">Password confirm</label>
                        <input type="password" placeholder="Type password confirmation" class="form-control" id="password-confirm" name="password_confirmation" v-model="credentials.password_confirmation">
                    </div>
                    <div class="form-group">
                        <button type="submit" onclick="event.preventDefault()" class="btn btn-primary float-left" @click="prevStep">prev</button>
                    </div>
                    <div class="form-group">
                        <button type="submit" onclick="event.preventDefault()" class="btn btn-primary float-right" @click="nextStep">next</button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="form-group">
                        <router-link class="" v-bind:to="'/login'"><span class="color-dark">Do you have an account?</span> LOGIN</router-link>
                    </div>
                </div>
                <div v-if="step === 3">
                    <div class="title m-b-md">
                        Register. Step 2
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-form-label text-md-right">FPN</label>
                        <input type="text" placeholder="Type your family, patronymic and name" class="form-control" id="name" name="name" v-model="credentials.name">
                    </div>
                    <div class="form-group">
                        <label for="workplace" class="col-form-label text-md-right">Working place</label>
                        <input type="text" placeholder="Type your working place" class="form-control" id="workplace" name="workplace" v-model="credentials.workplace">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label text-md-right">Phone</label>
                        <input type="text" placeholder="Type your phone" class="form-control" id="phone" name="phone" v-model="credentials.phone">
                    </div>
                    <div class="form-group">
                        <button type="submit" onclick="event.preventDefault()" class="btn btn-primary float-left" @click="prevStep">prev</button>
                    </div>
                    <div class="form-group">
                        <button type="submit" onclick="event.preventDefault()" class="btn btn-primary float-right" @click="nextStep">next</button>
                    </div>
                </div>

                <div v-if="step === 4">
                    <div class="title m-b-md">
                        Register. Step 3
                    </div>
                    <div class="form-group">
                        <label for="brand" class="col-form-label text-md-right">Brand</label>
                        <input type="text" placeholder="Type your brand" class="form-control" id="brand" name="brand" v-model="credentials.brand">
                    </div>
                    <div class="form-group">
                        <label for="site" class="col-form-label text-md-right">Your site</label>
                        <input type="text" placeholder="Type your site" class="form-control" id="site" name="site" v-model="credentials.site">
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="col-form-label text-md-right">Company name</label>
                        <input type="text" placeholder="Type your company name" class="form-control" id="company_name" name="company_name" v-model="credentials.company_name">
                    </div>
                    <div class="form-group">
                        <button type="submit" onclick="event.preventDefault()" class="btn btn-primary float-left" @click="prevStep">prev</button>
                    </div>
                    <div class="form-group">
                        <button type="submit" onclick="event.preventDefault()" class="btn btn-primary float-right" @click="registerData">registration</button>
                    </div>
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
                step: 1,
                credentials: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    chosen_lang: null,
                    brand: '',
                    company_name: '',
                    site: '',
                    workplace: '',
                    phone: '',
                    role: 'performer',

                },
                actionURI: '/register',
                auth: this.$root.authenticated,

                optionsLang: [
                    { value: null, text: 'Please select an option' },
                    { value: 'eng', text: 'English' },
                    { value: 'rus', text: 'Russian' },
                ],

                picturesBg: [
                    { path: '/images/bgregister1.png'},
                    { path: '/images/bglogin1.png'},
                    { path: '/images/performerStep2.png'},
                    { path: '/images/bgregister1.png'},
                ]
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
            prevStep() {
                this.step--;
                this.parentChangeImgBg(this.step - 1);
            },
            nextStep() {
                this.step++;
                this.parentChangeImgBg(this.step - 1);
            },
            parentChangeImgBg(val) {
                if (val === 3) {
                    vmThis.$root.changeBg(this.picturesBg[val].path, 'left')
                } else {
                    vmThis.$root.changeBg(this.picturesBg[val].path)
                }
            },
        },
        created () {
            vmThis = this;
        },
        updated(){
            this.$root.changeHeight();
        }
    }
</script>