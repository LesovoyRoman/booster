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

                        <!--<b-input-group-append class="pull-right typeRenderGifts">
                            <div class="">
                                <input
                                        type="checkbox"
                                        id="customCheckboxInfluencersList"
                                        name="customCheckboxCountry"
                                        class="custom-control-input"
                                        v-model="giftsList"
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
                                        v-model="giftsCards">
                                <label
                                        style="display: block"
                                        class="control-type-grid control-type-grid-cards"
                                        for="customCheckboxInfluencersCards"></label>
                            </div>
                        </b-input-group-append>-->

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

                                <b-table
                                        :hover="false"
                                        :striped="false"
                                        :bordered="false"
                                        :small="true"
                                        :fixed="false"
                                        responsive="sm"
                                        :items="offers"
                                        :fields="fields"

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
                                    <template slot="status" slot-scope="data">
                                        <div v-if="data.item.status === 'considering'">
                                            <span class="statusOfferConsider">
                                                Considering
                                            </span>
                                        </div>
                                        <div v-if="data.item.status === 'participate'">
                                            <span class=""><i class="icon-check"></i>
                                                Accepted
                                            </span>
                                        </div>
                                        <div v-if="data.item.status === 'choose'">
                                            <b-button class="btn btn-secondary">participate</b-button>
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
                    { key: 'campaign_name', sortable: true, },
                    { key: 'price', sortable: true, },
                    { key: 'conditions', sortable: false, 'class': 'table_points' },
                    { key: 'prize', sortable: false, },
                    { key: 'period', sortable: true, },
                    { key: 'status', sortable: true, },
                ]
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
        },
        created(){
            vm = this;
        }
    }
</script>