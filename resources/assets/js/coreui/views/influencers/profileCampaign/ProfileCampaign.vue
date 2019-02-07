<template>
    <div :campaign="computedProfileCampaign" class="wrapper">
        <div class="animated fadeIn" v-if="campaign" id="profileCampaign">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }} {{ campaign.campaign_name }}</h2>
                </b-col>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>

                        <b-button variant="secondary" class="font500 uppercase float-right" v-bind:to="'/influencer-campaigns'" style="margin: 17px 10px">participate campaign</b-button>
                        <b-tabs pills card>
                            <b-tab title="Info" active>
                                <p class="card-text header_card_simple">Common information</p>

                                <div class="group-info-custom">
                                    <p class="paragraph_simple">Campaign ends</p>

                                    <span class="span-row">21.09.2019</span>
                                </div>

                                <b-row>
                                    <b-col md="3" lg="3">
                                        <p class="paragraph_simple">Campaign countries</p>
                                        <span class="span-row">Ukraine</span>
                                        <span class="span-row">Russia</span>
                                        <span class="span-row">USA</span>
                                    </b-col>
                                    <b-col md="3" lg="3">
                                        <p class="paragraph_simple">Campaign cities</p>
                                        <span class="span-row">All</span>
                                    </b-col>
                                </b-row>

                                <div class="divider_custom"></div>

                                <p class="card-text header_card_simple">Product for campaign</p>

                                <b-row>
                                    <b-col>
                                        <p class="paragraph_simple">{{ campaign.campaign_name }}</p>

                                        <span class="span-row"><a href="#">https://test.com</a></span>

                                        <div class="holder-img-profile-campaign">
                                            <img src="~static/img/iphone.png" alt="">
                                        </div>

                                        <div class="group-info-custom">
                                            <span class="span-row">Middle price 250 Rub</span>

                                            <span class="span-row">1 point for 1 product</span>
                                        </div>
                                    </b-col>
                                    <b-col>

                                        <iframe width="560" height="315" src="https://www.youtube.com/embed/ecyF6KStpB8" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

                                    </b-col>
                                </b-row>



                                <div class="divider_custom"></div>

                                <p class="card-text header_card_simple">Additional information</p>

                                <div class="group-info-custom">
                                    <p class="paragraph_simple">Checking type</p>

                                    <span class="span-row">Input serial number</span>
                                </div>

                                <div class="group-info-custom">
                                    <p class="paragraph_simple">Conditions</p>

                                    <span class="span-row">1 point for 1 product</span>
                                </div>

                                <div class="group-info-custom">
                                    <p class="paragraph_simple">Instructions</p>

                                    <span class="span-row">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At consectetur culpa cumque ducimus earum, explicabo facilis fugiat illum iste itaque neque provident quas, qui recusandae repellat repellendus, sunt suscipit tempora!</span>
                                </div>

                            </b-tab>



                            <b-tab title="Gifts" :active="tabGifts === true ? 'active' : false">

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
                                            <i class="fa fa-star star_active star_influencer" v-if="data.item.star"></i>
                                            <keep-alive><img :src="data.item.photo" alt="photo_item" class="photo_gift_table"></keep-alive>
                                        </div>
                                        <div class="gift-name-block">
                                            {{ data.item.name }}
                                        </div>
                                    </template>
                                    <template slot="points" slot-scope="data">
                                        <span class="span-row font500 text-center">Price: {{ data.item.points }} points</span>
                                    </template>
                                </b-table>

                            </b-tab>


                            <b-tab title="Performer">
                                <b-row>
                                    <b-col md="6" lg="3">
                                        <div class="block_logo_user">
                                            <img src="~static/img/powerful2.png" alt="" id="logo">
                                        </div>
                                    </b-col>

                                    <b-col md="6" lg="3">
                                        <p class="card-text header_card_simple">Common information</p>

                                        <div class="group-info-custom">
                                            <span class="span-row">Tarantino films</span>
                                            <span class="span-row">OOO Tarantino</span>
                                            <span class="span-row">ID 3284783274</span>
                                            <span class="span-row">st. Pushkina h.Kolotushkina 1, Moscow, Russia</span>
                                        </div>

                                        <b-row>
                                            <b-col md="3" lg="3">

                                            </b-col>
                                            <b-col md="3" lg="3">

                                            </b-col>
                                        </b-row>
                                    </b-col>
                                </b-row>
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
        name: 'ProfileCampaign',
        props: ['campaign', 'tabGifts'],
        data(){
            return {
                header: 'Profile of Campaign',

                currentPage: 1,
                perPage    : 9,
                totalRows  : 0,

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                gifts: [
                    { id: 1, photo: '../images/iphone.png', name: 'Iphone 8', points: 10000, },
                    { id: 2, photo: '../images/iphone.png', name: 'Iphone 7', points: 20000, },
                    { id: 3, photo: '../images/iphone.png', name: 'Iphone 8', points: 40000, },
                    { id: 4, photo: '../images/iphone.png', name: 'Iphone 7', points: 50000, },
                    { id: 5, photo: '../images/iphone.png', name: 'Iphone 8', points: 345000, },
                    { id: 6, photo: '../images/iphone.png', name: 'Iphone 7', star:true, points: 63000, },
                    { id: 7, photo: '../images/iphone.png', name: 'Iphone 8', points: 70000, },
                    { id: 8, photo: '../images/iphone.png', name: 'Iphone 7', points: 93000, },
                    { id: 9, photo: '../images/iphone.png', name: 'Iphone 8', points: 72000, },
                    { id: 10, photo: '../images/iphone.png', name: 'Iphone 7', points: 95000, },
                    { id: 11, photo: '../images/iphone.png', name: 'Iphone 8', points: 82000, },
                    { id: 12, photo: '../images/iphone.png', name: 'Iphone 7', points: 4000, },
                ],

                fields: [
                    { key: 'name', sortable: true, 'class': 'name_gift' },
                    { key: 'points', sortable: true, 'class': '' },
                ],
            }
        },
        created(){
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
        computed: {
            computedProfileCampaign: function () {
                if (typeof this.campaign === 'undefined') {
                    vm.$router.go(-1)
                }
            },
        }
    }
</script>