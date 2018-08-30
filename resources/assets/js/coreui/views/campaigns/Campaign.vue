<template>
    <div :campaign="computedCampaign" class="wrapper">
        <div class="animated fadeIn" v-if="campaign">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }} {{ campaign.campaign_name }}</h2>
                    <b-card>
                        id campaign => {{ campaign.id }}

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
                                <b-form-input v-model="filter" placeholder="Type name of influencer"/>
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
                                :items="influencersList"
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
                                <router-link :data="campaign = data.item" :to="{ name: 'Campaign', params: { campaign } }">{{ data.item.campaign_name }}</router-link>
                            </template>
                            <template
                                    slot="status"
                                    slot-scope="data" justified="center">
                                <b-badge :variant="getBadge(data.item.status)">{{ data.item.status }}</b-badge>
                            </template>
                            <template slot="change" justified="center" slot-scope="row">
                                <b-button size="sm" class="custom_btn_change" :variant="'primary'">
                                    <i class="icon-pencil"></i>
                                </b-button>
                            </template>
                        </b-table>

                        <nav>
                            <b-pagination
                                    :total-rows="getRowCount(influencersList)"
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
    let vm = {};

    export default {
        props: ['campaign'],
        name: 'Campaign',
        data () {
            return {
                header: 'Campaign',

                influencersList: [
                    {id: 1, name: 'Maria Adolfovna', points: '50000', checked_points: '35000', check_type: 'Photo with recognition', status: 'All checked'},
                    {id: 2, name: 'Maria Adolfovna', points: '40000', checked_points: '25000', check_type: 'Photo with recognition', status: 'check'},
                    {id: 3, name: 'Maria Adolfovna', points: '30000', checked_points: '15000', check_type: 'Scanning', status: ''},
                    {id: 4, name: 'Maria Adolfovna', points: '50000', checked_points: '35000', check_type: 'Photo with recognition', status: 'All checked'},
                    {id: 5, name: 'Maria Adolfovna', points: '40000', checked_points: '25000', check_type: 'Photo with recognition', status: 'check'},
                    {id: 6, name: 'Maria Adolfovna', points: '30000', checked_points: '15000', check_type: 'Scanning', status: ''},
                    {id: 7, name: 'Maria Adolfovna', points: '50000', checked_points: '35000', check_type: 'Photo with recognition', status: 'All checked'},
                    {id: 8, name: 'Maria Adolfovna', points: '40000', checked_points: '25000', check_type: 'Photo with recognition', status: 'check'},
                    {id: 9, name: 'Maria Adolfovna', points: '30000', checked_points: '15000', check_type: 'Scanning', status: ''},
                    {id: 10, name: 'Maria Adolfovna', points: '50000', checked_points: '35000', check_type: 'Photo with recognition', status: 'All checked'},
                    {id: 11, name: 'Maria Adolfovna', points: '40000', checked_points: '25000', check_type: 'Photo with recognition', status: 'check'},
                    {id: 12, name: 'Maria Adolfovna', points: '30000', checked_points: '15000', check_type: 'Scanning', status: ''},
                    {id: 13, name: 'Maria Adolfovna', points: '50000', checked_points: '35000', check_type: 'Photo with recognition', status: 'All checked'},
                    {id: 14, name: 'Maria Adolfovna', points: '40000', checked_points: '25000', check_type: 'Photo with recognition', status: 'check'},
                    {id: 15, name: 'Maria Adolfovna', points: '30000', checked_points: '15000', check_type: 'Scanning', status: ''},

                ],
                fields: [
                    { key: 'id', label: '№' },
                    { key: 'name', sortable: true, label: 'Name' },
                    { key: 'points', sortable: true, label: 'Points'  },
                    { key: 'checked_points', sortable: true, label: 'Checked' },
                    { key: 'check_type', sortable: true, label: 'Type checking' },
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
        mounted() {

        },
        beforeCreate(){
            vm = this;
        },
        computed: {
            computedCampaign: function() {
                if(typeof this.campaign === 'undefined') {
                    vm.$router.push('/campaigns');
                }
            },
            sortOptions () {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => { return { text: f.label, value: f.key } })
            }
        },
        methods: {
            getBadge (status) {
                return status === 'All checked' ? 'success'
                        : status === 'check' ? 'primary' : 'primary'
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