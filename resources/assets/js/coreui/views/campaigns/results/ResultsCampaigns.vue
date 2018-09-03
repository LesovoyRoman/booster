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
                            <template
                                    slot="status"
                                    slot-scope="data" justified="center">
                                        <span :variant="getBadge(data.item.status)">
                                            <i v-for="k in data.item.status" class="star_active fa fa-star"></i>
                                            <i v-for="k in 2" v-if="data.item.status === 3" class="fa fa-star"></i>
                                            <i v-if="data.item.status === 4" class="fa fa-star"></i>
                                        </span>

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
    export default {
        name: 'ResultsCampaigns',
        data () {
            return {
                header: 'Campaigns Results',

                campaigns: [
                    { id: 1, campaign_name: 'Snacks', points: '40000/30000', middle_price: '250 Rub',  status: 5, influencers: 5 },
                    { id: 2, campaign_name: 'Snacks', points: '70000/30000', middle_price: '500 Rub',  status: 3, influencers: 4 },
                    { id: 3, campaign_name: 'Snacks', points: '70000/30000', middle_price: '375 Rub',  status: 4, influencers: 3 },
                    { id: 4, campaign_name: 'Snacks', points: '60000/50000', middle_price: '250 Rub', status: 4, influencers: 2 },
                    { id: 5, campaign_name: 'Snacks', points: '50000/35000', middle_price: '500 Rub',  status: 5, influencers: 3 },
                    { id: 6, campaign_name: 'Snacks', points: '40000/30000', middle_price: '250 Rub', status: 5, influencers: 4 },
                    { id: 7, campaign_name: 'Snacks', points: '70000/30000', middle_price: '500 Rub',  status: 3, influencers: 10 },
                    { id: 8, campaign_name: 'Snacks', points: '70000/30000', middle_price: '375 Rub',  status: 4, influencers: 20 },
                    { id: 9, campaign_name: 'Snacks', points: '60000/50000', middle_price: '250 Rub',  status: 4, influencers: 3 },
                    { id: 10, campaign_name: 'Snacks', points: '50000/35000', middle_price: '500 Rub',  status: 5, influencers: 5 },
                    { id: 11, campaign_name: 'Snacks', points: '40000/30000', middle_price: '250 Rub',  status: 5, influencers: 2 },
                    { id: 12, campaign_name: 'Snacks', points: '70000/30000', middle_price: '500 Rub',  status: 3, influencers: 7 },
                    { id: 13, campaign_name: 'Snacks', points: '70000/30000', middle_price: '375 Rub',  status: 4, influencers: 9 },
                    { id: 14, campaign_name: 'Snacks', points: '60000/50000', middle_price: '250 Rub',  status: 4, influencers: 12 },
                    { id: 15, campaign_name: 'Snacks', points: '50000/35000', middle_price: '500 Rub',  status: 5, influencers: 16 },
                    { id: 16, campaign_name: 'Snacks', points: '40000/30000', middle_price: '250 Rub',  status: 5, influencers: 14 },
                    { id: 17, campaign_name: 'Snacks', points: '70000/30000', middle_price: '500 Rub',  status: 3, influencers: 13 },
                    { id: 18, campaign_name: 'Snacks', points: '70000/30000', middle_price: '375 Rub',  status: 4, influencers: 12 },
                    { id: 19, campaign_name: 'Snacks', points: '60000/50000', middle_price: '250 Rub',  status: 4, influencers: 12 },
                    { id: 20, campaign_name: 'Snacks', points: '50000/35000', middle_price: '500 Rub',  status: 5, influencers: 5 },
                    { id: 21, campaign_name: 'Snacks', points: '40000/30000', middle_price: '250 Rub',  status: 5, influencers: 8 },
                    { id: 22, campaign_name: 'Snacks', points: '70000/30000', middle_price: '375 Rub',  status: 3, influencers: 11 },
                    { id: 23, campaign_name: 'Snacks', points: '70000/30000', middle_price: '375 Rub',  status: 4, influencers: 42 },
                    { id: 24, campaign_name: 'Snacks', points: '60000/35000', middle_price: '500 Rub',  status: 5, influencers: 21 },
                    { id: 25, campaign_name: 'Snacks', points: '40000/30000', middle_price: '250 Rub',  status: 4, influencers: 6 },
                ],

                fields: [
                    { key: 'id', label: '№' },
                    { key: 'campaign_name', sortable: true, label: 'Name' },
                    { key: 'points', sortable: true, label: 'Points' },
                    { key: 'middle_price', sortable: true, label: 'Middle price' },
                    { key: 'influencers', sortable: true, label: 'Amount of influencers' },
                    { key: 'status', sortable: true, label: 'Status' },
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
            }
        },
    }
</script>