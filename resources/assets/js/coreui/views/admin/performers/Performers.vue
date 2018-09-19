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
                                <b-form-input v-model="filter" placeholder="Enter performer name / work position / company ID / etc"/>
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
                            <template slot="HEAD_performer_checkbox" slot-scope="data" >
                                <div class="custom-control custom-checkbox">
                                    <input
                                            type="checkbox"
                                            v-model="allSelected"
                                            :value="true"
                                            :id="'performer_checkbox'"
                                            :name="'performer_checkbox'"
                                            class="custom-control-input">
                                    <label
                                            @click="selectAll"
                                            style="display: block"
                                            class="custom-control-label"
                                            :for="'performer_checkbox'"></label>
                                </div>
                            </template>
                            <template slot="performer_checkbox" slot-scope="data">
                                <div class="custom-control custom-checkbox">
                                    <input
                                            type="checkbox"
                                            :value="data.item.id"
                                            v-model="performersIds"
                                            @click="select"
                                            :id="'performer_checkbox' + data.item.id"
                                            :name="'performer_checkbox' + data.item.id"
                                            class="custom-control-input">
                                    <label
                                            style="display: block"
                                            class="custom-control-label"
                                            :for="'performer_checkbox' + data.item.id"></label>
                                </div>
                            </template>
                            <template slot="name" slot-scope="data">
                                <span>{{ data.item.name }}</span>
                            </template>
                            <template slot="info" slot-scope="row">
                                <span v-for="(item_info, index) in row.item.infoPerformer" :class="index !== 'brand' ? 'span-row spanBorderBottomTable' : 'span-row'">
                                    <span class="spanKeyTable">{{ index }}:</span> {{ item_info }}
                                </span>
                            </template>
                            <template slot="tariff" slot-scope="row">
                                <span class="span-row spanBorderBottomTable"><span class="spanKeyTable">Type:</span> {{ row.item.tariff.type }}</span>
                                <span class="span-row spanBorderBottomTable"><span class="spanKeyTable">From:</span> {{ row.item.tariff.paid }}</span>
                                    <span class="span-row"><span class="spanKeyTable">To:</span> {{ row.item.tariff.by }}</span>
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

                selected: [],
                allSelected: false,
                performersIds: [],

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
                    {id: 1, name: 'Quentin Tarantino', infoPerformer: {email: 'email@tarantino.com', phone: '+9999999999', position: 'Producer', site: 'https://mysite.com', brand: 'Tarantino films',}, tariff: {type: 'Standart', paid: '2018.09.09', by: '2019.09.09'},  legal_name_company: 'Tino corporation', company_address: 'st.Sverdlova 21, Moscow, Russia', company_id: '320498523',  vat: '23557645723954' },
                    {id: 2, name: 'Luc Besson', infoPerformer: {email: 'email@besson.com', phone: '+9999999999', position: 'Producer', site: 'https://mysite.com', brand: 'Luc',}, tariff: {type: 'Silver', paid: '2018.02.13', by: '2018.05.13'}, legal_name_company: 'Luc corporation', company_address: 'st.Sverdlova 21, Moscow, Russia', company_id: '350794533', vat: '12957642723957' },
                ],
                fields: [
                    { key: 'performer_checkbox', 'class': 'table_label_hidden check-box-performers' },
                    { key: 'name', sortable: false, 'class': 'name_performer' },
                    { key: 'info', sortable: false, 'class': 'info_performer', label: 'Info' },
                    { key: 'tariff', sortable: false, 'class': 'tariff_performer_admin' },
                    { key: 'legal_name_company', sortable: false, 'class': 'legam_company_performer' },
                    { key: 'company_address', sortable: false, 'class': 'company_address_performer' },
                    { key: 'company_id', sortable: false, 'class': 'company_id_performer' },
                    { key: 'vat', sortable: false, 'class': 'vat_performer' },
                    { key: 'change', label: '', 'class': 'table_label_hidden change-performer' },
                    { key: 'delete', label: '', 'class': 'table_label_hidden delete-performer' }
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
                vm.performersIds = [];

                if (vm.allSelected) {
                    vm.performers.forEach(function(item){
                        vm.performersIds.push(item.id);
                    })
                }
            },
            removeElement: function (item) {
                if(confirm("Are you sure?")) {
                    this.performers.splice(item.index, 1);
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