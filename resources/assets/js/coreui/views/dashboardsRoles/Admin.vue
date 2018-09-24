<template>
    <div>
        <b-row>

            <b-col sm="6" lg="3">
                <Callout variant="primary">
                    <small class="text-muted">All performers</small><br>
                    <strong class="h5">79</strong>
                    <div class="chart-wrapper">
                        <callout-chart-example
                                :data="[32, 45, 63, 68, 72, 78, 90]"
                                variant="#4875B4"
                                width="80"
                                height="30" />
                    </div>
                </Callout>
            </b-col>

            <b-col sm="6" lg="3">
                <Callout variant="primary">
                    <small class="text-muted">All Influencers</small><br>
                    <strong class="h5">347</strong>
                    <div class="chart-wrapper">
                        <callout-chart-example
                                :data="[56, 36, 78, 36, 58, 70, 90]"
                                variant="#4875B4"
                                width="80"
                                height="30" />
                    </div>
                </Callout>
            </b-col>

            <b-col sm="6" lg="3">
                <Callout variant="primary">
                    <small class="text-muted">All users</small><br>
                    <strong class="h5">9572</strong>
                    <div class="chart-wrapper">
                        <callout-chart-example
                                :data="[35, 43, 56, 49, 68, 78, 80]"
                                variant="#4875B4"
                                width="80"
                                height="30" />
                    </div>
                </Callout>
            </b-col>

            <b-col sm="6" lg="3">
                <Callout variant="primary">
                    <small class="text-muted">All assistants</small><br>
                    <strong class="h5">107</strong>
                    <div class="chart-wrapper">
                        <callout-chart-example
                                :data="[78, 81, 80, 45, 34, 12, 40]"
                                variant="#4875B4"
                                width="80"
                                height="30" />
                    </div>
                </Callout>
            </b-col>

        </b-row>


        <b-row>
            <b-col>
                <h4>All points</h4>
                <div class="chart-wrapper">
                    <b-button-toolbar
                            class="float-right"
                            aria-label="Toolbar with buttons group">
                        <b-form-radio-group
                                class="mr-3"
                                id="radiosBtn"
                                buttons
                                button-variant="outline-secondary"
                                v-model="selected"
                                name="radiosBtn">
                            <b-form-radio
                                    class="mx-0"
                                    value="days">Days</b-form-radio>
                            <b-form-radio
                                    class="mx-0"
                                    value="months">Months</b-form-radio>
                            <b-form-radio
                                    class="mx-0"
                                    value="years">Years</b-form-radio>
                        </b-form-radio-group>
                    </b-button-toolbar>
                    <main-chart :options="options" style="height:300px;margin-top:10px; margin-bottom: 30px;"
                                height="300"></main-chart>
                </div>
            </b-col>
        </b-row>


        <b-row>
            <b-col lg="6" sm="12">
                <b-card>
                <h4>Auditory</h4>
                    <ul class="horizontal-bars type-2">
                        <li>
                            <i class="icon-social-youtube"/>
                            <span class="title">YouTube</span>
                            <span class="value">1720 <span class="text-muted small">(56%)</span></span>
                            <div class="bars">
                                <b-progress
                                        height={}
                                class="progress-xs"
                                :value="56"
                                variant="success"/>
                            </div>
                        </li>
                        <li>
                            <i class="icon-social-facebook"/>
                            <span class="title">Facebook</span>
                            <span class="value">800 <span class="text-muted small">(27%)</span></span>
                            <div class="bars">
                                <b-progress
                                        height={}
                                class="progress-xs"
                                :value="27"
                                variant="success"/>
                            </div>
                        </li>
                        <li>
                            <i class="icon-social-twitter"/>
                            <span class="title">Twitter</span>
                            <span class="value">450 <span class="text-muted small">(15%)</span></span>
                            <div class="bars">
                                <b-progress
                                        height={}
                                class="progress-xs"
                                :value="15"
                                variant="success"/>
                            </div>
                        </li>
                        <li>
                            <i class="icon-social-linkedin"/>
                            <span class="title">LinkedIn</span>
                            <span class="value">400 <span class="text-muted small">(12%)</span></span>
                            <div class="bars">
                                <b-progress
                                        height={}
                                class="progress-xs"
                                :value="12"
                                variant="success"/>
                            </div>
                        </li>
                    </ul>
                </b-card>
            </b-col>

            <b-col lg="6" sm="12">
                <b-card>
                    <h4>Tariffs</h4>
                    <ul class="horizontal-bars type-2">
                        <li>
                            <span class="title">Standart</span>
                            <span class="value">50 <span class="text-muted small">(60%)</span></span>
                            <div class="bars">
                                <b-progress
                                        height={}
                                class="progress-xs"
                                :value="60"
                                variant="success"/>
                            </div>
                        </li>
                        <li>
                            <span class="title">Silver</span>
                            <span class="value">20 <span class="text-muted small">(25%)</span></span>
                            <div class="bars">
                                <b-progress
                                        height={}
                                class="progress-xs"
                                :value="25"
                                variant="success"/>
                            </div>
                        </li>
                        <li>
                            <span class="title">Gold</span>
                            <span class="value">9 <span class="text-muted small">(15%)</span></span>
                            <div class="bars">
                                <b-progress
                                        height={}
                                class="progress-xs"
                                :value="15"
                                variant="success"/>
                            </div>
                        </li>
                    </ul>
                </b-card>
            </b-col>
        </b-row>

        <b-row>
            <b-col>
                    <b-table
                            class="mb-0 table-outline"
                            responsive="sm"
                            hover
                            :items="tableItems"
                            :fields="tableFields"
                            head-variant="light">
                        <div
                                slot="type"
                                class="type"
                                slot-scope="item">
                            <strong class="h6">{{ item.value.name }}</strong>
                        </div>
                        <div slot="month" slot-scope="item">
                            <span v-if="item.value.checked" style="margin-right: 10px">{{ item.value.checked }}
                                <small class="text-muted">(Checked)</small>
                            </span>
                            <span>
                                <span v-if="item.value.currency">$</span>{{ item.value.all }}
                                <small class="text-muted" v-if="!item.value.currency">(All)</small>
                            </span>
                        </div>
                        <div slot="year" slot-scope="item">
                            <span v-if="item.value.checked" style="margin-right: 10px">{{ item.value.checked }}
                                <small class="text-muted">(Checked)</small>
                            </span>
                            <span>
                                <span v-if="item.value.currency">$</span>{{ item.value.all }}
                                <small class="text-muted" v-if="!item.value.currency">(All)</small>
                            </span>
                        </div>
                        <div slot="total" slot-scope="item">
                            <span v-if="item.value.checked" style="margin-right: 10px">{{ item.value.checked }}
                                <small class="text-muted">(Checked)</small>
                            </span>
                            <span>
                                <span v-if="item.value.currency">$</span>{{ item.value.all }}
                                <small class="text-muted" v-if="!item.value.currency">(All)</small>
                            </span>
                        </div>
                    </b-table>
            </b-col>
        </b-row>



    </div>
</template>

<script>
    let vm = {};

    import { Callout } from '../../components'
    import CalloutChartExample from './../dashboard/CalloutChartExample'
    import CardLine3ChartExample from './../dashboard/CardLine3ChartExample'
    import MainChart from './../charts/CustomMain.vue'

    export default {
        name: 'AdminDashboard',
        watch: {
            selected: function() {
                this.selected === 'months' ? this.options = this.options2 : this.options
                this.selected === 'days' ? this.options = this.options1 : this.options
                this.selected === 'years' ? this.options = this.options3 : this.options
            }
        },
        methods: {
            flag (value) {
                return `flag-icon flag-icon-${value}`
            },
            variant (value) {
                let $variant
                if (value <= 25)
                    $variant = 'info'
                else if (value > 25 && value <= 50)
                    $variant = 'success'
                else if (value > 50 && value <= 75)
                    $variant = 'warning'
                else if (value > 75 && value <= 100)
                    $variant = 'danger'

                return $variant
            },
        },
        data(){
            return {
                selected: 'days',

                options: {
                    label: 'Days',
                    labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S'],
                    datas: [3002, 7006, 3005, 6000, 3002, 6005, 1002, 8700, 4500, 1003, 6700, 4500, 8700, 3004, 2300, 6000, 3200, 6500, 1200, 8700, 2003, 9600, 11002, 4500, 7300, 9009, 4300, 2500]
                },

                options1: {
                    label: 'Days',
                    labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S', 'S'],
                    datas: [3002, 7006, 3005, 6000, 3002, 6005, 1002, 8700, 4500, 1003, 6700, 4500, 8700, 3004, 2300, 6000, 3200, 6500, 1200, 8700, 2003, 9600, 11002, 4500, 7300, 9009, 4300, 2500]
                },

                options2: {
                    label: 'Months',
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datas: [350000, 600000, 320000, 650000, 120000, 870000, 450000, 130000, 670000, 450000, 870000, 340000, 230000]
                },

                options3: {
                    label: 'Years',
                    labels: ['2015', '2016', '2017', '2018', '2019'],
                    datas: [250000000, 450000000, 300000000, 800000000, 900000000]
                },

                tableItems: [
                    {
                        type     : { name: 'Sales' },
                        month    : { all: 15000, currency : true },
                        year     : { all: 120000, currency : true  },
                        total    : { all: 600000, currency : true  },

                    },
                    {
                        type    : { name: 'Turnover' },
                        month   : { all: 300000, currency : true  },
                        year    : { all: 1000000, currency : true  },
                        total   : { all: 7000000, currency : true  },
                    },
                    {
                        type    : { name: 'Turnover percentage'},
                        month   : { all: 5000, currency : true  },
                        year    : { all: 15000, currency : true  },
                        total   : { all: 105000, currency : true  },
                    },
                    {
                        type    : { name: 'Amount campaigns' },
                        month   : { all: 100 },
                        year    : { all: 900 },
                        total   : { all: 2750 },
                    },
                    {
                        type    : { name: 'Points' },
                        month   : { checked: 5432, all: 9572 },
                        year    : { checked: 18596, all: 39704 },
                        total   : { checked: 87495, all: 165746 },
                    },
                ],
                tableFields: {
                    type: {
                        label: 'Type',
                    },
                    month: {
                        label: 'Month'
                    },
                    year: {
                        label: 'Year'
                    },
                    total: {
                        label: 'Total'
                    },
                },
            }
        },
        components: {
            Callout,
            CardLine3ChartExample,
            CalloutChartExample,
            MainChart,
        },
    }
</script>