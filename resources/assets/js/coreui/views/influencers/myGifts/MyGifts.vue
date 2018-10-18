<template>
    <div class="wrapper" id="myGifts">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>

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
                                    <keep-alive>
                                        <img v-if="data.item.images.length !== 0" :src="storage_path + '/' + data.item.images[0].image_path" alt="photo" class="photo_gift_table">
                                        <img v-else :src="storage_path + '/' + noimage" alt="photo" class="photo_gift_table">
                                    </keep-alive>
                                </div>
                                <div class="gift-name-block">
                                    {{ data.item.name }}
                                </div>
                            </template>
                            <template slot="campaign_name" slot-scope="data">
                                <router-link :id="id = data.item.campaign.id" :data="campaign = data.item.campaign" :to="{ name: 'ProfileCampaign', params: { campaign:campaign, id: id } }">{{ data.item.campaign.name }}</router-link>
                            </template>
                            <template slot="points" slot-scope="data">
                                <span class="">{{ data.item.points }} points</span>

                                <span v-if="data.item.status === 'received'" class="float-right">
                                    <span class=""><i class="icon-check"></i> Received</span>
                                </span>
                                <span v-if="data.item.status === 'ordered'" class="float-right">
                                    <span class="">Ordered</span>
                                </span>
                                <span v-if="data.item.status === 'sent'" class="float-right">
                                    <span class="">Expecting...</span>
                                </span>
                                <span class="float-right" v-else>
                                    <span>In progress...</span>
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

    import Loading from 'vue-loading-spinner/src/components/Circle8'

    export default {
        name: 'MyGifts',
        components: {
            Loading
        },
        data() {
            return {
                header: 'My gifts',
                loading: false,

                currentPage: 1,
                perPage    : 9,
                totalRows  : 0,

                storage_path: '',
                noimage: 'images/noimage.jpg',

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                gifts: [],

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
            this.storage_path = this.$root.storage_path;
            this.loading = true;
            axios.post('/getAllGiftsInfluencer').then(response => {
                this.loading = false;
                if(response.data.gifts instanceof Array) {
                    this.gifts = response.data.gifts
                }
                if(response.data.errors){
                    vm.$swal('Unfortunately:', response.data.errors, 'error')
                }
            }).catch( err => {
                this.loading = false;
                console.log(err.message)
            })
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