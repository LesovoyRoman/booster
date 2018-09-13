<template>
    <div class="wrapper" id="myGifts">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>

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
                                <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'ProfileCampaign', params: { campaign:campaign, id: id } }">{{ data.item.campaign_name }}</router-link>
                            </template>
                            <template slot="points" slot-scope="data">
                                <span class="">{{ data.item.points }} points</span>

                                <span v-if="data.item.status === 'got'" class="float-right">
                                    <span class=""><i class="icon-check"></i> Received</span>
                                </span>
                                <span v-if="data.item.status === 'expects'" class="float-right">
                                    <span class="">Expecting...</span>
                                </span>
                            </template>
                            <template slot="code" slot-scope="data">
                                <p>Following code: <span class="float-right">{{ data.item.code }}</span></p>
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

                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};

    export default {
        name: 'MyGifts',
        data() {
            return {
                header: 'My gifts',

                currentPage: 1,
                perPage    : 9,
                totalRows  : 0,


                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                gifts: [
                    { id: 1, photo: '../images/iphone.png', name: 'Iphone 8', points: 10000, campaign_name: 'Snacks', status: 'expects', code: '4907384574598' },
                    { id: 2, photo: '../images/iphone.png', name: 'Iphone 7', points: 20000, campaign_name: 'Cheese', status: 'got', code: '8437589238542' },
                    { id: 3, photo: '../images/iphone.png', name: 'Iphone 8', points: 40000, campaign_name: 'Snacks', status: 'expects', code: '9203430924803' },
                    { id: 4, photo: '../images/iphone.png', name: 'Iphone 7', points: 50000, campaign_name: 'Smth', status: 'got', code: '5094385348534' },
                ],

                fields: [
                    { key: 'name', sortable: true, 'class': 'name_gift' },
                    { key: 'campaign_name', sortable: true, 'class': 'campaign_gift' },
                    { key: 'points', sortable: true, 'class': 'points_gift' },
                    { key: 'code', sortable: false, 'class': 'code_gift'}
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
        },
    }
</script>