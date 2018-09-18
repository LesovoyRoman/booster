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
                                <b-form-input v-model="filter" placeholder="Enter performer name / country / city / type"/>
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
                                :items="performers"
                                :fields="fields"

                                :filter="filter"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                @filtered="onFiltered"

                                :current-page="currentPage"
                                :per-page="perPage">
                            <template slot="name" slot-scope="data">
                                <span>{{ data.item.name }}</span>
                            </template>
                        </b-table>

                        <nav>
                            <b-pagination
                                    :total-rows="getRowCount(performers)"
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
        name: 'PerformersAdmin',
        data() {
            return {
                header: 'Performers',
                performer_city: null,
                performer_country: null,
                performer_type: null,

                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                sendTo: '',

                performer_modal: {},

                countries: [],
                cities: [],
                performer_types: [],

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                performers: [
                    {id: 1, name: 'Quentin Tarantino', email: 'email@tarantino.com', work_position: 'Producer', phone: '+9999999999', brand: 'Tarantino films', legal_name_company: 'Tino corporation', company_address: 'st.Sverdlova 21, Moscow, Russia', company_id: '320498523', site: 'https://mysite.com', vat: '23557645723954' },
                    {id: 1, name: 'Luc Besson', email: 'email@besson.com', work_position: 'Producer', phone: '+9999999999', brand: 'Luc', legal_name_company: 'Luc corporation', company_address: 'st.Sverdlova 21, Moscow, Russia', company_id: '350794533', site: 'https://mysite.com', vat: '12957642723957' },
                ],
                fields: [
                    { key: 'name', sortable: false, 'class': 'name_performer' },
                    { key: 'email', sortable: false, 'class': 'email_performer' },
                    { key: 'work_position', sortable: false, 'class': 'work_performer' },
                    { key: 'phone', sortable: false, 'class': 'phone_performer' },
                    { key: 'brand', sortable: false, 'class': 'brand_performer' },
                    { key: 'legal_name_company', sortable: false, 'class': 'legam_company_performer' },
                    { key: 'company_address', sortable: false, 'class': 'company_address_performer' },
                    { key: 'company_id', sortable: false, 'class': 'company_id_performer' },
                    { key: 'site', sortable: false, 'class': 'site_performer' },
                    { key: 'vat', sortable: false, 'class': 'vat_performer' }
                ]
            }
        },
        created() {
            vm = this;
        },
        methods: {
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            selectAll: function() {
                vm.allSelected = !vm.allSelected;
                vm.performerIds = [];

                if (vm.allSelected) {
                    vm.performers.forEach(function(item){
                        vm.performerIds.push(item.id);
                    })
                }
            },
            select: function() {
                vm.allSelected = false;
            },
            getRowCount (items) {
                return items.length
            }
        },
        computed: {
            sortOptions () {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => { return { text: f.label, value: f.key } })
            },
        }
    }
</script>