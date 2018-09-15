<template>
    <div class="wrapper" id="account">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>
                        <form action="">
                            <p class="card-text header_card_simple">Common information</p>

                            <b-row>
                                <b-col md="3" lg="3">
                                    <div class="block_logo_user">
                                        <img src="~static/img/avatars/8.jpg" alt="" id="logo">
                                        <label for="logo_user" id="label_logo_user"></label>
                                        <input name="logo_user" hidden id="logo_user" type="file" accept="image/*">
                                    </div>
                                </b-col>
                                <b-col md="9" lg="9">
                                    <b-form-group
                                            id="fieldset_user_email"
                                            description=""
                                    >
                                        <label for="user_email">Email</label>
                                        <b-form-input id="user_email" placeholder="Enter email"  v-model.trim="user.email"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_pass"
                                            description=""
                                    >
                                        <label for="user_pass">Password</label>

                                        <b-form-input id="user_pass" type="password" placeholder="Enter password"  v-model.trim="user.password"></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col>
                                    <b-button
                                            class="font500 float-right uppercase"
                                            variant="primary">change</b-button>
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
                                            id="fieldset_user_work"
                                            description=""
                                    >
                                        <label for="user_work">Work position</label>
                                        <b-form-input id="user_work" placeholder="Work position"  v-model.trim="user.work"></b-form-input>
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
                                            id="fieldset_user_legal_company"
                                            description=""
                                    >
                                        <label for="user_legal_company">Name legal company</label>
                                        <b-form-input id="user_legal_company" placeholder="Enter legal name"  v-model.trim="user.legal_company"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_site"
                                            description=""
                                    >
                                        <label for="user_legal_company">Site</label>
                                        <b-form-input id="user_site" placeholder="Enter site"  v-model.trim="user.site"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_nds"
                                            description=""
                                    >
                                        <label for="user_nds">NDS tax</label>
                                        <b-form-input id="user_nds" placeholder="Enter nds tas"  v-model.trim="user.nds"></b-form-input>
                                    </b-form-group>

                                    <b-button
                                            type="submit"
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
    let vm = {};

    export default {
        name: 'Profile',
        data() {
            return {
                header: 'My profile',

                user: {
                    email: 'email@user.com',
                    password: 'password',
                    logo: '',  // path to img
                    name : 'Quentin Tarantino',
                    work : 'Producer',
                    phone : '+999999999999',
                    brand : 'Tarantino films',
                    company : 'OOO Tarantino',
                    site : 'https://mysite.com',
                    legal_company : 'Tino corporation',
                    nds : '23557645723954',
                    tariffPlan: 'Silver',
                    tariffTerm: '2020.12.12'

                },
            }
        },
        created(){
            vm = this;
        },
        methods: {

        },
    }
</script>