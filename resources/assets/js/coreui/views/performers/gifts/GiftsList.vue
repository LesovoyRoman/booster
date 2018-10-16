<template>
    <div class="wrapper">
        <div class="animated fadeIn" id="giftsList">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <b-col v-if="loading">
                    <loading v-if="loading" style="position: fixed; left: 50%; margin-left: -20px; top: 50%"></loading>
                </b-col>

                <b-col  v-if="!loading"
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

                                        :current-page="currentPageActive"
                                        :per-page="perPage">
                                    <template slot="HEAD_gift_checkbox" slot-scope="data" >
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                    type="checkbox"
                                                    v-model="allSelected"
                                                    :value="true"
                                                    :id="'gift_checkbox'"
                                                    :name="'gift_checkbox'"
                                                    class="custom-control-input">
                                            <label
                                                    @click="selectAll"
                                                    style="display: block"
                                                    class="custom-control-label"
                                                    :for="'gift_checkbox'"></label>
                                        </div>
                                    </template>
                                    <template slot="gift_checkbox" slot-scope="data">
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                    type="checkbox"
                                                    :value="data.item.id"
                                                    v-model="giftsIds"
                                                    @click="select"
                                                    :id="'gift_checkbox' + data.item.id"
                                                    :name="'gift_checkbox' + data.item.id"
                                                    class="custom-control-input">
                                            <label
                                                    style="display: block"
                                                    class="custom-control-label"
                                                    :for="'gift_checkbox' + data.item.id"></label>
                                        </div>
                                    </template>
                                    <template slot="name" slot-scope="data">
                                        <div class="photo_gift-block">
                                            <!--<i class="fa fa-star star_active star_influencer" v-if="data.item.star"></i>-->
                                            <keep-alive>
                                                <img v-if="data.item.images.length !== 0" :src="storage_path + '/' + data.item.images[0].image_path" alt="photo" class="photo_gift_table">
                                                <img v-if="data.item.images.length === 0" :src="storage_path + '/' + noimage" alt="photo" class="photo_gift_table">
                                            </keep-alive>
                                        </div>
                                        <div class="gift-name-block">
                                          {{ data.item.name }}
                                        </div>
                                    </template>

                                    <template slot="points" slot-scope="data">
                                        {{ data.item.points }} <span class="showsTableCards">points</span>
                                    </template>
                                    <template slot="in_stock" slot-scope="data">
                                        <span class="showsTableCards">In stock:</span> {{ data.item.in_stock }}
                                    </template>
                                    <template slot="campaign" slot-scope="data">
                                        <router-link :id="id = data.item.campaign_id" :data="campaign = data.item.campaign" :to="{ name: 'Campaign', params: { campaign:campaign, id: id } }">{{ data.item.campaign.name }}</router-link>
                                    </template>
                                    <template slot="change" justified="center" slot-scope="row">
                                        <b-button size="sm" :to="{ name: 'UpdateGift', params: { idGift:row.item.id }}" class="custom_btn_change" :variant="'primary'">
                                            <i class="icon-pencil"></i>
                                        </b-button>
                                    </template>
                                    <template slot="delete" justified="center" slot-scope="row">
                                        <b-button size="sm" @click="removeElement(row, row.item.id)" class="custom_btn_change" :variant="'primary'">
                                            <i class="icon-close"></i>
                                        </b-button>
                                    </template>
                                    <template slot="delivery" slot-scope="data">
                                        <div class="clearfix"></div>
                                        <span class="span-row text-left"><span class="showsTableCards">Delivery:</span> {{ data.item.delivery }}</span>
                                    </template>
                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(gifts, campaignSelected)"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPageActive"
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
    import Loading from 'vue-loading-spinner/src/components/Circle8'
    let vm = {};

    export default {
        name: 'GiftsList',
        components: {
            Loading
        },
        data(){
            return {
                header: 'Gifts list',
                loading: false,
                
                giftsList: true,
                giftsCards: false,
                campaignSelected: null,

                currentPageActive: 1,
                currentPageArchive: 1,

                perPage    : 10,
                totalRows  : 0,

                storage_path: '',
                noimage: 'images/noimage.jpg',

                selected: [],
                allSelected: false,
                giftsIds: [],

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                campaigns: ['Snacks', 'Cheese'],

                gifts: [],

                fields: [
                    { key: 'gift_checkbox', 'class': 'table_label_hidden check-box-gifts' },
                    { key: 'name', sortable: true, 'class': 'name_gift' },
                    { key: 'points', sortable: true, 'class': 'points_gift' },
                    { key: 'in_stock', sortable: true, 'class': 'in_stock_gift' },
                    { key: 'campaign', sortable: false, 'class': 'campaign_gift' },
                    { key: 'delivery', sortable: false, 'class': 'table_delivery' },
                    { key: 'change', label: '', 'class': 'table_label_hidden change-gift' },
                    { key: 'delete', label: '', 'class': 'table_label_hidden delete-gift' },
                ],
            }
        },
        created(){
            this.storage_path = this.$root.storage_path;
            vm = this;
            this.loading = true;
            axios.post('/getAllGifts').then(response => {
                this.loading = false;
                //console.log(response)
                if(response.data.gifts instanceof Array) {
                    this.gifts = response.data.gifts
                }
            }).catch( err => {
                this.loading = false;
                console.log(err.message)
            })
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
                this.currentPageActive = 1;
                this.currentPageArchive = 1;
            },
            selectAll: function() {
                vm.allSelected = !vm.allSelected;
                vm.giftsIds = [];


                if (vm.allSelected) {
                    vm.gifts.forEach(function(item){
                        vm.giftsIds.push(item.id);
                    })
                }
            },
            removeElement: function (item, id) {
                if(confirm("Are you sure?")) {
                    vm.loading = true;
                    axios.post('/deleteGift', {
                        id: id,
                    }).then(response => {
                        vm.loading = false;
                        if(response.status === 200) {
                            this.gifts.splice(item.index, 1);
                            vm.$notify({
                                type:  'info',
                                title: response.data.response,
                            })
                        } else {
                            vm.$swal({
                                type: 'error',
                                title: response.data.errors,
                            });
                        }
                    }).catch(err => {
                        vm.loading = false;
                        console.log(err);
                    });
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
                        if (item.campaign_name === campaign) {
                            i++
                        }
                    });

                    this.getRowCount(this.gifts.filter(t => t.campaign_name === campaign));
                    return this.gifts.filter(t => t.campaign_name === campaign);
                }
            },
            getRowCount (items, campaign) {
                if(campaign === null) {
                    return items.length
                } else {
                    return items.filter(t => t.campaign_name === campaign).length
                }
            },
        },
    }
</script>