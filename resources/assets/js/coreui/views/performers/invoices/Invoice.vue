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

                                <span class="span-row">Campaign name: OAO Team Corporation</span>
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

                        <b-row v-if="invoice.status !== 'Paid'">
                            <b-col>
                                <b-form-group>
                                    <b-button
                                            type="submit"
                                            class="font500 float-right uppercase"
                                            variant="primary" @click="openModal">get paid</b-button>
                                </b-form-group>
                            </b-col>
                        </b-row>

                    </b-card>
                </b-col>
            </b-row>
        </div>

        <b-modal id="modalPayment" :header-bg-variant="'primary'" title="Choose type of Payment" size="lg" ref="modalPayment" hide-footer>
            <!--<button type="button" aria-label="Close" class="close" @click="closeModal">×</button>-->

            <div class="types_payment">
                <div :class="chosenType === 'masterCard' ? 'type_payment active' : 'type_payment'" @click="chosenType = 'masterCard'"><img src="~static/img/masterCard.png" alt=""></div>
                <div :class="chosenType === 'paypal' ? 'type_payment active' : 'type_payment'" @click="chosenType = 'paypal'"><img src="~static/img/paypal.png" alt=""></div>
            </div>
            <div class="clearfix"></div>

            <div v-if="chosenType === 'masterCard'">
                <form action="">
                    <div slot="header">
                        <strong>Credit Card</strong> <small>Form</small>
                    </div>
                    <b-row>
                        <b-col sm="12">
                            <b-form-group>
                                <label for="ccnumber">Credit Card Number</label>
                                <b-form-input
                                        type="text"
                                        id="ccnumber"
                                        placeholder="0000 0000 0000 0000"/>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-row>
                        <b-col sm="4">
                            <b-form-group >
                                <label for="month1">Month</label>
                                <b-form-select
                                        id="month1"
                                        :plain="true"
                                        :options="[1,2,3,4,5,6,7,8,9,10,11,12]"/>
                            </b-form-group>
                        </b-col>
                        <b-col sm="4">
                            <b-form-group>
                                <label for="year1">Year</label>
                                <b-form-select
                                        id="year1"
                                        :plain="true"
                                        :options="[2014,2015,2016,2017,2018,2019,2020,2021,2022,2023,2024,2025]"/>
                            </b-form-group>
                        </b-col>
                        <b-col sm="4">
                            <b-form-group>
                                <label for="cvv">CVV/CVC</label>
                                <b-form-input
                                        type="text"
                                        id="cvv"
                                        placeholder="123"/>
                            </b-form-group>
                        </b-col>
                    </b-row>

                    <b-row>
                        <b-col>
                            <b-button type="submit" size="lg" class="float-right uppercase" :variant="'secondary'">Get Paid</b-button><br>

                            <div class="clearfix"></div>
                            <span class="font12">By clicking you accept our license policy.<br>You will accept the payment</span>
                        </b-col>
                    </b-row>
                </form>
            </div>

            <div v-if="chosenType === 'paypal'">
                <div class="margin-top-30"></div>
                <b-button class="float-right uppercase" size="lg" type="submit" href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_ship-now" target="_blank" :variant="'secondary'">Get Paid</b-button><br>
                <div class="clearfix"></div>
                <span class="font12">By clicking you accept license policy.<br>You'll be replaced to payment page</span>
            </div>

        </b-modal>
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
                chosenType: 'masterCard',

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
            closeModal: function () {
                this.$refs.modalPayment.hide();
            },
            openModal: function () {
                this.$refs.modalPayment.show();
            },
        },
    }
</script>