<template>
    <div class="wrapper" id="account">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <loading v-if="loading" style="position: fixed; margin-left: -20px; left: 50%; top: 50%"></loading>

                <b-col
                        sm="12"
                        md="12">
                    <b-card v-if="!loading">
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

                            <div class="divider_custom"></div>

                            <p class="card-text header_card_simple">Tariff</p>

                            <label class="span-row">Tariff plan: <span class="font24 font500">{{ user.tariffPlan }}</span></label>
                            <label class="span-row">Tariff valid until: <span class="font500">{{ user.tariffTerm }}</span></label>

                            <div class="divider_custom"></div>

                            <p class="card-text header_card_simple">Contacts</p>

                            <b-row>
                                <b-col>
                                    <b-form-group
                                            id="fieldset_user_name"
                                            description=""
                                    >
                                        <label for="user_name">Your name</label>
                                        <b-form-input id="user_name" placeholder="Enter name"  v-model.trim="user.name"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_surname"
                                            description=""
                                    >
                                        <label for="user_surname">Your surname</label>
                                        <b-form-input id="user_surname" placeholder="Enter surname"  v-model.trim="user.surname"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_work_position"
                                            description=""
                                    >
                                        <label for="user_work_position">Work position</label>
                                        <b-form-input id="user_work_position" placeholder="Work position"  v-model.trim="user.work_position"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_phone"
                                            description=""
                                    >
                                        <label for="user_phone">Phone</label>
                                        <b-form-input id="user_phone" placeholder="Phone"  v-model.trim="user.phone"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <div class="divider_custom"></div>

                            <p class="card-text header_card_simple">About company</p>

                            <b-row>
                                <b-col>
                                    <b-form-group
                                            id="fieldset_user_brand"
                                            description=""
                                    >
                                        <label for="user_brand">Brand</label>
                                        <b-form-input id="user_brand" placeholder="Enter brand"  v-model.trim="user.brand"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_company"
                                            description=""
                                    >
                                        <label for="user_company">Name company</label>
                                        <b-form-input id="user_company" placeholder="Enter name company"  v-model.trim="user.company"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_legal_company_name"
                                            description=""
                                    >
                                        <label for="user_legal_company_name">Name legal company</label>
                                        <b-form-input id="user_legal_company_name" placeholder="Enter legal name"  v-model.trim="user.legal_company_name"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_company_address"
                                            description=""
                                    >
                                        <label for="user_company_address">Company address</label>
                                        <b-form-input id="user_company_address" placeholder="Enter company address"  v-model.trim="user.company_address"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_company_id"
                                            description=""
                                    >
                                        <label for="user_company_id">Company ID</label>
                                        <b-form-input id="user_company_id" placeholder="Enter company ID"  type="number" v-model.trim="user.company_id"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_site_link"
                                            description=""
                                    >
                                        <label for="user_legal_company_name">Site</label>
                                        <b-form-input id="user_site_link" placeholder="Enter site_link"  v-model.trim="user.site_link"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_vat"
                                            description=""
                                    >
                                        <label for="user_vat">VAT tax</label>
                                        <b-form-input id="user_vat" placeholder="Enter vat tas"  v-model.trim="user.vat"></b-form-input>
                                    </b-form-group>

                                    <b-button
                                            type="button" @click="changeDataPerformer"
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
    import Loading from 'vue-loading-spinner/src/components/Circle8'

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

                error_name: 'Name is required',
                error_surname: 'Surname is required',
                error_work_position: 'Work position is required',
                error_phone: 'Phone is not valid',
                error_brand: 'Brand is required',
                error_company: 'Company is required',

                errors: [],

                user: {
                    email: '',
                    old_password: '',
                    new_password: '',
                    file: {},
                    password_confirmation: '',

                    name : '',
                    surname: '',
                    work_position : '',
                    phone : '',
                    brand : '',
                    company : '',
                    site_link : '',
                    legal_company_name : '',
                    vat : '',
                    tariffPlan: 'Silver',
                    tariffTerm: '2020.12.12',
                    company_address: '',
                    company_id: 0,
                },
            }
        },
        created(){
            vm = this;
            this.loading = true;
            this.urlImage = this.storage_path + '/' + 'images/noimage.jpg';
            this.storage_path = this.$root.storage_path;
            axios.post('/currentPerformerGetData').then(response => {
                this.loading = false;
                //console.log(response.data.user);
                let user = response.data.user;
                vm.user.name = user.name;
                vm.user.surname = user.surname;
                vm.user.email = user.email;
                vm.user.phone = user.phone;
                vm.user.brand = user.brand;
                vm.user.company = user.company;
                vm.user.work_position = user.work_position;
                vm.user.legal_company_name = user.legal_company_name;
                vm.user.company_id = user.company_id;
                vm.user.site_link = user.site_link;
                if(user.photo_path.length > 0) {
                    this.urlImage = this.storage_path + '/' + user.photo_path;
                }
            })
        },
        methods: {
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
            changeDataPerformer(event)
            {
                if(vm.validatorData('data') === 0) {
                    let data = {
                        name: vm.user.name,
                        surname: vm.user.surname,
                        phone: vm.user.phone,
                        brand: vm.user.brand,
                        company: vm.user.company,
                        work_position: vm.user.work_position,
                        legal_company_name: vm.user.legal_company_name,
                        company_id: vm.user.company_id,
                        site_link: vm.user.site_link,
                    };
                    vm.sendAxiosRequest(data, '/currentPerformerSetData');
                }
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
                if (url === 'data') {
                    if(vm.user.name.length < 1) {
                        vm.errors.push(vm.error_name)
                    }
                    if(vm.user.surname.length < 1) {
                        vm.errors.push(vm.error_surname)
                    }
                    if(vm.user.work_position.length < 1) {
                        vm.errors.push(vm.error_work_position)
                    }
                    if(vm.user.phone.length < 1) {
                        vm.errors.push(vm.error_phone)
                    }
                    if(vm.user.brand.length < 1) {
                        vm.errors.push(vm.error_brand)
                    }
                    if(vm.user.company.length < 1) {
                        vm.errors.push(vm.error_company)
                    }
                }

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
        },
    }
</script>