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

                                    <b-form-group
                                            id="fieldset_user_brand"
                                            description=""
                                    >
                                        <label for="user_brand">Brand</label>
                                        <b-form-input id="user_brand" placeholder="Enter brand"  v-model.trim="user.brand"></b-form-input>
                                    </b-form-group>
                                </b-col>

                                <b-col>
                                    <b-form-group
                                            id="fieldset_user_name"
                                            description=""
                                    >
                                        <label for="user_name">Name</label>
                                        <b-form-input id="user_name" placeholder="Enter name"  v-model.trim="user.name"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_surname"
                                            description=""
                                    >
                                        <label for="user_surname">Surname</label>
                                        <b-form-input id="user_surname" placeholder="Enter surname"  v-model.trim="user.surname"></b-form-input>
                                    </b-form-group>

                                    <b-col>
                                        <b-button
                                                class="font500 float-right uppercase"
                                                variant="primary">change</b-button>
                                    </b-col>
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
                                        <b-form-select dark v-model="user.country" :options="countries"></b-form-select>
                                    </b-form-group>

                                    <b-form-group
                                            id="fieldset_user_city"
                                            description=""
                                    >
                                        <label for="user_city">City</label>
                                        <b-form-select dark v-model="user.city">
                                            <option v-for="option in cities[user.country]">{{ option }}</option>
                                        </b-form-select>
                                    </b-form-group>

                                    <b-row>
                                        <b-col>
                                            <b-form-group
                                                    id="fieldset_user_street"
                                                    description=""
                                            >
                                                <label for="user_street">Street</label>
                                                <b-form-input id="user_street" placeholder="Street"  v-model.trim="user.street"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                        <b-col>
                                            <b-row>
                                                <b-form-group id="fieldset_influencer_home">
                                                    <b-input-group>
                                                        <b-input-group-prepend>
                                                            <b-form-group
                                                                    id="fieldset_user_house"
                                                                    description=""
                                                            >
                                                                <label for="user_house">House</label>
                                                                <b-form-input id="user_house" placeholder="House"  v-model.trim="user.house"></b-form-input>
                                                            </b-form-group>
                                                        </b-input-group-prepend>
                                                        <b-input-group-prepend>
                                                            <b-form-group
                                                                    id="fieldset_user_apartments"
                                                                    description=""
                                                            >
                                                                <label for="user_apartment">Apartments</label>
                                                                <b-form-input id="user_apartments" placeholder="Apartments"  v-model.trim="user.apartments"></b-form-input>
                                                            </b-form-group>
                                                        </b-input-group-prepend>
                                                        <b-input-group-prepend>
                                                            <b-form-group
                                                                    id="fieldset_user_index"
                                                                    description=""
                                                            >
                                                                <label for="user_index">Index</label>
                                                                <b-form-input id="user_index" placeholder="Index"  v-model.trim="user.index"></b-form-input>
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

                            <b-row>
                                <b-col>
                                    <b-form-group
                                            id="fieldset_user_topic"
                                            description=""
                                    >
                                        <label for="user_journeys">Topic</label>
                                        <b-form-select dark v-model="user.topic" :options="topics"></b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <div v-for="(item, index) in user.channels" :key="'channel_' + index">
                                <b-row>
                                    <b-col>
                                        <b-form-group
                                                :id="'fieldset_user_chanells_' + index"
                                                description=""
                                        >
                                            <label :for="'user_journeys_' + index">Influence channel</label>
                                            <b-form-select dark v-model="item.channel" :options="channels"></b-form-select>
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <b-row>
                                    <b-col>
                                        <b-form-group
                                                :id="'fieldset_user_links_' + index"
                                                description=""
                                        >
                                            <label :for="'user_links_' + index">Link to channel</label>
                                            <b-form-input :id="'user_link_' + index" placeholder="Channel"  v-model.trim="item.link"></b-form-input>
                                        </b-form-group>
                                    </b-col>
                                </b-row>

                                <div v-if="user.channels.length > 1 && index !== 0">
                                    <b-row>
                                        <b-col>
                                            <b-form-group>
                                                <b-button
                                                        class="font500 float-right uppercase"
                                                        variant="primary" @click="removeChannel(index)">delete channel</b-button>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </div>

                                <div class="divider_custom" v-if="user.channels.length > 1 && index !== user.channels.length - 1"></div>

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
                                <b-col md="4" lg="4">
                                    <b-form-group
                                            id="fieldset_user_auditory"
                                            description=""
                                    >
                                        <label for="user_auditory">Auditory</label>
                                        <b-form-select dark v-model="user.auditory" :options="auditories"></b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col md="12" lg="12" xs="12">
                                    <label for="user_auditory">Auditory age</label>
                                </b-col>
                                <b-col md="4" lg="4">
                                    <b-form-group
                                            id="fieldset_user_auditory_from"
                                            description=""
                                    >
                                        <b-form-select dark v-model="user.auditory_from" :options="auditories_from">
                                            <option :value="null" disabled selected style="color:rgba(0,0,0,0.26)">from</option>
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>

                                <b-col md="4" lg="4">
                                    <b-form-group
                                            id="fieldset_user_auditory_to"
                                            description=""
                                    >
                                        <b-form-select dark v-model="user.auditory_to" :options="auditories_to">
                                            <option :value="null" disabled selected style="color:rgba(0,0,0,0.25)">to</option>
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
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
                    name: 'Arnold',
                    surname: 'Schwarz',
                    phone: '+999999999999',
                    country: 'Russia',
                    city: 'Moscow',
                    optionsCountries: ['Moscow', 'Rostov'],
                    street: 'Street.st',
                    house: '15',
                    apartments: '7',
                    index: '75324',
                    topic: 'Journeys',
                    auditory_from: null,
                    auditory_to: null,

                    channels: [
                        {channel: 'YouTube', link: 'https://iamlink.com'},
                        {channel: 'Telegram', link: 'https://iamlink2.com'}
                    ],

                    auditory: '15-30',

                },

                countries: ['Ukraine', 'Russia', 'USA'],
                cities: {
                    Ukraine: ['Kharkov', 'Kiev'],
                    Russia: ['Moscow', 'Rostov'],
                    USA: ['New-York', 'Los Angeles']
                },
                topics: ['Journeys', 'Games', 'Fashion'],
                channels: ['YouTube', 'Telegram'],
                auditories: ['15-30', '30-100', '100-250', '250-500', '500-1000', '1000-10000', '10000-100000'],
                auditories_from: ['10', '15', '20', '25', '30', '35', '40'],
                auditories_to: ['15', '20', '25', '30', '35', '40', '45', '50', '55', '60']

            }
        },
        created(){
            vm = this;
        },
        methods: {
            addChannel(){
                vm.user.channels.push({channel: 'YouTube', link: 'https://changeMe.com'})
            },
            removeChannel(index) {
                vm.user.channels.splice(index, 1);
            }
        },
    }
</script>