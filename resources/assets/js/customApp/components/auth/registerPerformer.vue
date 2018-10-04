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
                    <b-row>
                        <b-col xs="12" sm="12" lg="6" md="6">
                            <b-form-group>
                                <label for="name" class="col-form-label text-md-right">Name</label>
                                <input type="text" placeholder="Type your name" class="form-control" id="name" name="name" v-model="credentials.name">
                            </b-form-group>
                        </b-col>
                        <b-col xs="12" sm="12" lg="6" md="6">
                            <b-form-group>
                                <label for="surname" class="col-form-label text-md-right">Surname</label>
                                <input type="text" placeholder="Type your surname" class="form-control" id="surname" name="surname" v-model="credentials.surname">
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <div class="form-group">
                        <label for="work_position" class="col-form-label text-md-right">Working place</label>
                        <input type="text" placeholder="Type your working place" class="form-control" id="work_position" name="work_position" v-model="credentials.work_position">
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
                        <label for="site_link" class="col-form-label text-md-right">Your site</label>
                        <input type="text" placeholder="Type your site" class="form-control" id="site_link" name="site_link" v-model="credentials.site_link">
                    </div>
                    <div class="form-group">
                        <label for="company" class="col-form-label text-md-right">Company name</label>
                        <input type="text" placeholder="Type your company name" class="form-control" id="company" name="company" v-model="credentials.company">
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
                    company: '',
                    site_link: '',
                    work_position: '',
                    phone: '',
                    surname: '',
                    role: 'performer',
                },
                actionURI: '/register',
                auth: this.$root.authenticated,

                optionsLang: [],

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
                    surname: this.credentials.surname,
                    email: this.credentials.email,
                    password: this.credentials.password,
                    password_confirmation: this.credentials.password_confirmation,
                    user_role: 'performer',
                    phone: this.credentials.phone,
                    work_position: this.credentials.work_position,
                    chosen_lang: this.credentials.chosen_lang,
                    company: this.credentials.company,
                    site_link: this.credentials.site_link,
                    brand: this.credentials.brand,
                };
                //console.log(dataCredentials);
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
                            window.location.href = '/dashboard';
                            break;

                        case 206:
                            let strErrors = '';
                            let count = 0;
                            for(let val in response.data.errors){
                                count++;
                                strErrors += '<span>' + count + ') ' + response.data.errors[val] + '</span> ' + '<br>';
                            }
                            vmThis.$swal( 'There are some problems:', strErrors, 'error')
                            break;
                        default:
                            break
                    }
                })

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
            axios.post('/getConfigEnums').then(response => {
                this.optionsLang = response.data.enums.languages;
            })
        },
        updated(){
            this.$root.changeHeight();
        }
    }
</script>