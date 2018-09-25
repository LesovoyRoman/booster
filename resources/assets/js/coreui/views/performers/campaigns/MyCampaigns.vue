<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>

                    <loading v-if="loading" style="position: fixed; left: 50%; top: 50%"></loading>

                    <b-card v-if="!loading">
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

                                        :current-page="currentPage"
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
                                    <template
                                            slot="status"
                                            slot-scope="data" justified="center">
                                        <span :variant="getBadge(data.item.status)">
                                            <i v-for="k in data.item.status" class="star_active fa fa-star"></i>
                                            <i v-for="k in 2" v-if="data.item.status === 3" class="fa fa-star"></i>
                                            <i v-if="data.item.status === 4" class="fa fa-star"></i>
                                        </span>
                                        <span v-if="data.item.status === 3"> (60%)</span>
                                        <span v-if="data.item.status === 4"> (80%)</span>
                                        <span v-if="data.item.status === 5"> (100%)</span>
                                    </template>
                                    <template slot="active" slot-scope="row">
                                        <b-button size="sm" v-if="row.item.active !== 'Waiting for gifts'"  @click="row.item.active = !row.item.active" class="custom_btn_change" style="margin-right: 15px; margin-left: 0;" :variant="'primary'">
                                            <i :class="row.item.active ? 'fa fa-stop-circle' : 'fa fa-play-circle'"></i>
                                        </b-button>

                                        <span v-if="row.item.active === true">
                                            Active
                                        </span>
                                        <span v-if="row.item.active === false">
                                            Inactive
                                        </span>
                                        <span v-if="row.item.active === 'Waiting for gifts'">
                                            <router-link v-bind:to="'/gifts/create-gift'">{{ row.item.active }}</router-link>
                                        </span>

                                    </template>
                                    <template slot="change" justified="center" slot-scope="row">
                                        <b-button size="sm" class="custom_btn_change" :variant="'primary'">
                                            <i class="icon-pencil"></i>
                                        </b-button>
                                    </template>
                                </b-table>
                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(activeTable)"
                                            :per-page="perPage"
                                            v-model="currentPage"
                                            prev-text="Prev"
                                            align="center"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>

                            </b-tab>

                            <b-tab title="Archive">

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
                                        :items="archiveTable"
                                        :fields="fields"

                                        :filter="filter"
                                        :sort-by.sync="sortBy"
                                        :sort-desc.sync="sortDesc"
                                        :sort-direction="sortDirection"
                                        @filtered="onFiltered"

                                        :current-page="currentPage"
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
                                            slot="name"
                                            slot-scope="data">
                                        <router-link :id="id = data.item.id" :data="campaign = data.item" :to="{ name: 'Campaign', params: { campaign:campaign, id: id } }">{{ data.item.name }}</router-link>
                                    </template>
                                    <template
                                            slot="status"
                                            slot-scope="data" justified="center">
                                        <span :variant="getBadge(data.item.status)">
                                            <i v-for="k in data.item.status" class="star_active fa fa-star"></i>
                                            <i v-for="k in 2" v-if="data.item.status === 3" class="fa fa-star"></i>
                                            <i v-if="data.item.status === 4" class="fa fa-star"></i>
                                        </span>
                                        <span v-if="data.item.status === 3"> (60%)</span>
                                        <span v-if="data.item.status === 4"> (80%)</span>
                                        <span v-if="data.item.status === 5"> (100%)</span>
                                    </template>
                                    <template slot="change" justified="center" slot-scope="row">
                                        <b-button size="sm" class="custom_btn_change" :variant="'primary'">
                                            <i class="icon-pencil"></i>
                                        </b-button>
                                    </template>
                                </b-table>
                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(archiveTable)"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPage"
                                            prev-text="Prev"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>

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
    const shuffleArray = (array) => {
        /*for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1))
            const temp = array[i]
            array[i] = array[j]
            array[j] = temp
        }*/
        return array
    }

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
                //console.log(JSON.parse(response.data.campaigns))
                this.activeTable = JSON.parse(response.data.campaigns);
            }).catch( err => {
                this.loading = false;
                console.log(err.message)
            })
        },
        data: () => {
            return {
                loading: false,
                header: 'My campaigns',
                activeTable: [
                    { id: 1, campaign_name: 'Snacks', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: true, change: '' },
                    { id: 2, campaign_name: 'Snacks', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 3, active: false, change: '' },
                    { id: 3, campaign_name: 'Snacks', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: 'Waiting for gifts', change: '' },
                    { id: 4, campaign_name: 'Snacks', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: false, change: '' },
                    { id: 5, campaign_name: 'Snacks', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: false, change: '' },
                    { id: 6, campaign_name: 'Snacks', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: true, change: '' },
                    { id: 7, campaign_name: 'Snacks', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 3, active: 'Waiting for gifts', change: '' },
                    { id: 8, campaign_name: 'Snacks', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: true, change: '' },
                    { id: 9, campaign_name: 'Snacks', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: true, change: '' },
                    { id: 10, campaign_name: 'Snacks', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: false, change: '' },
                    { id: 11, campaign_name: 'Snacks', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: 'Waiting for gifts', change: '' },
                    { id: 12, campaign_name: 'Snacks', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 3, active: true, change: '' },
                    { id: 13, campaign_name: 'Snacks', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: false, change: '' },
                    { id: 14, campaign_name: 'Snacks', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: 'Waiting for gifts', change: '' },
                    { id: 15, campaign_name: 'Snacks', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: true, change: '' },
                    { id: 16, campaign_name: 'Snacks', points: '40000/30000', check_type: 'Photo', start: '20/08/2018', finish: '31/12/2018', status: 5, active: true, change: '' },
                    { id: 17, campaign_name: 'Snacks', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 3, active: false, change: '' },
                    { id: 18, campaign_name: 'Snacks', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: true, change: '' },
                    { id: 19, campaign_name: 'Snacks', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: true, change: '' },
                    { id: 20, campaign_name: 'Snacks', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: true, change: '' },
                    { id: 21, campaign_name: 'Snacks', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: 'Waiting for gifts', change: '' },
                    { id: 22, campaign_name: 'Snacks', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: 3, active: true, change: '' },
                    { id: 23, campaign_name: 'Snacks', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: true, change: '' },
                    { id: 24, campaign_name: 'Snacks', points: '60000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: false, change: '' },
                    { id: 25, campaign_name: 'Snacks', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: true, change: '' },
                ],
                archiveTable: shuffleArray([
                    { id: 1, active: 'Archive', campaign_name: 'Cheese', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 5, change: '' },
                    { id: 2, active: 'Archive', campaign_name: 'Cheese', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 3, change: '' },
                    { id: 3, campaign_name: 'Cheese', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: 'Archive', change: '' },
                    { id: 4, campaign_name: 'Cheese', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: 'Archive', change: '' },
                    { id: 5, campaign_name: 'Cheese', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: 'Archive', change: '' },
                    { id: 6, campaign_name: 'Cheese', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: 'Archive', change: '' },
                    { id: 7, campaign_name: 'Cheese', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 3, active: 'Archive', change: '' },
                    { id: 8, campaign_name: 'Cheese', points: '80000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: 'Archive', change: '' },
                    { id: 9, campaign_name: 'Cheese', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: 'Archive', change: '' },
                    { id: 10, campaign_name: 'Cheese', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: 'Archive', change: '' },
                    { id: 11, campaign_name: 'Cheese', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: 'Archive', change: '' },
                    { id: 12, campaign_name: 'Cheese', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 3, active: 'Archive', change: '' },
                    { id: 13, campaign_name: 'Cheese', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: 'Archive', change: '' },
                    { id: 14, campaign_name: 'Cheese', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: 'Archive', change: '' },
                    { id: 15, campaign_name: 'Cheese', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: 'Archive', change: '' },
                    { id: 16, campaign_name: 'Cheese', points: '40000/30000', check_type: 'Photo', start: '20/08/2018', finish: '31/12/2018', status: 5, active: 'Archive', change: '' },
                    { id: 17, campaign_name: 'Cheese', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 3, active: 'Archive', change: '' },
                    { id: 18, campaign_name: 'Cheese', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: 'Archive', change: '' },
                    { id: 19, campaign_name: 'Cheese', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: 'Archive', change: '' },
                    { id: 20, campaign_name: 'Cheese', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: 'Archive', change: '' },
                    { id: 21, campaign_name: 'Cheese', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: 'Archive', change: '' },
                    { id: 22, campaign_name: 'Cheese', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: 3, active: 'Archive', change: '' },
                    { id: 23, campaign_name: 'Cheese', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: 'Archive', change: '' },
                    { id: 24, campaign_name: 'Cheese', points: '60000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: 5, active: 'Archive', change: '' },
                    { id: 25, campaign_name: 'Cheese', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: 4, active: 'Archive', change: '' },
                ]),
                fields: [
                    { key: 'campaing_checkbox', 'class': 'table_label_hidden' },
                    { key: 'id', label: '№' },
                    { key: 'name', sortable: true, label: 'Name' },
                    { key: 'points', sortable: true, label: 'Points', 'class': 'table_points'  },
                    { key: 'checking_type', sortable: true, label: 'Checking' },
                    { key: 'created_at', sortable: true, label: 'Start Date' },
                    { key: 'finish', sortable: true, label: 'Finish Date' },
                    { key: 'status', sortable: true, label: 'Satisfied' },
                    { key: 'active', sortable: true, label: 'Status' },
                    { key: 'change', 'class': 'text-center table_label_hidden' }
                ],
                checkbox_group: {},
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