<template>
    <div class="wrapper" id="catalogGifts">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>

                        <b-tabs pills card>
                            <b-tab title="All" active>
                                <b-form-group>
                                    <b-input-group>
                                        <b-form-input v-model="filter" placeholder="Type campaign name or gift"/>
                                        <b-input-group-append>
                                            <b-btn :variant="'primary'" :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>

                                <b-table
                                        :id="'table_cards'"
                                        :hover="false"
                                        :striped="false"
                                        :bordered="false"
                                        :small="true"
                                        :fixed="false"
                                        responsive="sm"
                                        :items="gifts"
                                        :fields="fields"
                                        class="table_offers"

                                        :filter="filter"
                                        :sort-by.sync="sortBy"
                                        :sort-desc.sync="sortDesc"
                                        :sort-direction="sortDirection"
                                        @filtered="onFiltered"

                                        :current-page="currentPage"
                                        :per-page="perPage">
                                    <template slot="name" slot-scope="data">
                                        <div class="photo_gift-block">
                                            <keep-alive><img :src="data.item.photo" alt="photo_item" class="photo_gift_table"></keep-alive>
                                        </div>
                                        <div class="gift-name-block">
                                            {{ data.item.name }}
                                        </div>
                                    </template>
                                    <template slot="campaign_name" slot-scope="data">
                                        <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'Campaign', params: { campaign:campaign, id: id } }">{{ data.item.campaign_name }}</router-link>
                                    </template>
                                    <template slot="points" slot-scope="data">
                                        <span class="font500">{{ data.item.points }} points</span>

                                        <b-button v-if="data.item.points > 10000" class="btn float-right btn-secondary uppercase font500">get</b-button>
                                    </template>
                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(gifts)"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPage"
                                            prev-text="Prev"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>

                            </b-tab>
                        </b-tabs>

                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};

    export default {
        name: 'CatalogGifts',
        data(){
            return {
                header: 'Catalog gifts',

                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,


                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                gifts: [
                    { id: 1, photo: '../images/6.jpg', name: 'Iphone 8', points: 10000, campaign_name: 'Snacks' },
                    { id: 2, photo: '../images/7.jpg', name: 'Iphone 7', points: 20000, campaign_name: 'Cheese' }, { id: 3, photo: '../images/8.jpg', name: 'Iphone 8', points: 40000, campaign_name: 'Snacks' },
                    { id: 4, photo: '../images/9.jpg', name: 'Iphone 7', points: 50000, campaign_name: 'Smth' },
                ],

                fields: [
                    { key: 'name', sortable: true, 'class': 'name_gift' },
                    { key: 'points', sortable: true, 'class': 'points_gift' },
                    { key: 'campaign_name', sortable: true, 'class': 'campaign_gift' },
                ],
            }
        },
        created(){
            vm = this;
        },
        methods: {
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            getRowCount (items) {
                return items.length
            },
        }
    }
</script>