<template>
    <div class="wrapper" id="catalogGifts">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <b-col v-if="loading">
                    <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>
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
                                        <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'ProfileCampaign', params: { campaign:campaign, id: id } }">{{ data.item.campaign_name }}</router-link>
                                    </template>
                                    <template slot="points" slot-scope="data">
                                        <span class="font500">{{ data.item.points }} points</span>

                                        <b-button v-if="data.item.campaign_checked_points && data.item.points <= data.item.campaign_checked_points" class="btn float-right btn-secondary uppercase font500" @click="orderGift(data.item)">get</b-button>
                                    </template>
                                    <div class="clearfix"></div>
                                    <template slot="delivery" slot-scope="data">
                                        <div class="clearfix"></div>
                                        <span class="span-row text-left">Delivery: {{ data.item.delivery }}</span>
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

                            <b-tab v-for="(campaign_gifts, index) in campaigns_gifts" :key="'campaign_gift_' + index" :title="campaign_gifts.campaign.name">
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
                                        :items="campaign_gifts.gifts"
                                        :fields="fields"
                                        class="table_offers"

                                        :filter="filter"
                                        :sort-by.sync="sortBy"
                                        :sort-desc.sync="sortDesc"
                                        :sort-direction="sortDirection"
                                        @filtered="onFiltered"

                                        :per-page="999">
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
                                    <template slot="campaign_name" slot-scope="data"></template>
                                    <template slot="points" slot-scope="data">
                                        <span class="font500">{{ data.item.points }} points</span>

                                        <b-button v-if="data.item.campaign_checked_points && data.item.points <= data.item.campaign_checked_points" class="btn float-right btn-secondary uppercase font500" @click="orderGift(data.item)">get</b-button>
                                    </template>
                                    <div class="clearfix"></div>
                                    <template slot="delivery" slot-scope="data">
                                        <div class="clearfix"></div>
                                        <span class="span-row text-left">Delivery: {{ data.item.delivery }}</span>
                                    </template>
                                </b-table>
                            </b-tab>

                        </b-tabs>

                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    import Loading from 'vue-loading-spinner/src/components/Circle8'
    let vm = {};

    export default {
        name: 'CatalogGifts',
        components: {
            Loading
        },
        data(){
            return {
                header: 'Catalog gifts',
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
                campaigns_gifts: [],

                fields: [
                    { key: 'name', sortable: true, 'class': 'name_gift' },
                    { key: 'points', sortable: true, 'class': 'points_gift' },
                    { key: 'campaign_name', sortable: true, 'class': 'campaign_name' },
                    { key: 'delivery', sortable: false, 'class': '' }
                ],
            }
        },
        created(){
            this.loading = true;
            this.storage_path = this.$root.storage_path;
            vm = this;
            axios.post('/getCatalogGifts').then(response => {
                this.loading = false;
                if(response.data.campaigns_gifts instanceof Array) {
                    let campaigns_gifts = response.data.campaigns_gifts;
                    campaigns_gifts.forEach(function (item) {
                        item.gifts.forEach(function (item_gift) {
                            vm.$set(item_gift, 'campaign_name', item.campaign.name);
                            vm.$set(item_gift, 'campaign_checked_points', item.campaign.influencer_points[0]); // add influencer points for comparing
                            vm.gifts.push(item_gift); // push to all gifts
                        });
                        vm.campaigns_gifts.push(item); // push to campaign gifts (tabs)
                    });
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
            filtered(items, type) {
                return items
                    .filter(f => f.campaign_name === type)
            },
            orderGift(item) {
                this.loading = true;
                /*axios.post('/orderGift', {gift_id: item.id}).then(response => {
                    //this.loading = false;
                    console.log(response);
                }).catch(err => {
                    this.loading = false;
                    console.log(err);
                })*/
            }
        }
    }
</script>