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

                        <b-row>
                            <b-col>
                                <b-form-group>
                                    <b-input-group>
                                        <b-form-input v-model="filter" placeholder="Type name of tarrif / date / status"/>
                                        <b-input-group-append>
                                            <b-btn :variant="'primary'" :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                        </b-input-group-append>
                                    </b-input-group>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-table
                                :id="giftsCards ? 'table_cards' : ''"
                                :hover="false"
                                :striped="false"
                                :bordered="false"
                                :small="true"
                                :fixed="false"
                                responsive="sm"
                                :items="invoices"
                                :fields="fields"

                                :filter="filter"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                @filtered="onFiltered"

                                :current-page="currentPage"
                                :per-page="perPage">
                            <template slot="tariff_name" slot-scope="data">
                                <span class="span-row">{{ data.item.tariff_name }}</span>
                            </template>
                            <template slot="bill" slot-scope="data">
                                {{ data.item.bill }} Rub
                            </template>
                            <template slot="status" slot-scope="data">
                                {{ data.item.status }}
                            </template>
                            <template slot="open_bill" slot-scope="data">
                                <b-button class="" :id="id = data.item.id" :invoiceNumber="invoiceNumber = '#3487-34'" :data="invoice = data.item" v-bind:to="{ name: 'Invoice', params: { invoice:invoice, id: id, invoiceNumber: invoiceNumber } }" :variant="'primary'">
                                    Open bill
                                </b-button>
                            </template>
                        </b-table>

                        <nav>
                            <b-pagination
                                    :total-rows="getRowCount(invoices)"
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
        name: 'InvoicesAdmin',
        data(){
            return {
                header: 'List of invoices',

                giftsList: true,
                giftsCards: false,
                campaignSelected: null,

                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                invoices: [
                    { id: 1, tariff_name: 'Standart plan', start: '2017.05.21', end: '2017.05.31', status: 'Paid', bill: 5000 },
                    { id: 2, tariff_name: 'Silver plan', start: '2017.05.22', end: '2017.05.09', status: 'Wait to be paid', bill: 4400 },
                    { id: 3, tariff_name: 'Gold plan', start: '2017.05.23', end: '2017.05.29', status: 'Paid', bill: 6400 },
                    { id: 4, tariff_name: 'Standart plan', start: '2017.04.21', end: '2017.03.30', status: 'Paid', bill: 2400 },
                    { id: 5, tariff_name: 'Standart plan', start: '2017.04.25', end: '2017.02.25', status: 'Paid', bill: 3400 },
                    { id: 6, tariff_name: 'Gold plan', start: '2016.05.21', end: '2016.05.29', status: 'Wait to be paid', bill: 1400 },
                    { id: 7, tariff_name: 'Standart plan', start: '2018.05.21', end: '2018.05.31', status: 'Paid', bill: 6700 },
                    { id: 8, tariff_name: 'Gold plan', start: '2017.03.21', end: '2016.11.30', status: 'Paid', bill: 9800 },
                    { id: 9, tariff_name: 'Silver plan', start: '2017.11.31', end: '2014.12.31', status: 'Paid', bill: 54500 },
                    { id: 10, tariff_name: 'Silver plan', start: '2017.05.21', end: '2017.07.18', status: 'Wait to be paid', bill: 3500 },
                    { id: 11, tariff_name: 'Standart plan', start: '2017.03.11', end: '2015.05.31', status: 'Paid', bill: 5600 },
                    { id: 12, tariff_name: 'Silver plan', start: '2017.02.25', end: '2017.03.15', status: 'Paid', bill: 8400 },
                ],

                fields: [
                    { key: 'tariff_name', sortable: true, 'class': 'table_tariffs' },
                    { key: 'start', sortable: true, 'class': 'table_start' },
                    { key: 'end', sortable: true, 'class': 'table_end' },
                    { key: 'bill', sortable: true, 'class': 'table_bill' },
                    { key: 'status', sortable: true, 'class': 'table_status' },
                    { key: 'open_bill', label: '', 'class': 'table_label_hidden open_bill' }
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
            getRowCount (items) {
                return items.length
            },
        }
    }
</script>