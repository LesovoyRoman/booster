<template>
    <div>
        <b-row>
            <b-col lg="3" md="6" sm="12">
                <div class="card-tariff-dashboard card">
                    <h4 class="heaader_tariff">Tariff</h4>
                    <h5>{{ performer.tariff.type }}</h5>
                    <h6>Until: {{ performer.tariff.until }}</h6>
                </div>
            </b-col>

            <b-col lg="9" md="6" sm="12">
                <b-card>
                    <ul class="list_custom_scope">
                        <li>
                            <div class="text-muted">Active</div>
                            <strong>17</strong>
                            <div class="text-muted">Campaigns</div>
                        </li>
                        <li>
                            <div class="text-muted">Archive</div>
                            <strong>34</strong>
                            <div class="text-muted">Campaigns</div>
                        </li>
                        <li>
                            <div class="text-muted">Participate</div>
                            <strong>73</strong>
                            <div class="text-muted">Influencers</div>
                        </li>
                        <li>
                            <div class="text-muted">Participate</div>
                            <strong>22</strong>
                            <div class="text-muted">Assistants</div>
                        </li>
                        <li>
                            <div class="text-muted">Gifts</div>
                            <strong>23</strong><small class="text-muted"> (ordered)</small><br>
                            <strong>11</strong><small class="text-muted"> (sent)</small>
                        </li>
                    </ul>
                </b-card>
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
                    <h4>Sales</h4>

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
                                {{ item.value.all }}<small class="text-muted" v-if="item.value.currency">$</small>
                                <small class="text-muted" v-if="!item.value.currency">(All)</small>
                            </span>
                        </div>
                        <div slot="year" slot-scope="item">
                            <span v-if="item.value.checked" style="margin-right: 10px">{{ item.value.checked }}
                                <small class="text-muted">(Checked)</small>
                            </span>
                            <span>
                                {{ item.value.all }}<small class="text-muted" v-if="item.value.currency">$</small>
                                <small class="text-muted" v-if="!item.value.currency">(All)</small>
                            </span>
                        </div>
                        <div slot="total" slot-scope="item">
                            <span v-if="item.value.checked" style="margin-right: 10px">{{ item.value.checked }}
                                <small class="text-muted">(Checked)</small>
                            </span>
                            <span>
                                {{ item.value.all }}<small class="text-muted" v-if="item.value.currency">$</small>
                                <small class="text-muted" v-if="!item.value.currency">(All)</small>
                            </span>
                        </div>
                    </b-table>
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    let vm = {};

    export default {
        name: 'PerformerDashboard',
        data(){
            return {
                performer: {
                    tariff: { type: 'Standart', until: '2020.20.12' },


                },

                tableItems: [
                    {
                        type    : { name: 'Points' },
                        month   : { checked: 5432, all: 9572 },
                        year    : { checked: 18596, all: 39704 },
                        total   : { checked: 87495, all: 165746 },
                    },
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
        created(){
            vm = this;
        },
        methods: {

        }
    }
</script>