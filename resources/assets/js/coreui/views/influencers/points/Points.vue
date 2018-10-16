<template>
    <div class="wrapper" id="points">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <loading v-if="loading" style="position: fixed; margin-left: -20px; left: 50%; top: 50%"></loading>

                <b-col  v-if="!loading"
                        sm="12"
                        md="12">
                    <b-card>

                        <b-form-group>
                            <b-input-group>
                                <b-form-input v-model="filter" placeholder="Type name of campaign or manufacturer"/>
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
                                :items="points"
                                :fields="fields"
                                class="table_invites"

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
                                <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'ProfileCampaign', params: { campaign:campaign, id: id } }">{{ data.item.name }}</router-link>
                            </template>
                            <template slot="points" slot-scope="data">
                                {{ data.item.all_points }} \ {{ data.item.checked_points }}
                            </template>
                        </b-table>

                        <nav>
                            <b-pagination
                                    :total-rows="getRowCount(points)"
                                    :per-page="perPage"
                                    align="center"
                                    v-model="currentPage"
                                    prev-text="Prev"
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

    import Loading from 'vue-loading-spinner/src/components/Circle8'

    export default {
        name: 'Points',
        components: {
            Loading
        },
        data() {
            return {
                header: 'My points',
                loading: false,

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                points: [],

                fields: [
                    { key: 'name', sortable: true, 'class': 'table_campaign_name' },
                    { key: 'company', label: 'Manufacturer', sortable: false, 'class': 'table_manufacturer' },
                    { key: 'points', sortable: true, 'class': 'table_points' },
                    { key: 'min_gift', sortable: true, 'class': 'table_min_gift' },
                    { key: 'max_gift', sortable: true, 'class': 'table_max_gift' }
                ],
            }
        },
        created() {
            vm = this;
            this.loading = true;
            axios.post('/influencerCampaignPoints').then(response => {
                this.loading = false;
                if (response.data.campaigns instanceof Array) {
                    this.points = response.data.campaigns
                }
                if(response.data.errors){
                    vm.$swal( 'Unfortunately:', response.data.errors, 'error')
                }
            }).catch( err => {
                this.loading = false;
                console.log(err.message)
            })
        },
        methods: {
            onFiltered (filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            getRowCount (items) {
                return items.length
            },
        },
    }
</script>