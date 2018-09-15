<template>
    <div :campaign="computedInvoice" class="wrapper">
        <div class="animated fadeIn" v-if="invoice">
            <b-row>
                <b-col sm="12" md="12">
                    <b-row>
                        <b-col>
                            <h2 class="h2">{{ header }} {{ invoiceNumber }}</h2>
                        </b-col>
                        <b-col>
                            <b-button
                                    type="submit"
                                    class="font500 float-right uppercase"
                                    variant="secondary"><i class="fa fa-file-pdf-o"></i> save pdf
                            </b-button>
                            <b-button
                                    type="submit"
                                    class="font500 float-right uppercase"
                                    variant="secondary" style="margin-right: 15px;"><i class="fa fa-print"></i> print
                            </b-button>
                            <div class="clearfix"></div>
                        </b-col>
                    </b-row>

                    <b-card>

                        <b-row>
                            <b-col md="4" lg="4">
                                <p class="card-text header_card_simple">From</p>

                                <span class="span-row">BluEgg OÜ</span>
                                <span class="span-row">Mannimae, Pudisoo kula,</span>
                                <span class="span-row">Kuusalu vald, 74626, Estonia</span>
                                <span class="span-row"><span class="font500">Bank name:</span>  AS LHV Pank</span>
                                <span class="span-row"><span class="font500">Bank Address:</span>  Tartu mnt 2, 10145 Tallinn, Estonia</span>
                                <span class="span-row">EE437700771002903764</span>
                                <span class="span-row"><span class="font500">SWIFT/BIC:</span> LHVBEE22</span>
                                <span class="span-row"><span class="font500">VAT</span> EE102054653</span>

                            </b-col>

                            <b-col md="4" lg="4">
                                <p class="card-text header_card_simple">To</p>

                                <span class="span-row">Campaign name: Snacks</span>
                                <span class="span-row">Campaign ID: 37653</span>
                            </b-col>

                            <b-col md="4" lg="4">
                                <p class="card-text header_card_simple">Details</p>

                                <span class="span-row"><span class="font500">Invoice:</span> {{ invoiceNumber }}</span>
                                <span class="span-row">Pay to: ...</span>
                                <span class="span-row">Terms: ...</span>
                                <span class="span-row">March 30, 2000</span>
                            </b-col>
                        </b-row>

                        <div class="margin-top-30"></div>

                        <b-table
                                :hover="false"
                                :striped="false"
                                :bordered="false"
                                :small="true"
                                :fixed="false"
                                responsive="sm"
                                :fields="fields"
                                :items="invoiceCurrent"
                                class="verticalTop">
                            <template slot="currency_sum" slot-scope="data">
                                {{ data.item.currency_sum }}$
                            </template>
                            <template slot="vat" slot-scope="data">
                                {{ data.item.vat }}%
                            </template>
                            <template slot="total" slot-scope="data">
                                {{ data.item.total }}$
                            </template>
                        </b-table>

                        <div class="margin-top-30"></div>

                        <b-row>
                            <b-col offset="8">
                                <p class="card-text header_card_simple colorBlack">VAT:</p>
                                <p class="card-text header_card_simple colorBlack">Total:</p>
                            </b-col>
                            <b-col offset="1">
                                <p class="card-text header_card_simple colorBlack font500">9$</p>
                                <p class="card-text header_card_simple colorBlack font500">80$</p>
                            </b-col>
                        </b-row>

                        <div class="margin-top-30"></div>

                        <b-row>
                            <b-col>
                                <b-form-group>
                                    <b-button
                                            type="submit"
                                            class="font500 float-right uppercase"
                                            variant="primary">get paid</b-button>
                                </b-form-group>
                            </b-col>
                        </b-row>

                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};

    export default {
        props: ['invoice', 'id', 'invoiceNumber'],
        name: 'Invoice',
        data(){
            return {
                header: 'Invoice',

                invoiceCurrent: [
                    { id: 1, tariff_name: 'Standart plan', currency_sum: 89,  vat: 10, total: 80, },
                ],

                fields: [
                    { key: 'tariff_name', sortable: false, 'class': 'table_tariffs' },
                    { key: 'currency_sum', sortable: false, 'class': 'table_currency_sum' },
                    { key: 'vat', sortable: false, 'class': 'table_vat' },
                    { key: 'total', sortable: false, 'class': 'table_total' },
                ]
            }
        },
        created(){
            vm = this;
        },
        computed: {
            computedInvoice: function () {
                if (typeof this.invoice === 'undefined') {
                    vm.$router.go(-1)
                }
            },
        },
        methods: {

        },
    }
</script>