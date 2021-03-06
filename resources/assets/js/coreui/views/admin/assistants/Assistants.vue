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
                            <b-input-group>
                                <b-form-input v-model="filter" placeholder="Type name campaign or influencer"/>
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
                                :items="assistants"
                                :fields="fields"

                                :filter="filter"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                @filtered="onFiltered"

                                :current-page="currentPage"
                                :per-page="perPage">
                            <template slot="HEAD_assistant_checkbox" slot-scope="data" >
                                <div class="custom-control custom-checkbox">
                                    <input
                                            type="checkbox"
                                            v-model="allSelected"
                                            :value="true"
                                            :id="'assistant_checkbox'"
                                            :name="'assistant_checkbox'"
                                            class="custom-control-input">
                                    <label
                                            @click="selectAll"
                                            style="display: block"
                                            class="custom-control-label"
                                            :for="'assistant_checkbox'"></label>
                                </div>
                            </template>
                            <template slot="assistant_checkbox" slot-scope="data">
                                <div class="custom-control custom-checkbox">
                                    <input
                                            type="checkbox"
                                            :value="data.item.id"
                                            v-model="assistantsIds"
                                            @click="select"
                                            :id="'assistant_checkbox' + data.item.id"
                                            :name="'assistant_checkbox' + data.item.id"
                                            class="custom-control-input">
                                    <label
                                            style="display: block"
                                            class="custom-control-label"
                                            :for="'assistant_checkbox' + data.item.id"></label>
                                </div>
                            </template>
                            <template slot="performers" slot-scope="row">
                                <span v-for="(performer, index) in row.item.performers">
                                    {{ performer }}<span v-if="index !== row.item.performers.length - 1">, </span>
                                </span>
                            </template>
                            <template slot="campaigns" slot-scope="row">
                                <router-link v-for="(campaign, index) in row.item.campaigns" :id="id = row.item.id" :key="index" :data="campaign_name = campaign" :to="{ name: 'Campaign', params: { campaign:campaign, id: index } }">{{ campaign }}<span v-if="index !== row.item.campaigns.length - 1">, </span></router-link>
                            </template>
                            <template
                                    slot="new_pass" slot-scope="data">
                                <b-button href="#" :variant="'primary'" class="">Send new password</b-button>
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
                                    :total-rows="getRowCount(assistants)"
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
        name: 'AssistantsAdmin',
        data() {
            return {
                header: 'Assistants',

                assistants: [
                    { id: 1, name: 'Joseph Stalin', email: 'josephstalin@rasstrelyat.com', performers: ['Grigoriy Alexandrovich', 'Somebody Else'],  campaigns: ['Pineapple', 'Grape', 'Smth'] },
                    { id: 2, name: 'Adolf Hitler', email: 'adolf@sexymustache.com', performers: ['Grigoriy Alexandrovich',], campaigns: ['Snacks', 'Cheese'] },

                ],

                fields: [
                    { key: 'assistant_checkbox', 'class': 'table_label_hidden' },
                    { key: 'id', label: '№' },
                    { key: 'name', label: 'Name', sortable: true },
                    { key: 'email', sortable: true, label: 'Email'},
                    { key: 'performers', sortable: true, 'class': 'table_name_performer' },
                    { key: 'campaigns', sortable: false, label: 'Campaigns' },
                    { key: 'new_pass', label: '', 'class': 'table_label_hidden'},
                    { key: 'change', label: '', 'class': 'table_label_hidden' },
                    { key: 'delete', label: '', 'class': 'table_label_hidden' }
                ],
                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                selected: [],
                allSelected: false,
                assistantsIds: [],

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
                vm.assistantsIds = [];

                if (vm.allSelected) {
                    vm.assistants.forEach(function(item){
                        vm.assistantsIds.push(item.id);
                    })
                }
            },
            removeElement: async function (item) {
                let check = await vm.$root.check();
                if (check === true) {
                    this.assistants.splice(item.index, 1);
                }
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