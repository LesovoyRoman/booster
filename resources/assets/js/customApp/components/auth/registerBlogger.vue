<template>
    <div id="register">
        <div v-if="!auth">
            <form action="" v-model="actionURI" id="form_register" enctype="multipart/form-data">
                <div v-if="step === 1">
                    <div class="form-group">
                        <label class="col-form-label text-md-right">Choose the language</label>
                        <b-form-select  v-model="credentials.chosen_lang" :options="languages" class="mb-3"></b-form-select>
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
                        <label for="phone" class="col-form-label text-md-right">Phone</label>
                        <input type="text" placeholder="Type your phone" class="form-control" id="phone" name="phone" v-model="credentials.phone">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label text-md-right">Your avatar</label>
                        <!--<input type="file" accept="image/*" class="form-control" id="avatar" name="avatar" v-model="credentials.avatar">-->
                        <b-form-file accept="image/*" v-model="credentials.avatar" placeholder="Choose a image..."></b-form-file>
                    </div>
                    <div class="form-group">
                        <label for="brand" class="col-form-label text-md-right">Brand</label>
                        <input type="text" placeholder="Type your brand" class="form-control" id="brand" name="brand" v-model="credentials.brand">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label text-md-right">Topic</label>
                        <b-form-select  v-model="credentials.topic" :options="topics" class="mb-3" />
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
                        <label class="col-form-label text-md-right">Influence Channel</label>
                        <b-form-select  v-model="credentials.influenceChannel" :options="channels" class="mb-3" />
                    </div>
                    <div class="form-group" v-if="credentials.influenceChannel !== null">
                        <label for="linkChannel" class="col-form-label text-md-right">Channel link</label>
                        <input type="text" placeholder="Type your channel link" class="form-control" id="linkChannel" name="linkChannel" v-model="credentials.linkChannel">
                    </div>
                    <div class="form-group" v-if="credentials.influenceChannel !== null">
                        <label class="col-form-label text-md-right">Size of auditory</label>
                        <b-form-select  v-model="credentials.auditory" :options="auditories" class="mb-3" />
                    </div>
                    <div class="form-group" v-if="credentials.influenceChannel !== null">
                        <label class="col-form-label text-md-right">Age of auditory</label>
                        <b-row>
                            <b-col><b-form-select  v-model="credentials.auditory_age_from" :options="auditories_age_from" class="mb-3" /></b-col>
                            <b-col><b-form-select  v-model="credentials.auditory_age_to" :options="auditories_age_to" class="mb-3" /></b-col>
                        </b-row>
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
                    name: '', //
                    surname: '',
                    email: '', //
                    password: '', //
                    password_confirmation: '', //
                    chosen_lang: null, //
                    brand: '', //
                    topic: null, //
                    linkChannel: '', //
                    influenceChannel: null, //
                    phone: '', //
                    role: 'blogger', //
                    auditory: 1,
                    avatar: '',
                    auditory_age_from: null,
                    auditory_age_to: null,
                },
                actionURI: '/register',
                auth: this.$root.authenticated,

                topics: [],

                auditories_age_from: [],

                auditories_age_to: [],

                channels: [],

                languages: [],

                auditories: [],

                picturesBg: [
                    { path: '/images/bgregister1.png'},
                    { path: '/images/blogerStep2.png'},
                    { path: '/images/blogerStep3.png'},
                    { path: '/images/bgregister1.png'},
                ]
            }
        },
        methods: {
            registerData: function () {
                let dataCredentials = {
                    name: this.credentials.name,
                    surname: this.credentials.surname,
                    chosen_lang: this.credentials.chosen_lang,
                    email: this.credentials.email,
                    password: this.credentials.password,
                    password_confirmation: this.credentials.password_confirmation,
                    user_role: 'influencer',
                    brand: this.credentials.brand, //
                    topic: this.credentials.topic, //
                    linkChannel: this.credentials.linkChannel, //
                    influenceChannel: this.credentials.influenceChannel, //
                    phone: this.credentials.phone, //
                    auditory: this.credentials.auditory,
                    //avatar: this.credentials.influenceChannel,
                    auditory_age_from: this.credentials.auditory_age_from,
                    auditory_age_to: this.credentials.auditory_age_to,
                };
                axios.post(this.actionURI, dataCredentials, {
                    headers: {
                        "Access-Control-Allow-Origin": "*",
                        "Access-Control-Allow-Credentials":"true",
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    withCredentials: true
                }).then(function (response) {
                    //console.log(response);
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
                    vmThis.$root.changeBg(this.picturesBg[val].path, 'right')
                } else {
                    vmThis.$root.changeBg(this.picturesBg[val].path)
                }
            },
        },
        created() {
            vmThis = this;
            if(this.$root.configEnums.channels) {
                this.channels = this.$root.configEnums.channels;
                this.languages = this.$root.configEnums.languages;
                this.auditories = this.$root.configEnums.auditories;
                this.auditories_age_to = this.$root.configEnums.auditories_age_to;
                this.auditories_age_from = this.$root.configEnums.auditories_age_from;
                this.topics = this.$root.configEnums.topics;
            } else {
                axios.post('/getConfigEnums').then(response => {
                    this.channels = response.data.enums.channels;
                    this.languages = response.data.enums.languages;
                    this.auditories = response.data.enums.auditories;
                    this.auditories_age_from = response.data.enums.auditories_age_from;
                    this.auditories_age_to = response.data.enums.auditories_age_to;
                    this.topics = response.data.enums.topics;
                })
            }
        },
        updated(){
            this.$root.changeHeight();
        }
    }
</script>