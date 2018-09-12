<template>
    <div class="wrapper" id="myCampaigns">
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
                            <b-input-group>
                                <b-form-input v-model="filter" placeholder="Search via campaigns"/>
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
                                :items="campaigns"
                                :fields="fields"

                                :filter="filter"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                @filtered="onFiltered"
                                class="verticalTop"

                                :current-page="currentPage"
                                :per-page="perPage">
                            <template slot="campaign_name" slot-scope="data">
                                <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'Campaign', params: { campaign:campaign, id: id } }">{{ data.item.campaign_name }}</router-link>
                            </template>
                            <template slot="links" slot-scope="row">
                                <div v-for="(linkItem, index) in row.item.links">
                                    <b-form-group class="groupLinksCampaigns">
                                        <div v-for="(objItem, key) in linkItem" :key="key" class="inlineBlock" style="max-width: 48%">
                                            <b-form-input v-if="key === 'path'" v-model="row.item.links[index].path" placeholder="Link path"/>
                                            <b-btn :variant="'primary'" v-if="key === 'path'" @click="index === 0 ? addLink(row.item.links) : removeLink(row.index, index)" class="uppercase float-right font500"><span v-if="index === 0">+</span><span v-if="index !== 0">-</span></b-btn>
                                            <b-form-input v-if="key === 'gift'" v-model="row.item.links[index].gift" placeholder="Gift"/>
                                        </div>
                                    </b-form-group>
                                </div>
                            </template>
                            <template
                                    slot="stop" slot-scope="data">
                                <b-button variant="primary" class="font500 uppercase">Stop</b-button>
                            </template>
                            <template slot="change" justified="center" slot-scope="row">
                                <b-button size="sm" class="custom_btn_change" :variant="'primary'">
                                    <i class="icon-pencil"></i>
                                </b-button>
                            </template>
                            <template slot="delete" justified="center" slot-scope="row">
                                <b-button size="sm" @click="removeElement(row)" class="custom_btn_change" :variant="'primary'">
                                    <i class="icon-close"></i>
                                </b-button>
                            </template>
                        </b-table>

                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};

    export default {
        name: 'CampaignsInfluencer',
        data(){
            return {
                header: 'My campaigns',

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                campaigns: [
                    { id: 1, campaign_name: 'Snacks', links: [{path: 'https://linkFirst.com', gift: 'First gift'}, {path: 'https://linkSecond.com', gift: 'Second gift'}], },
                    { id: 2, campaign_name: 'Cheese', links: [{path: 'https://linkCheeseFirst.com', gift: 'First cheese gift'},], },
                    { id: 3, campaign_name: 'Cheese', links: [{path: 'https://linkCheeseNew.com', gift: 'Iphone'}, {path: 'https://linkCheesesss.com', gift: 'Samsung Note2'}], }
                ],

                fields: [
                    { key: 'campaign_name', sortable: true, 'class': 'table_campaign_name' },
                    { key: 'links', sortable: false, 'class': 'table_links' },
                    { key: 'stop', label: '', 'class': 'table_label_hidden'},
                    { key: 'change', label: '', 'class': 'table_label_hidden' },
                    { key: 'delete', label: '', 'class': 'table_label_hidden' }
                ]
            }
        },
        created() {
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
            addLink(obj){
                obj.push({path: '', gift: ''})
            },
            removeLink(index, indexLink){
                if(confirm("Are you sure?")) {
                    vm.campaigns[index].links.splice(indexLink, 1)
                }
            },
            removeElement: function (item) {
                if(confirm("Are you sure?")) {
                    this.campaigns.splice(item.index, 1);
                }
            },
        }
    }
</script>