<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>

                    <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>

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
                                    slot="name"
                                    slot-scope="data">
                                <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'ResultCampaign', params: { campaign:campaign, id: id } }">{{ data.item.name }}</router-link>
                            </template>
                            <template slot="influencers" slot-scope="data">
                                {{ data.item.influencers }}
                            </template>
                            <template slot="points" slot-scope="data">
                                {{ data.item.points }} / {{ data.item.points_checked }}
                            </template>
                            <template slot="influence" slot-scope="data">
                                {{ data.item.influence }}%
                            </template>
                            <template
                                    slot="satisfied"
                                    slot-scope="data" justified="center">
                                        <span :variant="getBadge(data.item.satisfied)">
                                            <i v-for="k in 5" v-if="data.item.satisfied >= 75" class="star_active fa fa-star"></i>
                                            <i v-for="k in 4" v-if="data.item.satisfied > 60 && data.item.satisfied < 75" class="star_active fa fa-star"></i>
                                            <i v-for="k in 3" v-if="data.item.satisfied <= 60" class="star_active fa fa-star"></i>
                                            <i v-for="k in 1" v-if="data.item.satisfied > 60 && data.item.satisfied < 75" class="fa fa-star"></i>
                                            <i v-for="k in 2" v-if="data.item.satisfied <= 60" class="fa fa-star"></i>
                                        </span>
                                <span v-if="data.item.satisfied"> {{ data.item.satisfied }}%</span>
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
    import Loading from 'vue-loading-spinner/src/components/Circle8'
    let vm = {};
    let arrPoints;

    export default {
        name: 'ResultsCampaigns',
        components: {
            Loading
        },
        data () {
            return {
                header: 'Campaigns Results',
                loading: false,

                campaigns: [],

                fields: [
                    { key: 'id', label: '№' },
                    { key: 'name', sortable: true, label: 'Name' },
                    { key: 'product_price', sortable: true, label: 'Middle price', 'class': 'table_points' },
                    { key: 'influencers', sortable: true, label: 'Influencers' },
                    { key: 'points', sortable: true, label: 'Points', 'class': 'table_points'  },
                    { key: 'influence', sortable: true, label: 'Influence', 'class': 'table_influence' },
                    { key: 'checking_type', sortable: true, 'class': 'table_checkingType' },
                    { key: 'satisfied', sortable: true, label: 'Satisfied' },
                    { key: 'status', sortable: true, label: 'Status' },
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
            getBadge (satisfied) {
                return satisfied >= 75 ? 'success'
                    : satisfied > 60 && satisfied < 75 ? 'warning'
                        : satisfied <= 60 ? 'danger' : 'primary'
            },
            getRowCount (items) {
                return items.length
            },
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            countInfo(){
                return this.campaigns.forEach(function(item){
                    item.influence = Math.floor(((item.points_checked) / (item.points * 1)) * 100);
                    item.turnover = Math.floor(item.points_checked * item.product_price);
                })
            },
        },
        created(){
            vm = this;
            this.loading = true;
            axios.post('/getAllCampaigns', this.new_campaign).then(response => {
                this.loading = false;
                if(response.data.campaigns instanceof Array) {
                    // from DB
                    console.log('campaigns DB');
                    this.campaigns = response.data.campaigns
                } else {
                    // from Redis
                    console.log('campaigns Redis');
                    this.campaigns = JSON.parse(response.data.campaigns);
                }
                this.countInfo();
                console.log(JSON.parse(response.data.campaigns));
            }).catch( err => {
                this.loading = false;
                console.log(err.message)
            })
        }
    }
</script>