<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>

                    <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>

                    <b-card>
                        <b-tabs pills card>
                            <b-tab title="Active" active>

                                <b-form-group>
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-select dark v-model="sortBy" :options="sortOptions">
                                                <option slot="first" :value="null">Filter</option>
                                            </b-form-select>
                                            <b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
                                                <option :value="false">Low</option>
                                                <option :value="true">High</option>
                                            </b-form-select>
                                        </b-input-group-prepend>
                                        <b-form-input v-model="filter" placeholder="Type name company or influencer"/>
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
                                        :items="activeTable"
                                        :fields="fields"

                                        :filter="filter"
                                        :sort-by.sync="sortBy"
                                        :sort-desc.sync="sortDesc"
                                        :sort-direction="sortDirection"
                                        @filtered="onFiltered"

                                        :current-page="currentPageActive"
                                        :per-page="perPage">
                                    <template slot="HEAD_campaing_checkbox" slot-scope="data" >
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                    type="checkbox"
                                                    v-model="allSelected"
                                                    :value="true"
                                                    :id="'campaign_checkbox'"
                                                    :name="'campaign_checkbox'"
                                                    class="custom-control-input">
                                           <label
                                                   @click="selectAll"
                                                    style="display: block"
                                                    class="custom-control-label"
                                                    :for="'campaign_checkbox'"></label>
                                        </div>
                                    </template>
                                    <template slot="campaing_checkbox" slot-scope="data">
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                    type="checkbox"
                                                    :value="data.item.id"
                                                    v-model="userIds"
                                                    @click="select"
                                                    :id="'campaign_checkbox' + data.item.id"
                                                    :name="'campaign_checkbox' + data.item.id"
                                                    class="custom-control-input">
                                            <label
                                                    style="display: block"
                                                    class="custom-control-label"
                                                    :for="'campaign_checkbox' + data.item.id"></label>
                                        </div>
                                    </template>
                                    <template
                                            slot="campaign_name"
                                            slot-scope="data">
                                        <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'Campaign', params: { campaign:campaign, id: id } }">{{ data.item.campaign_name }}</router-link>
                                    </template>
                                    <template slot="end_campaign" slot-scope="data">
                                        <div v-if="data.item.end_campaign !== null && data.item.end_campaign !== '2000-01-01 00:00:00'">
                                            {{ data.item.end_campaign }}
                                        </div>
                                        <div v-else>
                                            {{ data.item.end_points }} points
                                        </div>
                                    </template>
                                    <template
                                            slot="satisfied"
                                            slot-scope="data" justified="center">
                                        <span :variant="getBadge(data.item.satisfied)">
                                            <i v-for="k in 5" v-if="data.item.satisfied >= 75" class="star_active fa fa-star"></i>
                                            <i v-for="k in 4" v-if="data.item.satisfied > 60 && data.item.satisfied < 75" class="star_active fa fa-star"></i>
                                            <i v-for="k in 3" v-if="data.item.satisfied <= 60" class="star_active fa fa-star"></i>
                                            <i v-for="k in 1" v-if="data.item.satisfied > 60 && data.item.satisfied < 75" class="fa fa-star"></i>
                                            <i v-for="k in 2" v-if="data.item.satisfied <= 60" class="fa fa-star"></i>
                                        </span>
                                        <span v-if="data.item.satisfied"> {{ data.item.satisfied }}%</span>
                                    </template>
                                    <template slot="status" slot-scope="row">
                                        <b-button size="sm" v-if="row.item.status !== 'created'" @click="changeStatusCampaign(row.item.id, row.item.status).then(function(response){ row.item.status = response; }).catch(function(err){})" class="custom_btn_change" style="margin-right: 15px; margin-left: 0;" :variant="'primary'">
                                            <i :class="row.item.status === 'activated' ? 'fa fa-stop-circle' : 'fa fa-play-circle'"></i>
                                        </b-button>

                                        <span v-if="row.item.status === 'created'">
                                            <router-link v-bind:to="'/gifts/create-gift'">Needed to create gift</router-link>
                                        </span>
                                    </template>
                                    <template slot="change" justified="center" slot-scope="row">
                                        <b-button size="sm" :to="{ name: 'UpdateCampaign', params: { idCampaign:row.item.id }}" class="custom_btn_change" :variant="'primary'">
                                            <i class="icon-pencil"></i>
                                        </b-button>
                                    </template>
                                </b-table>
                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(activeTable)"
                                            :per-page="perPage"
                                            v-model="currentPageActive"
                                            prev-text="Prev"
                                            align="center"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>

                            </b-tab>

                            <b-tab title="Archive">
                                <!-- @todo add here datas, find out how to change page of pagination! -->
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
        name: 'MyCampaigns',
        components: {
            Loading
        },
        created(){
            vm = this;
            this.loading = true;
            axios.post('/getAllCampaigns', this.new_campaign).then(response => {
                this.loading = false;
                if(response.data.campaigns instanceof Array) {
                    this.activeTable = response.data.campaigns
                }
                if(response.data.errors){
                    vm.$swal('Unfortunately:', response.data.errors, 'error')
                }
            }).catch( err => {
                this.loading = false;
                console.log(err.message)
            })
        },
        data: () => {
            return {
                loading: false,
                header: 'My campaigns',
                activeTable: [],
                archiveTable: [],
                fields: [
                    { key: 'campaing_checkbox', 'class': 'table_label_hidden' },
                    { key: 'id', label: '№' },
                    { key: 'name', sortable: true, label: 'Name' },
                    { key: 'points', sortable: true, label: 'Points', 'class': 'table_points'  },
                    { key: 'checking_type', sortable: true, label: 'Checking' },
                    { key: 'created_at', sortable: true, label: 'Start Date' },
                    { key: 'end_campaign', label: 'Finish', sortable: true },
                    { key: 'satisfied', sortable: true, label: 'Satisfied' },
                    { key: 'status', sortable: true, label: 'Status' },
                    { key: 'change', 'class': 'text-center table_label_hidden change-campaign' },
                ],
                checkbox_group: {},
                
                currentPageActive: 1,
                currentPageArchive: 1,
                
                perPage    : 10,
                totalRows  : 0,

                selected: [],
                allSelected: false,
                userIds: [],

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
            changeStatusCampaign(id, statusItem){
                this.loading = true;
                return axios.post('/changeStatusCampaign', {
                    id_campaign: id,
                }).then(response => {
                    this.loading = false;
                    if(response.status === 200) {
                        vm.$notify({
                            type:  'success',
                            title: 'Changed successfully!',
                            text : response.data.statusChanged,
                        })
                        return response.data.statusChanged;
                    }
                    if (response.status === 206) {
                        vm.$notify({
                            type:  'danger',
                            title: 'Error',
                            text : response.data.response,
                        })
                        return statusItem
                    }
                }).catch(err => {
                    reject(err)
                    this.loading = false;
                })
            },
            getBadge (satisfied) {
                return satisfied >= 75 ? 'success'
                    : satisfied > 60 && satisfied < 75 ? 'warning'
                        : satisfied <= 60 ? 'danger' : 'primary'
            },
            getRowCount (items) {
                return items.length
            },
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPageActive = 1;
                this.currentPageArchive = 1;
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
            }
        },
    }
</script>