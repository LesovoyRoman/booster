<template>
    <div class="wrapper" id="offers">
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

                        <b-input-group-append class="pull-right typeRenderGifts">
                            <div class="">
                                <input
                                        type="checkbox"
                                        id="customCheckboxInfluencersList"
                                        name="customCheckboxCountry"
                                        class="custom-control-input"
                                        v-model="offersList"
                                        v-on:change="filterMedia(false)">
                                <label
                                        style="display: block"
                                        class="control-type-grid control-type-grid-list"
                                        for="customCheckboxInfluencersList"></label>
                            </div>
                            <div class="">
                                <input
                                        type="checkbox"
                                        id="customCheckboxInfluencersCards"
                                        name="customCheckboxCountry"
                                        class="custom-control-input"
                                        v-on:change="filterMedia(true)"
                                        v-model="offersCards">
                                <label
                                        style="display: block"
                                        class="control-type-grid control-type-grid-cards"
                                        for="customCheckboxInfluencersCards"></label>
                            </div>
                        </b-input-group-append>

                        <b-tabs pills card>
                            <b-tab title="All" active>
                                <b-form-group>
                                    <b-input-group>
                                        <b-form-input v-model="filter" placeholder="Type word"/>
                                        <b-input-group-append>
                                            <b-btn :variant="'primary'" :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>

                                <span class="span-row font500">Total offers: {{ offers.length }}</span>

                                <b-table
                                        :id="offersCards ? 'table_cards' : ''"
                                        :hover="false"
                                        :striped="false"
                                        :bordered="false"
                                        :small="true"
                                        :fixed="false"
                                        responsive="sm"
                                        :items="offers"
                                        :fields="fields"
                                        class="table_offers"

                                        :filter="filter"
                                        :sort-by.sync="sortBy"
                                        :sort-desc.sync="sortDesc"
                                        :sort-direction="sortDirection"
                                        @filtered="onFiltered"

                                        :current-page="currentPageAll"
                                        :per-page="perPage">
                                    <template
                                            slot="campaign_name"
                                            slot-scope="data">
                                        <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'ProfileCampaign', params: { campaign:campaign, id: id, tabGifts: false  } }">{{ data.item.name }}</router-link>
                                    </template>
                                    <template slot="HEAD_status_user" slot-scope="data">

                                    </template>
                                    <template slot="product_price" slot-scope="data">
                                        <span class="showsTableCards">Price:</span> {{ data.item.product_price }}
                                    </template>
                                    <template slot="conditions" slot-scope="data">
                                        <span class="showsTableCards">Conditions:</span> {{ data.item.conditions }}
                                    </template>
                                    <template slot="gift" slot-scope="data">
                                        <span class="showsTableCards">Main gift:</span> <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'ProfileCampaign', params: { campaign:campaign, id: id, tabGifts: true } }">{{ data.item.gift }}</router-link>
                                    </template>
                                    <template slot="end_campaign" slot-scope="data">
                                        <span class="showsTableCards">Campaign ends:</span>
                                        <span class="font500-cards">
                                            <span v-if="data.item.end_campaign !== '2000-01-01 00:00:00'">{{ data.item.end_campaign }}</span>
                                            <span v-if="data.item.end_campaign === '2000-01-01 00:00:00'"><strong>{{ data.item.end_points }}</strong> points</span>
                                        </span>
                                    </template>
                                    <template slot="campaign_user_status" slot-scope="row">
                                        <div v-if="row.item.campaign_user_status === 'accepted'">
                                            <span class="statusOfferConsider"><i class="icon-check"></i>
                                                Joined
                                            </span>
                                        </div>
                                        <div v-if="row.item.campaign_user_status === 'declined'">
                                            <span class="statusOfferParticipating">
                                                Declined
                                            </span>
                                        </div>
                                        <div v-if="!row.item.campaign_user_status">
                                            <div v-if="offersCards === true" style="margin-top: 15px">
                                                <b-row>
                                                    <b-col md="8">
                                                        <b-button variant="primary" class="font500 uppercase" @click="changeStatusCampaign(row, '/acceptCampaign').then(function(response){ row.item.campaign_user_status = response})">join</b-button>
                                                    </b-col>
                                                    <b-col md="4">
                                                        <b-button size="sm" @click="changeStatusCampaign(row, '/declineCampaign').then(function(response){ row.item.campaign_user_status = response});" class="custom_btn_change" :variant="'primary'">
                                                            <i class="icon-close"></i>
                                                        </b-button>
                                                    </b-col>
                                                </b-row>
                                            </div>
                                            <div v-if="offersCards === false">
                                                <b-button variant="primary" class="font500 uppercase" @click="changeStatusCampaign(row, '/acceptCampaign').then(function(response){ row.item.campaign_user_status = response})">join</b-button>
                                                <b-button size="sm" @click="changeStatusCampaign(row, '/declineCampaign').then(function(response){ row.item.campaign_user_status = response});" class="custom_btn_change" :variant="'primary'">
                                                    <i class="icon-close"></i>
                                                </b-button>
                                            </div>
                                        </div>
                                    </template>
                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(offers)"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPageAll"
                                            prev-text="Prev"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>

                            </b-tab>
                            <b-tab title="My">
                                <b-form-group>
                                    <b-input-group>
                                        <b-form-input v-model="filter" placeholder="Type word"/>
                                        <b-input-group-append>
                                            <b-btn :variant="'primary'" :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>

                                <span class="span-row font500">My accepted\declined offers: {{ my_offers.length }}</span>

                                <b-table
                                        :id="offersCards ? 'table_cards' : ''"
                                        :hover="false"
                                        :striped="false"
                                        :bordered="false"
                                        :small="true"
                                        :fixed="false"
                                        responsive="sm"
                                        :items="my_offers"
                                        :fields="fields"
                                        class="table_offers"

                                        :filter="filter"
                                        :sort-by.sync="sortBy"
                                        :sort-desc.sync="sortDesc"
                                        :sort-direction="sortDirection"
                                        @filtered="onFiltered"

                                        :current-page="currentPageMy"
                                        :per-page="perPage">
                                    <template
                                            slot="campaign_name"
                                            slot-scope="data">
                                        <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'ProfileCampaign', params: { campaign:campaign, id: id, tabGifts: false  } }">{{ data.item.name }}</router-link>
                                    </template>
                                    <template slot="HEAD_status_user" slot-scope="data">

                                    </template>
                                    <template slot="product_price" slot-scope="data">
                                        <span class="showsTableCards">Price:</span> {{ data.item.product_price }}
                                    </template>
                                    <template slot="conditions" slot-scope="data">
                                        <span class="showsTableCards">Conditions:</span> {{ data.item.conditions }}
                                    </template>
                                    <template slot="gift" slot-scope="data">
                                        <span class="showsTableCards">Main gift:</span> <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'ProfileCampaign', params: { campaign:campaign, id: id, tabGifts: true } }">{{ data.item.gift }}</router-link>
                                    </template>
                                    <template slot="end_campaign" slot-scope="data">
                                        <span class="showsTableCards">Campaign ends:</span>
                                        <span class="font500-cards">
                                            <span v-if="data.item.end_campaign !== '2000-01-01 00:00:00'">{{ data.item.end_campaign }}</span>
                                            <span v-if="data.item.end_campaign === '2000-01-01 00:00:00'"><strong>{{ data.item.end_points }}</strong> points</span>
                                        </span>
                                    </template>
                                    <template slot="campaign_user_status" slot-scope="row">
                                        <div v-if="row.item.campaign_user_status === 'accepted'">
                                            <span class="statusOfferConsider"><i class="icon-check"></i>
                                                Joined
                                            </span>
                                        </div>
                                        <div v-if="row.item.campaign_user_status === 'declined'">
                                            <span class="statusOfferParticipating">
                                                Declined
                                            </span>
                                        </div>
                                        <div v-if="!row.item.campaign_user_status">
                                            <div v-if="offersCards === true" style="margin-top: 15px">
                                                <b-row>
                                                    <b-col md="8">
                                                        <b-button variant="primary" class="font500 uppercase" @click="changeStatusCampaign(row, '/acceptCampaign').then(function(response){ row.item.campaign_user_status = response})">join</b-button>
                                                    </b-col>
                                                    <b-col md="4">
                                                        <b-button size="sm" @click="changeStatusCampaign(row, '/declineCampaign').then(function(response){ row.item.campaign_user_status = response});" class="custom_btn_change" :variant="'primary'">
                                                            <i class="icon-close"></i>
                                                        </b-button>
                                                    </b-col>
                                                </b-row>
                                            </div>
                                            <div v-if="offersCards === false">
                                                <b-button variant="primary" class="font500 uppercase" @click="changeStatusCampaign(row, '/acceptCampaign').then(function(response){ row.item.campaign_user_status = response})">join</b-button>
                                                <b-button size="sm" @click="changeStatusCampaign(row, '/declineCampaign').then(function(response){ row.item.campaign_user_status = response});" class="custom_btn_change" :variant="'primary'">
                                                    <i class="icon-close"></i>
                                                </b-button>
                                            </div>
                                        </div>
                                    </template>
                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(my_offers)"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPageMy"
                                            prev-text="Prev"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>
                            </b-tab>
                            <b-tab title="Archive">

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

    import Loading from 'vue-loading-spinner/src/components/Circle10'

    export default {
        name: 'Offers',
        components: {
            Loading
        },
        data(){
            return {
                header: 'Offers',

                loading: false,

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                currentPageAll: 1,
                currentPageMy: 1,
                perPage    : 10,
                totalRows  : 0,

                my_offers: [],
                offers: [],

                fields: [
                    { key: 'campaign_name', sortable: true, 'class': 'table_campaign_name' },
                    { key: 'product_price', sortable: true, 'class': 'table_product_price' },
                    { key: 'conditions', sortable: false, 'class': 'table_conditions' },
                    { key: 'gift', label: 'Main gift', sortable: false, 'class': 'table_gift' },
                    { key: 'end_campaign', sortable: true, 'class': 'table_end_campaign'  },
                    { key: 'campaign_user_status', sortable: true, 'class': 'table_label_hidden table_status_user' },
                ],

                offersList: true,
                offersCards: false,
            }
        },
        methods: {
            onFiltered (filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPageAll = 1;
                this.currentPageMy = 1;
            },
            getRowCount (items) {
                return items.length
            },
            filterMedia(val){
                val ? vm.offersList = false : vm.offersList = true;
                val ? vm.offersCards = true : vm.offersCards = false;
                val ? vm.perPage = 9 : vm.perPage = 10;
            },
            changeStatusCampaign(row, url) {
                if (confirm("Are you sure?")) {
                    this.loading = true;
                    let campaign_id = row.item.id;
                    return axios.post(url, {campaign_id: campaign_id})
                        .then(response => {
                            this.loading = false;
                            if(response.data.status_campaign){
                                vm.$notify({
                                    type:  response.data.response,
                                    title: 'Campaign ' + response.data.status_campaign + '!',
                                })
                                vm.my_offers.push(row.item);
                                vm.offers.splice(row.index, 1);
                                return response.data.status_campaign
                             }
                             if(response.data.error){
                                 vm.$notify({
                                     type:  response.data.response,
                                     title: 'Error',
                                     text: response.data.error,
                                 })
                                 return row.item.campaign_user_status
                             }
                        }).catch(err => {
                            this.loading = false;
                            return row.item.campaign_user_status
                        })
                } else {
                    return row.item.campaign_user_status
                }
            },
        },
        created(){
            vm = this;
            this.loading = true;
            axios.post('/getAllCampaigns').then(response => {
                this.loading = false;
                if(response.data.campaigns instanceof Array) {
                    let all_offers = response.data.campaigns
                        all_offers.forEach(function(item){
                        if(item.gifts[0])
                        item.gift = item.gifts[0].name;
                        if(item.campaign_user_id === response.data.user_id) {
                            vm.my_offers.push(item);
                        } else {
                            vm.offers.push(item);
                        }
                    })
                }
                if(response.data.errors){
                    vm.$swal('Unfortunately:', response.data.errors, 'error')
                }
            }).catch( err => {
                this.loading = false;
                console.log(err.message)
            })
        },
    }
</script>