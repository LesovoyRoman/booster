<template>
    <div class="wrapper" :campaign="computedCampaign">
        <div class="animated fadeIn" v-if="campaign">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }} of campaign {{ campaign.campaign_name }}</h2>
                </b-col>

                <b-col
                        sm="12"
                        md="12">
                    <b-card id="resultCampaign">

                            <b-tabs pills card>
                                <b-tab title="Sells" active>
                                    <div class="chart-wrapper">
                                        <line-chart :data="dataChart1" style="max-height: 65vh"></line-chart>
                                    </div>
                                </b-tab>
                                <b-tab title="Cities">

                                </b-tab>
                                <b-tab title="Auditory">
                                    <div class="chart-wrapper">
                                        <pie-chart :data="dataChart2" style="max-height: 65vh"></pie-chart>
                                    </div>
                                </b-tab>
                                <b-tab title="Rating">
                                    <div class="chart-wrapper">
                                        <bar-chart :data="dataChart3" style="max-height: 65vh"></bar-chart>
                                    </div>
                                </b-tab>
                            </b-tabs>

                        <div class="divider_custom"></div>

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
                                    slot="name"
                                    slot-scope="data">
                                <router-link :id="id = data.item.id" :data="influencer = data.item" :to="{ name: 'InfluencerBonuses', params: { influencer: influencer, id: id, campaign_name: campaign.campaign_name } }">{{ data.item.name }}</router-link>
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
    import LineChart from './../../charts/CustomChart.vue'
    import PieChart from './../../charts/PieCustom.vue'
    import BarChart from './../../charts/BarCustom.vue'
    let vm = {}

    export default {
        props: ['campaign'],
        components: {
            LineChart,
            PieChart,
            BarChart
        },
        name: 'ResultCampaign',
        data() {
            return {
                header: 'Results',
                dataChart1: [
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5
                ],
                dataChart2: [
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                ],
                dataChart3: [
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                    Math.floor(Math.random() * 45) + 5,
                ],


                influencersList: [
                    {id: 1, name: 'Maria Adolfovna', points: '50000', checked_points: '35000', status: 5},
                    {id: 2, name: 'Maria Adolfovna', points: '40000', checked_points: '25000', status: 4},
                    {id: 3, name: 'Maria Adolfovna', points: '30000', checked_points: '15000', status: 4},
                    {id: 4, name: 'Maria Adolfovna', points: '50000', checked_points: '35000', status: 5},
                    {id: 5, name: 'Maria Adolfovna', points: '40000', checked_points: '25000', status: 3},
                    {id: 6, name: 'Maria Adolfovna', points: '30000', checked_points: '15000', status: 4},
                    {id: 7, name: 'Maria Adolfovna', points: '50000', checked_points: '35000', status: 3},
                    {id: 8, name: 'Maria Adolfovna', points: '40000', checked_points: '25000', status: 3},
                    {id: 9, name: 'Maria Adolfovna', points: '30000', checked_points: '15000', status: 5},
                    {id: 10, name: 'Maria Adolfovna', points: '50000', checked_points: '35000', status: 5},
                    {id: 11, name: 'Maria Adolfovna', points: '40000', checked_points: '25000', status: 5},
                    {id: 12, name: 'Maria Adolfovna', points: '30000', checked_points: '15000', status: 4},
                    {id: 13, name: 'Maria Adolfovna', points: '50000', checked_points: '35000', status: 3},
                    {id: 14, name: 'Maria Adolfovna', points: '40000', checked_points: '25000', status: 4},
                    {id: 15, name: 'Maria Adolfovna', points: '30000', checked_points: '15000', status: 4},

                ],
                fields: [
                    { key: 'id', label: '№' },
                    { key: 'name', sortable: true, label: 'Name' },
                    { key: 'points', sortable: true, label: 'Points'  },
                    { key: 'checked_points', sortable: true, label: 'Checked' },
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
        beforeCreate(){
            vm = this;
        },
        computed: {
            computedCampaign: function() {
                if(typeof this.campaign === 'undefined') {
                    vm.$router.go(-1)
                }
            },
            sortOptions () {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => { return { text: f.labelOption, value: f.key } })
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
        }
    }
</script>