<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>

                        <b-form-group>
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-select dark v-model="user_city" :options="cities">
                                        <option slot="first" :value="null">All cities</option>
                                    </b-form-select>
                                </b-input-group-prepend>
                                <b-input-group-prepend>
                                    <b-form-select dark v-model="user_country" :options="countries">
                                        <option slot="first" :value="null">All countries</option>
                                    </b-form-select>
                                </b-input-group-prepend>
                                <b-input-group-prepend>
                                    <b-form-select dark v-model="user_type" :options="user_types">
                                        <option slot="first" :value="null">All users</option>
                                    </b-form-select>
                                </b-input-group-prepend>
                                <b-form-input v-model="filter" placeholder="Enter user name / country / city / type"/>
                                <b-input-group-append>
                                    <b-btn :variant="'primary'" :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                </b-input-group-append>

                            </b-input-group>
                        </b-form-group>


                        <b-table
                                :hover="false"
                                :striped="false"
                                :bordered="false"
                                :small="true"
                                :fixed="false"
                                responsive="sm"
                                :items="filtered(user_country, user_city, user_type)"
                                :fields="fields"

                                :filter="filter"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                @filtered="onFiltered"

                                :current-page="currentPage"
                                :per-page="perPage">
                            <template slot="HEAD_user_checkbox" slot-scope="data" >
                                <div class="custom-control custom-checkbox">
                                    <input
                                            type="checkbox"
                                            v-model="allSelected"
                                            :value="true"
                                            :id="'user_checkbox'"
                                            :name="'user_checkbox'"
                                            class="custom-control-input">
                                    <label
                                            @click="selectAll"
                                            style="display: block"
                                            class="custom-control-label"
                                            :for="'user_checkbox'"></label>
                                </div>
                            </template>
                            <template slot="user_checkbox" slot-scope="data">
                                <div class="custom-control custom-checkbox">
                                    <input
                                            type="checkbox"
                                            :value="data.item.id"
                                            v-model="usersIds"
                                            @click="select"
                                            :id="'user_checkbox' + data.item.id"
                                            :name="'user_checkbox' + data.item.id"
                                            class="custom-control-input">
                                    <label
                                            style="display: block"
                                            class="custom-control-label"
                                            :for="'user_checkbox' + data.item.id"></label>
                                </div>
                            </template>
                            <template slot="name" slot-scope="data">
                                <div @click="showModal(data.item)"></div>
                                <span>{{ data.item.name }}</span>
                            </template>
                            <template slot="change" justified="center" slot-scope="row">
                                <b-button size="sm" class="custom_btn_change" :variant="'primary'">
                                    <i class="icon-pencil"></i>
                                </b-button>
                            </template>
                            <template slot="delete" justified="center" slot-scope="row">
                                <b-button size="sm" @click="removeElement(row)" class="custom_btn_change" :variant="'primary'">
                                    <i class="icon-close"></i>
                                </b-button>
                            </template>
                        </b-table>

                        <nav>
                            <b-pagination
                                    :total-rows="filtered(user_country, user_city, user_type, true)"
                                    :per-page="perPage"
                                    align="center"
                                    v-model="currentPage"
                                    prev-text="Prev"
                                    next-text="Next"
                                    hide-goto-end-buttons>
                            </b-pagination>
                        </nav>

                    </b-card>
                </b-col>
            </b-row>
        </div>


        <b-modal id="modalUser" ref="modalUser" hide-footer hide-header>
            <button type="button" aria-label="Close" class="close" @click="closeModal">×</button>
            <h3>{{ user_modal.name }}</h3>

            <div class="margin-top-30"></div>

            <b-row>
                <b-col>
                    <span class="span-row" v-if="user_modal.birthYear">Year of birth:</span>
                    <span class="span-row" v-if="user_modal.email">Email:</span>
                    <span class="span-row" v-if="user_modal.city || user_modal.city">Living place:</span>
                    <span class="span-row" v-if="user_modal.facebook_id">Facebook ID:</span>
                    <span class="span-row" v-if="user_modal.id_phone">ID phone:</span>
                    <span class="span-row" v-if="user_modal.model_phone">Model:</span>
                </b-col>
                <b-col>
                    <span class="span-row" v-if="user_modal.birthYear">{{ user_modal.birthYear }}</span>
                    <span class="span-row" v-if="user_modal.email">{{ user_modal.email }}</span>
                    <span class="span-row" v-if="user_modal.city || user_modal.city">{{ user_modal.country }}, {{ user_modal.city }}</span>
                    <span class="span-row" v-if="user_modal.facebook_id">{{ user_modal.facebook_id }}</span>
                    <span class="span-row" v-if="user_modal.id_phone">{{ user_modal.id_phone }}</span>
                    <span class="span-row" v-if="user_modal.model_phone">{{ user_modal.model_phone }}</span>
                </b-col>
            </b-row>

            <div class="margin-top-30"></div>

            <b-row v-if="user_modal.campaigns">
                <b-col>
                    <span class="font500">Campaigns ({{ user_modal.campaigns.length }}):</span> <span v-for="(campaign, index) in user_modal.campaigns">{{ campaign }}<span v-if="index !== user_modal.campaigns.length - 1">, </span></span>
                </b-col>
            </b-row>
            <b-row v-if="user_modal.influencers">
                <b-col>
                    <span class="font500">Influencers ({{ user_modal.influencers.length }}):</span> <span v-for="(influencer, index) in user_modal.influencers">{{ influencer }}<span v-if="index !== user_modal.influencers.length - 1">, </span></span>
                </b-col>
            </b-row>

            <div class="margin-top-30"></div>

            <b-row>
                <b-col>
                    <span class="span-row" v-if="user_modal.sentAt">Sent on date:</span>
                    <span class="span-row" v-if="user_modal.typeCheck">Checking type:</span>
                    <span class="span-row" v-if="user_modal.grade">Grade:</span>
                </b-col>
                <b-col>
                    <span class="span-row" v-if="user_modal.sentAt">{{ user_modal.sentAt }}</span>
                    <span class="span-row" v-if="user_modal.typeCheck">{{ user_modal.typeCheck }}</span>
                    <span class="span-row" v-if="user_modal.grade">{{ user_modal.grade }}</span>
                </b-col>
            </b-row>

        </b-modal>
    </div>
</template>

<script>
    let vm = {};

    export default {
        name: 'UsersAdmin',
        data() {
            return {
                header: 'Users',
                user_city: null,
                user_country: null,
                user_type: null,

                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                sendTo: '',

                user_modal: {},

                countries: [],
                cities: [],
                user_types: [],

                selected: [],
                allSelected: false,
                usersIds: [],

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                users: [
                    {id: 1, name: 'Nikolas Kaje', birthYear: '1985', email: 'kageMatrix@unstopabble.com', country: 'USA', city: 'Los Angeles', facebook_id: '82374895232304', campaigns_amount: 1, type: 'performer', id_phone: '3485743', model_phone: 'Iphone', campaigns: ['Movies', 'Stories'], influencers: ['Zinedin Zidan', 'Romeo & Julieta', 'Kris Taker', 'Omar Hayam'], sentAt: '2019.05.17', typeCheck: 'Photo and serial number', grade: 5 },
                    {id: 2, name: 'Angelina Jolie', birthYear: '1988', email: 'msSmith@kill.com', country: 'Canada', city: 'Toronto', facebook_id: '23857223367043', campaigns_amount: 5, type: 'influencer', id_phone: '8234835', model_phone: 'Android', campaigns: ['Movies', 'Adventures', 'Love Stories', 'Tomb Raider'], sentAt: '2019.07.12', typeCheck: 'Photo', grade: 4 },
                    {id: 3, name: 'Marylin Monroe', birthYear: '1965', email: 'sexxxy@kiss.com', country: 'USA', city: 'New-Your', facebook_id: '5743897450385', campaigns_amount: 0, type: 'user', id_phone: '2355765', model_phone: 'Nokia', },
                ],
                fields: [
                    { key: 'user_checkbox', 'class': 'table_label_hidden check-box-users' },
                    { key: 'name', sortable: true, 'class': 'name_user' },
                    { key: 'birthYear', sortable: true, 'class': 'birthYear_user', },
                    { key: 'email', sortable: true, 'class': 'email_user' },
                    { key: 'country', sortable: true, 'class': 'country_user' },
                    { key: 'city', sortable: true, 'class': 'city_user' },
                    { key: 'facebook_id', sortable: true, 'class': 'facebook_id_user' },
                    { key: 'campaigns_amount', sortable: true, 'class': 'campaigns_amount_user' },
                    { key: 'change', label: '', 'class': 'table_label_hidden change-user' },
                    { key: 'delete', label: '', 'class': 'table_label_hidden delete-user' }
                ]
            }
        },
        created() {
            vm = this;
            vm.getOptions();
            axios.post('/getAllUsers').then(response => {
                //console.log(response.data)
                console.log(JSON.parse(response.data.users))
            }).catch( err => {
                console.log(err.message)
            })
        },
        methods: {
            getOptions(){
                this.users.forEach(function (item, i) {
                    if(!vm.cities.includes(item.city)) {
                        vm.cities.push(item.city);
                    }
                    if(!vm.countries.includes(item.country)) {
                        vm.countries.push(item.country);
                    }
                    if(!vm.user_types.includes(item.type)) {
                        vm.user_types.push(item.type);
                    }
                });
            },
            closeModal: function () {
                this.$refs.modalUser.hide();
            },
            showModal(item){
                vm.user_modal = item;
                this.$refs.modalUser.show();
            },
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            selectAll: function() {
                vm.allSelected = !vm.allSelected;
                vm.usersIds = [];

                if (vm.allSelected) {
                    vm.users.forEach(function(item){
                        vm.usersIds.push(item.id);
                    })
                }
            },
            async removeElement(item) {
                let check = await vm.$root.check();
                if (check === true) {
                    this.users.splice(item.index, 1);
                }
            },
            select: function() {
                vm.allSelected = false;
            },
            callFilters(data, country, city, type){
                data = vm.filterCountry(country, data);
                data = vm.filterCity(city, data);
                data = vm.filterType(type, data);
                return data;
            },
            filterCountry(type, data){
                switch (type) {
                    case null:
                        return data;
                        break;
                    default:
                        return data.filter(data => data.country === type);
                }
            },
            filterCity(type, data){
                switch (type) {
                    case null:
                        return data;
                        break;
                    default:
                        return data.filter(data => data.city === type);
                }
            },
            filterCountry(type, data){
                switch (type) {
                    case null:
                        return data;
                        break;
                    default:
                        return data.filter(data => data.type === type);
                }
            },
            filtered(country, city, type, count = false) {
                let datas = vm.tmpAllBonuses;
                datas = vm.callFilters(datas, country, city, type);
                if(count !== false) return datas.length;
                return datas;
            },
        },
        computed: {
            sortOptions () {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => { return { text: f.label, value: f.key } })
            },
        }
    }
</script>