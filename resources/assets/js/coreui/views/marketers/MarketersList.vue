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
                            <b-button href="#" variant="primary" class="float-left font500 font12 uppercase">add marketer</b-button>
                        </b-form-group>

                        <b-form-group>
                            <b-input-group>
                                <b-form-input v-model="filter" placeholder="Type name campaign or influencer"/>
                            </b-input-group>
                        </b-form-group>


                        <b-table
                                :hover="false"
                                :striped="false"
                                :bordered="false"
                                :small="true"
                                :fixed="false"
                                responsive="sm"
                                :items="marketers"
                                :fields="fields"

                                :filter="filter"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                @filtered="onFiltered"

                                :current-page="currentPage"
                                :per-page="perPage">
                            <template slot="HEAD_marketer_checkbox" slot-scope="data" >
                                <div class="custom-control custom-checkbox">
                                    <input
                                            type="checkbox"
                                            v-model="allSelected"
                                            :value="true"
                                            :id="'marketer_checkbox'"
                                            :name="'marketer_checkbox'"
                                            class="custom-control-input">
                                    <label
                                            @click="selectAll"
                                            style="display: block"
                                            class="custom-control-label"
                                            :for="'marketer_checkbox'"></label>
                                </div>
                            </template>
                            <template slot="marketer_checkbox" slot-scope="data">
                                <div class="custom-control custom-checkbox">
                                    <input
                                            type="checkbox"
                                            :value="data.item.id"
                                            v-model="marketersIds"
                                            @click="select"
                                            :id="'marketer_checkbox' + data.item.id"
                                            :name="'marketer_checkbox' + data.item.id"
                                            class="custom-control-input">
                                    <label
                                            style="display: block"
                                            class="custom-control-label"
                                            :for="'marketer_checkbox' + data.item.id"></label>
                                </div>
                            </template>
                            <template
                                    slot="name"
                                    slot-scope="data">
                                <router-link :id="id = data.item.id" :data="influencer = data.item" :to="{ name: 'InfluencerBonuses', params: { influencer: influencer, id: id, campaign_name: data.item.campaign } }">{{ data.item.name }}</router-link>
                            </template>
                            <template
                                slot="new_pass" slot-scope="data">
                                <b-button href="#" :variant="'primary'" class="font500">Send new password</b-button>
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

                        <nav>
                            <b-pagination
                                    :total-rows="getRowCount(marketers)"
                                    :per-page="perPage"
                                    align="center"
                                    v-model="currentPage"
                                    prev-text="Prev"
                                    next-text="Next"
                                    hide-goto-end-buttons/>
                        </nav>


                    </b-card>

                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};

    export default {
        name: 'Marketers',
        data() {
            return {
                header: 'Marketers',

                marketers: [
                    { id: 1, name: 'Joseph Stalin', email: 'josephstalin@rasstrelyat.com', campaign: 'Second world war' },
                    { id: 2, name: 'Adolf Hitler', email: 'adolf@sexymustache.com', campaign: 'Second world war' },

                ],

                fields: [
                    { key: 'marketer_checkbox', 'class': 'table_label_hidden' },
                    { key: 'id', label: '№' },
                    { key: 'name', label: 'Name', sortable: true },
                    { key: 'email', sortable: true, label: 'Email'},
                    { key: 'campaign', sortable: true, label: 'Campaign' },
                    { key: 'new_pass', label: '', 'class': 'table_label_hidden'},
                    { key: 'change', label: '', 'class': 'table_label_hidden' },
                    { key: 'delete', label: '', 'class': 'table_label_hidden' }
                ],
                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                selected: [],
                allSelected: false,
                marketersIds: [],

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
            }
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
            getBadge (status) {
                return status === 5 ? 'success'
                    : status === 4 ? 'warning'
                        : status === 3 ? 'danger' : 'primary'
            },
            getRowCount (items) {
                return items.length
            },
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            selectAll: function() {
                vm.allSelected = !vm.allSelected;
                vm.marketersIds = [];

                if (vm.allSelected) {
                    vm.marketers.forEach(function(item){
                        vm.marketersIds.push(item.id);
                    })
                }
            },
            removeElement: function (index) {
                this.marketers.splice(index, 1);
            },
            select: function() {
                vm.allSelected = false;
            }
        },
        created() {
            vm = this;
        }
    }
</script>