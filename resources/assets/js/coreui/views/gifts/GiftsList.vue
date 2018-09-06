<template>
    <div class="wrapper">
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
                            <b-button href="#" v-bind:to="'/gifts/create-gift'" variant="primary" class="float-left font500 font12 uppercase">add gift</b-button>
                        </b-form-group>


                        <b-input-group-append class="pull-right typeRenderGifts">
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
                        </b-input-group-append>

                        <b-tabs pills card>
                            <b-tab title="Active" active>
                                <b-form-group>
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-select dark v-model="campaignSelected" :options="campaigns">
                                                <option slot="first" :value="null">All campaigns</option>
                                            </b-form-select>
                                        </b-input-group-prepend>
                                        <b-form-input v-model="filter" placeholder="Type name of gift"/>
                                        <b-input-group-append>
                                            <b-btn :variant="'primary'" :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>

                                <b-table
                                        :id="giftsCards ? 'table_cards' : ''"
                                        :hover="false"
                                        :striped="false"
                                        :bordered="false"
                                        :small="true"
                                        :fixed="false"
                                        responsive="sm"
                                        :items="filtered(gifts, campaignSelected)"
                                        :fields="fields"

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
                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(gifts, campaignSelected)"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPage"
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

    export default {
        name: 'GiftsList',
        data(){
            return {
                header: 'Gifts list',
                
                giftsList: true,
                giftsCards: false,
                campaignSelected: null,

                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                selected: [],
                allSelected: false,
                userIds: [],

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                campaigns: ['Snacks', 'Cheese'],

                gifts: [
                    { id: 1, photo: '../images/6.jpg', name: 'Iphone 8', points: 10000, inStock: 25, campaign: 'Snacks' },
                    { id: 2, photo: '../images/7.jpg', name: 'Iphone 7', points: 20000, inStock: 50, campaign: 'Cheese' },
                ],

                fields: [
                    { key: 'name', sortable: true, 'class': 'name_gift' },
                    { key: 'points', sortable: true, 'class': 'points_gift' },
                    { key: 'inStock', sortable: true, 'class': 'inStock_gift' },
                    { key: 'campaign', sortable: true, 'class': 'campaign_gift' },
                ],
            }
        },
        created(){
            vm = this;
        },
        computed: {
            sortOptions () {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => { return { text: f.label, value: f.key } })
            },
        },
        methods: {
            filterMedia(val){
                val ? vm.giftsList = false : vm.giftsList = true;
                val ? vm.giftsCards = true : vm.giftsCards = false;
                val ? vm.perPage = 9 : vm.perPage = 10;
            },
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            selectAll: function() {
                vm.allSelected = !vm.allSelected;
                vm.userIds = [];

                if (vm.allSelected) {
                    vm.activeTable.forEach(function(item){
                        vm.userIds.push(item.id);
                    })
                }
            },
            select: function() {
                vm.allSelected = false;
            },
            filtered (arrays, campaign) {
                if(campaign === null) {
                    this.getRowCount(this.gifts);
                    return this.gifts
                } else {
                    let i = 0;
                    this.gifts.forEach(function (item, index) {
                        if (item.campaign === campaign) {
                            i++
                        }
                    });

                    this.getRowCount(this.gifts.filter(t => t.campaign === campaign));
                    return this.gifts.filter(t => t.campaign === campaign);
                }
            },
            getRowCount (items, campaign) {
                if(campaign === null) {
                    return items.length
                } else {
                    return items.filter(t => t.campaign === campaign).length
                }
            },
        },
    }
</script>