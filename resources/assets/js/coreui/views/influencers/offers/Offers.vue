<template>
    <div class="wrapper" id="offers">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

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
                                        <b-form-input v-model="filter" placeholder="Type influencer or campaign"/>
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

                                        :current-page="currentPage"
                                        :per-page="perPage">
                                    <template
                                            slot="campaign_name"
                                            slot-scope="data">
                                        <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'ProfileCampaign', params: { campaign:campaign, id: id, tabGifts: false  } }">{{ data.item.campaign_name }}</router-link>
                                    </template>
                                    <template slot="HEAD_status" slot-scope="data">

                                    </template>
                                    <template slot="price" slot-scope="data">
                                        <span class="showsTableCards">Price:</span> {{ data.item.price }}
                                    </template>
                                    <template slot="conditions" slot-scope="data">
                                        <span class="showsTableCards">Conditions:</span> {{ data.item.conditions }}
                                    </template>
                                    <template slot="prize" slot-scope="data">
                                        <span class="showsTableCards">Main gift:</span> <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'ProfileCampaign', params: { campaign:campaign, id: id, tabGifts: true } }">{{ data.item.prize }}</router-link>
                                    </template>
                                    <template slot="period" slot-scope="data">
                                        <span class="showsTableCards">Period:</span><span class="font500-cards"> {{ data.item.period }}</span>
                                    </template>
                                    <template slot="status" slot-scope="row">
                                        <div v-if="row.item.status === 'considering'">
                                            <span class="statusOfferConsider">
                                                Considering
                                            </span>
                                        </div>
                                        <div v-if="row.item.status === 'participate'">
                                            <span class="statusOfferParticipating"><i class="icon-check"></i>
                                                Participating
                                            </span>
                                        </div>
                                        <div v-if="row.item.status === 'choose'">
                                            <b-row v-if="offersCards === true">
                                                <b-col>
                                                    <b-button variant="primary" class="font500 uppercase" @click="acceptElement(row)">participate</b-button>
                                                </b-col>
                                                <b-col>
                                                    <b-button size="sm" @click="removeElement(row)" class="custom_btn_change" :variant="'primary'">
                                                        <i class="icon-close"></i>
                                                    </b-button>
                                                </b-col>
                                            </b-row>
                                            <div v-if="offersCards === false">
                                                <b-button variant="primary" class="font500 uppercase" @click="acceptElement(row)">participate</b-button>
                                                <b-button size="sm" @click="removeElement(row)" class="custom_btn_change" :variant="'primary'">
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
                                            v-model="currentPage"
                                            prev-text="Prev"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>

                            </b-tab>
                            <b-tab title="My">

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

    export default {
        name: 'Offers',
        data(){
            return {
                header: 'Offers',

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                offers: [
                    { id: 1, campaign_name: 'Cheese', price: '250 Rub', conditions: '1 pack - 1 point', prize: 'Smartphone Samsung Note2', period: '15.01 - 30.01', status: 'considering' },
                    { id: 2, campaign_name: 'Snacks', price: '500 Rub', conditions: '3 pack - 5 points', prize: 'Smartphone Samsung Note2', period: '12.01 - 28.01', status: 'participate' },
                    { id: 3, campaign_name: 'Snacks', price: '1000 Rub', conditions: '5 pack - 10 points', prize: 'Smartphone Samsung Note2', period: '05.01 - 28.01', status: 'choose' },
                ],

                fields: [
                    { key: 'campaign_name', sortable: true, 'class': 'table_campaign_name' },
                    { key: 'price', sortable: true, 'class': 'table_price' },
                    { key: 'conditions', sortable: false, 'class': 'table_conditions' },
                    { key: 'prize', sortable: false, 'class': 'table_prize' },
                    { key: 'period', sortable: true, 'class': 'table_period'  },
                    { key: 'status', sortable: true, 'class': 'table_label_hidden table_status' },
                ],

                offersList: true,
                offersCards: false,
            }
        },
        methods: {
            onFiltered (filteredItems) {
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            getRowCount (items) {
                return items.length
            },
            filterMedia(val){
                val ? vm.offersList = false : vm.offersList = true;
                val ? vm.offersCards = true : vm.offersCards = false;
                val ? vm.perPage = 9 : vm.perPage = 10;
            },
            removeElement: function (item) {
                if (confirm("Are you sure?")) {
                    this.offers.splice(item.index, 1);
                }
            },
            acceptElement: async function(item) {
                 return this.setParticipate(item)
                    .then(res => vm.$router.push('/influencer-campaigns'))
                    .catch(err => console.log(err))
            },
            setParticipate: function(item){
                return new Promise(function(resolve, reject){
                    if (item){
                        resolve(vm.offers[item.index].status = 'participate')
                    } else {
                        reject(new Error('No item'))
                    }
                })
            }
            // @todo another variant (can be useful)
            /*acceptElement: async function(item) {
                try {
                    let status = await this.setParticipate(item)
                    vm.$router.push('/influencer-campaigns')
                }
                catch(err) {
                    console.log(err)
                }
            },
            setParticipate(item) {
                this.offers[item.index].status = 'participate';
                return true
            }*/

        },
        created(){
            vm = this;
        }
    }
</script>