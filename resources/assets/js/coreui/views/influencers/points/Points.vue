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
                                    slot="campaign_name"
                                    slot-scope="data">
                                <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'Campaign', params: { campaign:campaign, id: id } }">{{ data.item.campaign_name }}</router-link>
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

    export default {
        name: 'Points',
        data() {
            return {
                header: 'My points',

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                points: [
                    {id: 1, campaign_name: 'Snacks', manufacturer: 'Danone', points: '60000/45000', min_gift: '2020', max_gift: '1500' },
                    {id: 2, campaign_name: 'Cheese', manufacturer: 'Danissimo', points: '50000/40000', min_gift: '3800', max_gift: '1200' },
                    {id: 3, campaign_name: 'Snacks', manufacturer: 'Danone', points: '40000/45000', min_gift: '2600', max_gift: '1500' },
                    {id: 4, campaign_name: 'Cheese', manufacturer: 'Danissimo', points: '70000/40000', min_gift: '3300', max_gift: '1200' },
                    {id: 5, campaign_name: 'Snacks', manufacturer: 'Danone', points: '80000/45000', min_gift: '2000', max_gift: '1500' },
                    {id: 6, campaign_name: 'Cheese', manufacturer: 'Danissimo', points: '50000/40000', min_gift: '3100', max_gift: '1200' },
                    {id: 7, campaign_name: 'Snacks', manufacturer: 'Danone', points: '60000/35000', min_gift: '200', max_gift: '1700' },
                    {id: 8, campaign_name: 'Cheese', manufacturer: 'Danissimo', points: '50000/40000', min_gift: '3400', max_gift: '1200' },
                    {id: 9, campaign_name: 'Snacks', manufacturer: 'Danone', points: '60000/55000', min_gift: '2700', max_gift: '1500' },
                    {id: 10, campaign_name: 'Cheese', manufacturer: 'Danissimo', points: '90000/40000', min_gift: '300', max_gift: '1300' },
                    {id: 11, campaign_name: 'Snacks', manufacturer: 'Danone', points: '60000/75000', min_gift: '2040', max_gift: '1500' },
                    {id: 12, campaign_name: 'Cheese', manufacturer: 'Danissimo', points: '50000/40000', min_gift: '3600', max_gift: '15600' },
                    {id: 13, campaign_name: 'Snacks', manufacturer: 'Danone', points: '60000/45000', min_gift: '200', max_gift: '1500' },
                    {id: 14, campaign_name: 'Cheese', manufacturer: 'Danissimo', points: '40000/40000', min_gift: '3800', max_gift: '100' },
                    {id: 15, campaign_name: 'Snacks', manufacturer: 'Danone', points: '60000/40000', min_gift: '2040', max_gift: '1500' },
                    {id: 16, campaign_name: 'Cheese', manufacturer: 'Danissimo', points: '20000/40000', min_gift: '300', max_gift: '1500' },

                ],

                fields: [
                    { key: 'campaign_name', sortable: true, 'class': 'table_campaign_name' },
                    { key: 'manufacturer', sortable: false, 'class': 'table_manufacturer' },
                    { key: 'points', sortable: true, 'class': 'table_points' },
                    { key: 'min_gift', sortable: true, 'class': 'table_min_gift' },
                    { key: 'max_gift', sortable: true, 'class': 'table_max_gift' }
                ],
            }
        },
        created() {
            vm = this;
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