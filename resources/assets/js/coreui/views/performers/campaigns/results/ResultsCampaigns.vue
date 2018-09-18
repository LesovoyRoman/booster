<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>

                    <b-card>

                        <b-form-group>
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-select dark v-model="sortBy" :options="sortOptions">
                                        <option slot="first" :value="null">Filter</option>
                                    </b-form-select>
                                    <b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
                                        <option :value="false">Low</option>
                                        <option :value="true">High</option>
                                    </b-form-select>
                                </b-input-group-prepend>
                                <b-form-input v-model="filter" placeholder="Type what you are looking for"/>
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
                                :items="campaigns"
                                :fields="fields"

                                :filter="filter"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                @filtered="onFiltered"

                                :current-page="currentPage"
                                :per-page="perPage">
                            <template
                                    slot="campaign_name"
                                    slot-scope="data">
                                <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'ResultCampaign', params: { campaign:campaign, id: id } }">{{ data.item.campaign_name }}</router-link>
                            </template>
                            <template slot="influencers" slot-scope="data">
                                {{ data.item.influencers }}
                            </template>
                            <template slot="points" slot-scope="data">
                                {{ data.item.points }}
                            </template>
                            <template slot="influence" slot-scope="data">
                                {{ data.item.influence }}%
                            </template>
                            <template
                                    slot="status"
                                    slot-scope="data" justified="center">
                                        <span :variant="getBadge(data.item.status)">
                                            <i v-for="k in data.item.status" class="star_active fa fa-star"></i>
                                            <i v-for="k in 2" v-if="data.item.status === 3" class="fa fa-star"></i>
                                            <i v-if="data.item.status === 4" class="fa fa-star"></i>
                                        </span>
                                        <span v-if="data.item.status === 3"> (60%)</span>
                                        <span v-if="data.item.status === 4"> (80%)</span>
                                        <span v-if="data.item.status === 5"> (100%)</span>
                            </template>
                            <template slot="active" slot-scope="data">
                                <span v-if="data.item.active !== 'Waiting for gifts'">{{ data.item.active }}</span>
                                <span v-if="data.item.active === 'Waiting for gifts'">
                                    <router-link v-bind:to="'/gifts/create-gift'">{{ data.item.active }}</router-link>
                                </span>
                            </template>
                            <template slot="turnover" slot-scope="data">
                                {{ data.item.turnover }} Rub
                            </template>
                        </b-table>
                        <nav>
                            <b-pagination
                                    :total-rows="getRowCount(campaigns)"
                                    :per-page="perPage"
                                    v-model="currentPage"
                                    prev-text="Prev"
                                    align="center"
                                    next-text="Next"
                                    hide-goto-end-buttons/>
                        </nav>

                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let arrPoints;

    export default {
        name: 'ResultsCampaigns',
        data () {
            return {
                header: 'Campaigns Results',

                campaigns: [
                    { id: 1, campaign_name: 'Snacks', points: '40000/30000', middle_price: '250 Rub', turnover: '4500000', checkingType: 'Photo',  status: 5, active: 'Active', influencers: 5, influence: '' },
                    { id: 2, campaign_name: 'Snacks', points: '70000/30000', middle_price: '500 Rub', turnover: '4500000', checkingType: 'Photo & Serial number',  status: 3, active: 'Inactive', influencers: 4, influence: '' },
                    { id: 3, campaign_name: 'Snacks', points: '70000/30000', middle_price: '375 Rub', turnover: '4500000', checkingType: 'Photo',  status: 4, active: 'Active', influencers: 3, influence: '' },
                    { id: 4, campaign_name: 'Snacks', points: '60000/50000', middle_price: '250 Rub', turnover: '7500000', checkingType: 'Serial number', status: 4, active: 'Archive', influencers: 2, influence: '' },
                    { id: 5, campaign_name: 'Snacks', points: '50000/35000', middle_price: '500 Rub', turnover: '5500000', checkingType: 'Serial number',  status: 5, active: 'Active', influencers: 3, influence: '' },
                    { id: 6, campaign_name: 'Snacks', points: '40000/30000', middle_price: '250 Rub', turnover: '4500000', checkingType: 'Photo', status: 5, active: 'Active', influencers: 4, influence: '' },
                    { id: 7, campaign_name: 'Snacks', points: '70000/30000', middle_price: '500 Rub', turnover: '4500000', checkingType: 'Photo',  status: 3, active: 'Inactive', influencers: 10, influence: '' },
                    { id: 8, campaign_name: 'Snacks', points: '70000/30000', middle_price: '375 Rub', turnover: '4500000', checkingType: 'Serial number',  status: 4, active: 'Active', influencers: 20, influence: '' },
                    { id: 9, campaign_name: 'Snacks', points: '60000/50000', middle_price: '250 Rub', turnover: '7500000', checkingType: 'Photo & Serial number',  status: 4, active: 'Active', influencers: 3, influence: '' },
                    { id: 10, campaign_name: 'Snacks', points: '50000/35000', middle_price: '500 Rub', turnover: '5500000', checkingType: 'Photo',  status: 5, active: 'Active', influencers: 5, influence: '' },
                    { id: 11, campaign_name: 'Snacks', points: '40000/30000', middle_price: '250 Rub', turnover: '4500000', checkingType: 'Photo',  status: 5, active: 'Archive', influencers: 2, influence: '' },
                    { id: 12, campaign_name: 'Snacks', points: '70000/30000', middle_price: '500 Rub', turnover: '4500000',  checkingType: 'Serial number', status: 3, active: 'Active', influencers: 7, influence: '' },
                    { id: 13, campaign_name: 'Snacks', points: '70000/30000', middle_price: '375 Rub', turnover: '4500000',  checkingType: 'Photo', status: 4, active: 'Inactive', influencers: 9, influence: '' },
                    { id: 14, campaign_name: 'Snacks', points: '60000/50000', middle_price: '250 Rub', turnover: '7500000',  checkingType: 'Serial number', status: 4, active: 'Active', influencers: 12, influence: '' },
                    { id: 15, campaign_name: 'Snacks', points: '50000/35000', middle_price: '500 Rub', turnover: '5500000', checkingType: 'Photo',  status: 5, active: 'Active', influencers: 16, influence: '' },
                    { id: 16, campaign_name: 'Snacks', points: '40000/30000', middle_price: '250 Rub', turnover: '4500000', checkingType: 'Photo & Serial number',  status: 5, active: 'Waiting for gifts', influencers: 14, influence: '' },
                    { id: 17, campaign_name: 'Snacks', points: '70000/30000', middle_price: '500 Rub', turnover: '4500000', checkingType: 'Photo & Serial number',  status: 3, active: 'Active', influencers: 13, influence: '' },
                    { id: 18, campaign_name: 'Snacks', points: '70000/30000', middle_price: '375 Rub', turnover: '4500000', checkingType: 'Photo',  status: 4, active: 'Inactive', influencers: 12, influence: '' },
                    { id: 19, campaign_name: 'Snacks', points: '60000/50000', middle_price: '250 Rub', turnover: '7500000', checkingType: 'Photo',  status: 4, active: 'Active', influencers: 12, influence: '' },
                    { id: 20, campaign_name: 'Snacks', points: '50000/35000', middle_price: '500 Rub', turnover: '5500000', checkingType: 'Photo',  status: 5, active: 'Arhive', influencers: 5, influence: '' },
                    { id: 21, campaign_name: 'Snacks', points: '40000/30000', middle_price: '250 Rub', turnover: '4500000', checkingType: 'Serial number',  status: 5, active: 'Archive', influencers: 8, influence: '' },
                    { id: 22, campaign_name: 'Snacks', points: '70000/30000', middle_price: '375 Rub', turnover: '4500000', checkingType: 'Photo',  status: 3, active: 'Active', influencers: 11, influence: '' },
                    { id: 23, campaign_name: 'Snacks', points: '70000/30000', middle_price: '375 Rub', turnover: '4500000',  checkingType: 'Serial number', status: 4, active: 'Inactive', influencers: 42, influence: '' },
                    { id: 24, campaign_name: 'Snacks', points: '60000/35000', middle_price: '500 Rub', turnover: '5500000',  checkingType: 'Photo & Serial number', status: 5, active: 'Active', influencers: 21, influence: '' },
                    { id: 25, campaign_name: 'Snacks', points: '40000/30000', middle_price: '250 Rub', turnover: '4500000',  checkingType: 'Photo', status: 4, active: 'Archive', influencers: 6, influence: '' },
                ],

                fields: [
                    { key: 'id', label: '№' },
                    { key: 'campaign_name', sortable: true, label: 'Name' },
                    { key: 'middle_price', sortable: true, label: 'Middle price', 'class': 'table_points' },
                    { key: 'influencers', sortable: true, label: 'Influencers' },
                    { key: 'points', sortable: true, label: 'Points', 'class': 'table_points'  },
                    { key: 'influence', sortable: true, label: 'Influence', 'class': 'table_influence' },
                    { key: 'checkingType', sortable: true, 'class': 'table_checkingType' },
                    { key: 'status', sortable: true, label: 'Satisfied' },
                    { key: 'active', sortable: true, label: 'Status' },
                    { key: 'turnover', sortable: true, 'class': 'table_turnoiver table_points' },
                ],
                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
            }
        },
        computed: {
            sortOptions () {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => { return { text: f.label, value: f.key } })
            }
        },
        methods: {
            getBadge (status) {
                return status === 5 ? 'success'
                    : status === 4 ? 'warning'
                        : status === 3 ? 'danger' : 'primary'
            },
            getRowCount (items) {
                return items.length
            },
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            countInfluence(){
                return this.campaigns.forEach(function(item){
                    arrPoints = item.points.split('/');
                    item.influence = Math.floor(((arrPoints[1] * 1) / (arrPoints[0] * 1)) * 100);
                })
            }
        },
        created(){
            this.countInfluence();
        }
    }
</script>