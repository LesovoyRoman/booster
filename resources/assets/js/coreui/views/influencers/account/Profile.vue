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

                            <div class="divider_custom"></div>

                            <p class="card-text header_card_simple">Contacts</p>

                            <b-row>
                                <b-col>
                                    <b-form-group
                                            id="fieldset_user_phone"
                                            description=""
                                    >
                                        <label for="user_phone">Phone</label>
                                        <b-form-input id="user_phone" placeholder="Phone"  v-model.trim="user.phone"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_country"
                                            description=""
                                    >
                                        <label for="user_country">Country</label>
                                        <b-form-select dark v-model="user.address.country" :options="countries"></b-form-select>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_city"
                                            description=""
                                    >
                                        <label for="user_city">City</label>
                                        <b-form-select dark v-model="user.address.city">
                                            <option v-for="option in cities[user.address.country]">{{ option }}</option>
                                        </b-form-select>
                                    </b-form-group>

                                    <b-row>
                                        <b-col>
                                            <b-form-group
                                                    id="fieldset_user_street"
                                                    description=""
                                            >
                                                <label for="user_street">Street</label>
                                                <b-form-input id="user_street" placeholder="Street"  v-model.trim="user.address.street"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col>
                                            <b-row>
                                                <b-form-group id="fieldset_influencer_home">
                                                    <b-input-group>
                                                        <b-input-group-prepend>
                                                            <b-form-group
                                                                    id="fieldset_user_home_address"
                                                                    description=""
                                                            >
                                                                <label for="user_home_address">House</label>
                                                                <b-form-input id="user_home_address" placeholder="House"  v-model.trim="user.address.home_address"></b-form-input>
                                                            </b-form-group>
                                                        </b-input-group-prepend>
                                                        <b-input-group-prepend>
                                                            <b-form-group
                                                                    id="fieldset_user_apartments"
                                                                    description=""
                                                            >
                                                                <label for="user_apartment">Apartments</label>
                                                                <b-form-input id="user_apartments" placeholder="Apartments"  v-model.trim="user.address.apartments"></b-form-input>
                                                            </b-form-group>
                                                        </b-input-group-prepend>
                                                        <b-input-group-prepend>
                                                            <b-form-group
                                                                    id="fieldset_user_index_channel"
                                                                    description=""
                                                            >
                                                                <label for="user_index_channel">Index</label>
                                                                <b-form-input id="user_index_channel" placeholder="Index"  v-model.trim="user.address.zip_code"></b-form-input>
                                                            </b-form-group>
                                                        </b-input-group-prepend>
                                                    </b-input-group>
                                                </b-form-group>
                                            </b-row>
                                        </b-col>


                                    </b-row>
                                </b-col>
                            </b-row>

                            <div class="divider_custom"></div>

                            <p class="card-text header_card_simple">Influence channels</p>

                            <div v-for="(item, index_channel) in user.channels" :key="'channel_' + index_channel">

                                <b-row>
                                    <b-col>
                                        <b-form-group
                                                :id="'fieldset_user_topic_' + index_channel"
                                                description=""
                                        >
                                            <label for="user_topic">Topic</label>
                                            <b-form-select dark v-model="item.topic" :options="topics"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <b-row>
                                    <b-col>
                                        <b-form-group
                                                :id="'fieldset_user_chanells_' + index_channel"
                                                description=""
                                        >
                                            <label :for="'user_journeys_' + index_channel">Influence channel</label>
                                            <b-form-select dark v-model="item.name" :options="channels"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <b-row>
                                    <b-col>
                                        <b-form-group
                                                :id="'fieldset_user_links_' + index_channel"
                                                description=""
                                        >
                                            <label :for="'user_links_' + index_channel">Link to channel</label>
                                            <b-form-input :id="'user_link_' + index_channel" placeholder="Channel"  v-model.trim="item.link"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>


                                <b-row>
                                    <b-col md="4" lg="4">
                                        <b-form-group
                                                :id="'fieldset_user_auditory_' + index_channel"
                                                description=""
                                        >
                                            <label>Auditory</label>

                                            <b-form-select dark v-model="item.auditory" :options="auditories"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                    <b-col md="4" lg="4">
                                        <b-form-group
                                                :id="'fieldset_user_auditory_age_from_' + index_channel"
                                                description=""
                                        >
                                            <label>Auditory age from</label>
                                            <b-form-select dark v-model="item.auditory_age_from" :options="auditories_age_from">

                                            </b-form-select>
                                        </b-form-group>
                                    </b-col>

                                    <b-col md="4" lg="4">
                                        <b-form-group
                                                :id="'fieldset_user_auditory_age_to_' + index_channel"
                                                description=""
                                        >
                                            <label>Auditory age to</label>
                                            <b-form-select dark v-model="item.auditory_age_to" :options="auditories_age_to">

                                            </b-form-select>
                                        </b-form-group>
                                    </b-col>
                                </b-row>


                                <div v-if="user.channels.length > 1 && index_channel !== 0">
                                    <b-row>
                                        <b-col>
                                            <b-form-group>
                                                <b-button
                                                        class="font500 float-right uppercase"
                                                        variant="primary" @click="removeChannel(index_channel, item)">delete channel</b-button>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </div>

                                <div class="divider_custom" v-if="user.channels.length > 1 && index_channel !== user.channels.length - 1"></div>

                            </div>

                            <b-row>
                                <b-col>
                                    <b-form-group>
                                        <b-button
                                                class="font500 float-left uppercase"
                                                variant="primary" @click="addChannel">+ influence channel</b-button>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-button @submit.prevent
                                            type="button" @click="changeDataInfluencer"
                                            class="font500 float-right uppercase"
                                            variant="primary">save</b-button>
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
    let vm = {};

    const emailValid = (email) => {
        const emailRegex = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,4})$/;
        return emailRegex.test(email);
    }

    export default {
        name: 'Profile',
        components: {
            Loading,
        },
        data() {
            return {
                header: 'My profile',

                loading: false,
                urlImage: '',

                error_pass_new: 'New password empty or less than 8 sybmols',
                error_pass_confirmation: 'Password confirmation does not match',
                error_old_pass: 'Old password less than 8 symbols',

                error_email: 'Email is not correct',

                error_name: 'Name is required',
                error_surname: 'Surname is required',
                error_phone: 'Phone is not valid',
                error_brand: 'Brand is required',

                error_name_channel: 'Channel is required',

                storage_path: '',

                errors: [],

                user: {
                    name: '',
                    surname: '',
                    phone: '',
                    file: {},
                    channels: [],
                    address: {
                        country: 'Ukraine',
                        city: '',
                        street: '',
                        home_address: '',
                        apartments: '',
                        zip_code: '',
                    },
                },

                countries: ['Ukraine', 'Russia', 'USA'],
                cities: {
                    Ukraine: ['Kharkov', 'Kiev'],
                    Russia: ['Moscow', 'Rostov'],
                    USA: ['New-York', 'Los Angeles']
                },
                topics: [],
                channels: [],
                auditories: [],
                auditories_age_from: [],
                auditories_age_to: []

            }
        },
        created(){
            vm = this;
            this.storage_path = this.$root.storage_path;
            this.urlImage = this.storage_path + '/' + 'images/noimage.jpg';
            this.loading = true;
            // @todo add new Route, create method
            axios.post('/currentInfluencerGetData').then(response => {
                this.loading = false;
                console.log(response);
                let user = response.data.user;
                vm.user.name = user.name;
                vm.user.surname = user.surname;
                vm.user.email = user.email;
                vm.user.phone = user.phone;
                vm.user.brand = user.brand;
                let count = 0;
                if(user.channels) {
                    vm.user.channels = user.channels;
                }
                if(user.photo_path) {
                    this.urlImage = this.storage_path + '/' + user.photo_path;
                }
                if(user.address){
                    vm.user.address = user.address;
                }

                this.channels = this.$root.configEnums.channels;
                this.languages = this.$root.configEnums.languages;
                this.auditories = this.$root.configEnums.auditories;
                this.auditories_age_to = this.$root.configEnums.auditories_age_to;
                this.auditories_age_from = this.$root.configEnums.auditories_age_from;
                this.topics = this.$root.configEnums.topics;
            })
        },
        methods: {
            addChannel(){
                vm.user.channels.push({name: '', topic: '', link: 'https://changeMe.com', auditory: 10, auditory_age_from: 10, auditory_age_to: 20})
            },
            async removeChannel(index_channel) {
                let check = await vm.$root.check();
                if (check === true) {
                    vm.user.channels.splice(index_channel, 1);
                }
            },
            changeEmail(event){
                if(!emailValid(vm.user.email)) {
                    vm.$swal( 'There are some problems:', vm.error_email, 'error')
                } else {
                    vm.sendAxiosRequest({email: vm.user.email}, '/currentUserChangeEmail')
                }
            },
            changePass(event){
                if(vm.validatorData('password') === 0) {
                    let data = {
                        old_password: vm.user.old_password,
                        new_password: vm.user.new_password,
                        password_confirmation: vm.user.password_confirmation
                    };

                    vm.sendAxiosRequest(data, '/currentUserChangePass');
                }
            },
            changeDataInfluencer(event)
            {
                if(vm.validatorData('data') === 0) {
                    let user_channels = vm.user.channels;
                    let updateChannels = {};
                    updateChannels.update = [];
                    user_channels.forEach(function (item) {
                        updateChannels.update.push(item);
                    });
                    let data = {
                        name: vm.user.name,
                        surname: vm.user.surname,
                        phone: vm.user.phone,
                        brand: vm.user.brand,
                        address: vm.user.address,
                        channels: updateChannels,
                    };
                    vm.sendAxiosRequest(data, '/currentInfluencerSetData');
                }
            },
            changeLogo(event){
                const file = event.target.files[0];
                let formData = new FormData();
                formData.append('file', document.getElementById('logo_user').files[0]);
                this.loading = true;
                axios.post('/currentUserChangeAvatar', formData).then(response => {
                    this.loading = false;
                    if(response.status === 200) {
                        vm.$swal( 'Congratulates:', 'You have updated avatar!', 'success')
                    }
                    if (response.status === 206){
                        alert(response.data.exception)
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
                }).catch(error => {
                    this.loading = false;
                });

                this.urlImage = URL.createObjectURL(file);
            },
            sendAxiosRequest(data, url) {
                this.loading = true;
                axios.post(url, data).then(response => {
                    console.log(response);
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

                if (url === 'data') {
                    if(vm.user.name.length < 1) {
                        vm.errors.push(vm.error_name)
                    }
                    if(vm.user.surname.length < 1) {
                        vm.errors.push(vm.error_surname)
                    }
                    if(vm.user.phone.length < 1) {
                        vm.errors.push(vm.error_phone)
                    }
                    if(vm.user.brand.length < 1) {
                        vm.errors.push(vm.error_brand)
                    }
                    vm.user.channels.forEach(function (item, index) {
                        if(!item.name){
                            vm.errors.push(vm.error_name_channel);
                        }
                    })
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
        },
    }
</script>