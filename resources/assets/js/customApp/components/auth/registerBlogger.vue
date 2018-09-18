<template>
    <div id="register">
        <div v-if="!auth">
            <form action="" v-model="actionURI" id="form_register" enctype="multipart/form-data">
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
                        <b-form-select  v-model="credentials.topic" :options="optionsTopic" class="mb-3" />
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
                        <b-form-select  v-model="credentials.influenceChannel" :options="optionsChannels" class="mb-3" />
                    </div>
                    <div class="form-group" v-if="credentials.influenceChannel !== null">
                        <label for="linkChannel" class="col-form-label text-md-right">Channel link</label>
                        <input type="text" placeholder="Type your channel link" class="form-control" id="linkChannel" name="linkChannel" v-model="credentials.linkChannel">
                    </div>
                    <div class="form-group" v-if="credentials.influenceChannel !== null">
                        <label class="col-form-label text-md-right">Size of auditory</label>
                        <b-form-select  v-model="credentials.sizeAuditory" :options="optionsAuditory" class="mb-3" />
                    </div>
                    <div class="form-group" v-if="credentials.influenceChannel !== null">
                        <label class="col-form-label text-md-right">Age of auditory</label>
                        <b-row>
                            <b-col><b-form-select  v-model="credentials.auditoryAgeFrom" :options="optionsAuditoryAgeFrom" class="mb-3" /></b-col>
                            <b-col><b-form-select  v-model="credentials.auditoryAgeTo" :options="optionsAuditoryAgeTo" class="mb-3" /></b-col>
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
                    sizeAuditory: 1,
                    avatar: '',
                    auditoryAgeFrom: null,
                    auditoryAgeTo: null,
                },
                actionURI: '/register',
                auth: this.$root.authenticated,

                optionsTopic: [
                    { value: null, text: 'Please select an option' },
                    { value: 'games', text: 'Games' },
                    { value: 'adventure', text: 'Adventure' },
                ],

                optionsAuditoryAgeFrom: [
                    { value: null, text: 'From' },
                    { value: '10', text: '10' },
                    { value: '15', text: '15' },
                    { value: '15', text: '15' },
                    { value: '20', text: '20' },
                    { value: '25', text: '25' },
                    { value: '30', text: '30' },
                    { value: '35', text: '35' },
                    { value: '40', text: '40' },
                ],

                optionsAuditoryAgeTo: [
                    { value: null, text: 'To' },
                    { value: '20', text: '20' },
                    { value: '30', text: '30' },
                    { value: '40', text: '40' },
                    { value: '20', text: '20' },
                    { value: '25', text: '25' },
                    { value: '30', text: '30' },
                    { value: '35', text: '35' },
                    { value: '40', text: '40' },
                    { value: '50', text: '50' },
                    { value: '60', text: '60' },
                ],

                optionsChannels: [
                    { value: null, text: 'Please select an option' },
                    { value: 'youtube', text: 'YouTube' },
                ],

                optionsLang: [
                    { value: null, text: 'Please select an option' },
                    { value: 'eng', text: 'English' },
                    { value: 'rus', text: 'Russian' },
                ],

                optionsAuditory: [
                    { value: 1, text: '10-50 people' },
                    { value: 2, text: '50-500 people' },
                    { value: 3, text: '500-1000 people' },
                    { value: 4, text: '1000-4000 people' },
                    { value: 5, text: '4000-10000 people' },
                    { value: 6, text: '10000-50000 people' },
                ],

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
                    vmThis.$root.changeBg(this.picturesBg[val].path, 'right')
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