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
                                        <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'Campaign', params: { campaign:campaign, id: id } }">{{ data.item.campaign_name }}</router-link>
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
                                        <span class="showsTableCards">Main gift:</span> <a href="">{{ data.item.prize }}</a>
                                    </template>
                                    <template slot="period" slot-scope="data">
                                        <span class="showsTableCards">Period:</span><span class="font500-cards"> {{ data.item.period }}</span>
                                    </template>
                                    <template slot="status" slot-scope="row">
                                        <div v-if="row.item.status === 'waiting'">
                                            <b-button class="btn btn-secondary" @click="acceptElement(row)">accept</b-button>

                                            <b-button size="sm" @click="removeElement(row)" class="custom_btn_change" :variant="'primary'">
                                                <i class="icon-close"></i>
                                            </b-button>
                                        </div>
                                        <div v-if="row.item.status === 'participate'">
                                            <span class=""><i class="icon-check"></i>
                                                Participating
                                            </span>
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
        name: 'Invites',
        data(){
            return {
                header: 'Invites',

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                invites: [
                    { id: 1, campaign_name: 'Cheese', price: '250 Rub', conditions: '1 pack - 1 point', prize: 'Smartphone Samsung Note2', period: '15.01 - 30.01', status: 'waiting' },
                    { id: 2, campaign_name: 'Snacks', price: '500 Rub', conditions: '3 pack - 5 points', prize: 'Smartphone Samsung Note2', period: '12.01 - 28.01', status: 'participate' },
                    { id: 3, campaign_name: 'Snacks', price: '1000 Rub', conditions: '5 pack - 10 points', prize: 'Smartphone Samsung Note2', period: '05.01 - 28.01', status: 'waiting' },
                ],

                fields: [
                    { key: 'campaign_name', sortable: true, 'class': 'table_campaign_name' },
                    { key: 'price', sortable: true, 'class': 'table_price' },
                    { key: 'conditions', sortable: false, 'class': 'table_conditions' },
                    { key: 'prize', sortable: false, 'class': 'table_prize' },
                    { key: 'period', sortable: true, 'class': 'table_period'  },
                    { key: 'status', sortable: true, 'class': 'table_label_hidden table_status' },
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
                this.invites.splice(item.index, 1);
            },
            acceptElement: function (item) {
                this.invites[item.index].status = 'participate'
            }
        },
        created(){
            vm = this;
        }
    }
</script>