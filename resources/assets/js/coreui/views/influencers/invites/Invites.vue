<template>
    <div class="wrapper" id="invites">
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

                        <b-input-group-append class="pull-right typeRenderGifts">
                            <div class="">
                                <input
                                        type="checkbox"
                                        id="customCheckboxInfluencersList"
                                        name="customCheckboxCountry"
                                        class="custom-control-input"
                                        v-model="invitesList"
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
                                        v-model="invitesCards">
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

                                <b-table
                                        :id="invitesCards ? 'table_cards' : ''"
                                        :hover="false"
                                        :striped="false"
                                        :bordered="false"
                                        :small="true"
                                        :fixed="false"
                                        responsive="sm"
                                        :items="invites"
                                        :fields="fields"
                                        class="table_invites"

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
                                        <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'ProfileCampaign', params: { campaign:campaign, id: id, tabGifts: false  } }">{{ data.item.name }}</router-link>
                                    </template>
                                    <template slot="HEAD_status" slot-scope="data">

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
                                    <template slot="invite_influencer_status" slot-scope="row">
                                        <div v-if="row.item.pivot.status === 'invited_accepted'">
                                            <span class="statusOfferConsider"><i class="icon-check"></i>
                                                Joined
                                            </span>
                                        </div>
                                        <div v-if="row.item.pivot.status === 'invited_declined'">
                                            <span class="statusOfferParticipating">
                                                Declined
                                            </span>
                                        </div>
                                        <div v-if="row.item.pivot.status === 'invited'">
                                            <div v-if="invitesCards === true" style="margin-top: 15px">
                                                <b-row>
                                                    <b-col md="8">
                                                        <b-button variant="primary" class="font500 uppercase" @click="changeStatusInvite(row, '/acceptInvite').then(function(response){ row.item.pivot.status = response})">join</b-button>
                                                    </b-col>
                                                    <b-col md="4">
                                                        <b-button size="sm" @click="changeStatusInvite(row, '/declineInvite').then(function(response){ row.item.pivot.status = response });" class="custom_btn_change" :variant="'primary'">
                                                            <i class="icon-close"></i>
                                                        </b-button>
                                                    </b-col>
                                                </b-row>
                                            </div>
                                            <div v-if="invitesCards === false">
                                                <b-button variant="primary" class="font500 uppercase" @click="changeStatusInvite(row, '/acceptInvite').then(function(response){ row.item.pivot.status = response})">join</b-button>
                                                <b-button size="sm" @click="changeStatusInvite(row, '/declineInvite').then(function(response){ row.item.pivot.status = response });" class="custom_btn_change" :variant="'primary'">
                                                    <i class="icon-close"></i>
                                                </b-button>
                                            </div>
                                        </div>
                                    </template>
                                </b-table>

                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(invites)"
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
    import Loading from 'vue-loading-spinner/src/components/Circle10'
    let vm = {};

    export default {
        name: 'Invites',
        components: {
            Loading
        },
        data(){
            return {
                header: 'Invites',
                loading: false,

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                invites: [],

                fields: [
                    { key: 'campaign_name', sortable: true, 'class': 'table_campaign_name' },
                    { key: 'product_price', sortable: true, 'class': 'table_product_price' },
                    { key: 'conditions', sortable: false, 'class': 'table_conditions' },
                    { key: 'gift', label: 'Main gift', sortable: false, 'class': 'table_prize' },
                    { key: 'end_campaign', sortable: true, 'class': 'table_end_campaign'  },
                    { key: 'invite_influencer_status', sortable: true, 'class': 'table_label_hidden table_status_user' },
                ],

                invitesList: true,
                invitesCards: false,
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
                val ? vm.invitesList = false : vm.invitesList = true;
                val ? vm.invitesCards = true : vm.invitesCards = false;
                val ? vm.perPage = 9 : vm.perPage = 10;
            },
            removeElement: function (item) {
                if(confirm("Are you sure?")) {
                    this.invites.splice(item.index, 1);
                }
            },
            changeStatusInvite(row, url) {
                if (confirm("Are you sure?")) {
                    this.loading = true;
                    let campaign_id = row.item.campaign_id;
                    return axios.post(url, {campaign_id: campaign_id})
                        .then(response => {
                            this.loading = false;
                            if(response.data.status_invite){
                                vm.$notify({
                                    type:  response.data.response,
                                    title: 'Invite ' + response.data.status_invite + '!',
                                })
                                return response.data.status_invite
                            }
                            if(response.data.error){
                                vm.$notify({
                                    type:  response.data.response,
                                    title: 'Error',
                                    text: response.data.error,
                                })
                                return row.item.pivot.status
                            }
                        }).catch(err => {
                            this.loading = false;

                        })
                } else {
                    return row.item.pivot.status
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
                        resolve(vm.invites[item.index].status = 'participate')
                    } else {
                        reject(new Error('No item'))
                    }
                })
            }
        },
        created(){
            this.storage_path = this.$root.storage_path;
            vm = this;
            this.loading = true;
            axios.post('/influencerInvites').then(response => {
                this.loading = false;
                console.log(response.data.campaigns)
                if (response.data.campaigns instanceof Array) {
                    this.invites = response.data.campaigns
                    this.invites.forEach(function(item){
                        if(item.gifts[0]) {
                            item.gift = item.gifts[0].name;
                            item.gift_id = item.gifts[0].id;
                        }
                    })
                }
                if(response.data.errors){
                    vm.$swal( 'Unfortunately:', response.data.errors, 'error')
                }
            }).catch( err => {
                this.loading = false;
                console.log(err.message)
            })
        }
    }
</script>