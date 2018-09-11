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
                    <b-card id="tariff_plan">
                        <p class="card-header-custom">Current plan: <span>Silver</span></p>
                        <p class="card-header-custom small-header">Next charge: <span>20.01.18</span></p>

                        <div class="divider_custom"></div>

                            <b-tabs pills card id="tabs_tariffs">
                                <b-tab title="Monthly" active>
                                    <b-row>
                                        <b-col>
                                            <b-card
                                                    header-bg-variant="primary"
                                                    tag="article"
                                                    style="max-width: 20rem;"
                                                    class="mb-2 card_tariff_month"
                                                    header-align="center">
                                                <p class="card-header type_plan">Standart plan
                                                    <span class="price_plan">$97</span>
                                                    <span class="period_price">per month</span>
                                                </p>
                                                <ul class="list-pros">
                                                    <li>
                                                        <span>Search Influencers</span>
                                                    </li>
                                                    <li>
                                                        <span>Create Limited Campaigns</span>
                                                    </li>
                                                    <li>
                                                        <span>Send Limited Offers To Influencers</span>
                                                    </li>
                                                    <li>
                                                        <span>Gift Shop</span>
                                                    </li>
                                                    <li>
                                                        <span>1% Commission Form Turnove</span>
                                                    </li>
                                                </ul>
                                                <b-button href="#" variant="primary" class="btn_plan">Choose</b-button>
                                            </b-card>
                                        </b-col>
                                        <b-col>
                                            <b-card
                                                    header-bg-variant="primary"
                                                    tag="article"
                                                    style="max-width: 20rem;"
                                                    class="mb-2 card_tariff_month"
                                                    header-align="center">
                                                <p class="card-header type_plan">Silver plan
                                                    <span class="price_plan">$297</span>
                                                    <span class="period_price">per month</span>
                                                </p>
                                                <ul class="list-pros">
                                                    <li>
                                                        <span>All in Standart plan</span>
                                                    </li>
                                                    <li>
                                                        <span>Amazon Gift Shop</span>
                                                    </li>
                                                    <li>
                                                        <span>0.5% Commission Form Turnove</span>
                                                    </li>
                                                </ul>
                                                <b-button href="#" variant="primary" class="btn_plan">Choose</b-button>
                                            </b-card>
                                        </b-col>
                                        <b-col>
                                            <b-card
                                                    header-bg-variant="primary"
                                                    tag="article"
                                                    style="max-width: 20rem;"
                                                    class="mb-2 card_tariff_month"
                                                    header-align="center">
                                                <p class="card-header type_plan">Golden plan
                                                    <span class="price_plan">$997</span>
                                                    <span class="period_price">per month</span>
                                                </p>
                                                <ul class="list-pros">
                                                    <li>
                                                        <span>All in Silver Plan</span>
                                                    </li>
                                                    <li>
                                                        <span>Send Offers To Influencers-Stars</span>
                                                    </li>
                                                    <li>
                                                        <span>0% Commission Form Turnove</span>
                                                    </li>
                                                </ul>
                                                <b-button href="#" variant="primary" class="btn_plan">Choose</b-button>
                                            </b-card>
                                        </b-col>
                                    </b-row>
                                </b-tab>
                                <b-tab title="Yearly">
                                    <b-row>
                                        <b-col>
                                            <b-card
                                                    ref="card_tariff"
                                                    header-bg-variant="primary"
                                                    tag="article"
                                                    style="max-width: 20rem;"
                                                    class="mb-2 card_tariff_year"
                                                    header-align="center">
                                                <p class="card-header type_plan">Standart plan
                                                    <span class="price_plan">$50<span class="period_price">save 15%</span></span>
                                                    <span class="period_price">per year</span>
                                                </p>
                                                <ul class="list-pros">
                                                    <li>
                                                        <span>Search Influencers</span>
                                                    </li>
                                                    <li>
                                                        <span>Create Limited Campaigns</span>
                                                    </li>
                                                    <li>
                                                        <span>Send Limited Offers To Influencers</span>
                                                    </li>
                                                    <li>
                                                        <span>Gift Shop</span>
                                                    </li>
                                                    <li>
                                                        <span>1% Commission Form Turnove</span>
                                                    </li>
                                                </ul>
                                                <b-button href="#" variant="primary" class="btn_plan">Choose</b-button>
                                            </b-card>
                                        </b-col>
                                        <b-col>
                                            <b-card
                                                    header-bg-variant="primary"
                                                    tag="article"
                                                    style="max-width: 20rem;"
                                                    class="mb-2 card_tariff_year"
                                                    header-align="center">
                                                <p class="card-header type_plan">Silver plan
                                                    <span class="price_plan">$225<span class="period_price">save 20%</span></span>
                                                    <span class="period_price">per year</span>
                                                </p>
                                                <ul class="list-pros">
                                                    <li>
                                                        <span>All in Standart plan</span>
                                                    </li>
                                                    <li>
                                                        <span>Amazon Gift Shop</span>
                                                    </li>
                                                    <li>
                                                        <span>0.5% Commission Form Turnove</span>
                                                    </li>
                                                </ul>
                                                <b-button href="#" variant="primary" class="btn_plan">Choose</b-button>
                                            </b-card>
                                        </b-col>
                                        <b-col>
                                            <b-card
                                                    header-bg-variant="primary"
                                                    tag="article"
                                                    style="max-width: 20rem;"
                                                    class="mb-2 card_tariff_year"
                                                    header-align="center">
                                                <p class="card-header type_plan">Golden plan
                                                    <span class="price_plan">$650<span class="period_price">save 30%</span></span>
                                                    <span class="period_price">per year</span>
                                                </p>
                                                <ul class="list-pros">
                                                    <li>
                                                        <span>All in Silver Plan</span>
                                                    </li>
                                                    <li>
                                                        <span>Send Offers To Influencers-Stars</span>
                                                    </li>
                                                    <li>
                                                        <span>0% Commission Form Turnove</span>
                                                    </li>
                                                </ul>
                                                <b-button href="#" variant="primary" class="btn_plan">Choose</b-button>
                                            </b-card>
                                        </b-col>
                                    </b-row>
                                </b-tab>
                            </b-tabs>

                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};
    export default {
        name: 'TariffPlan',
        data() {
            return {
                header: 'Tariff plan'
            }
        },
        created() {
            vm = this;
        },
        methods: {

        }
    }
</script>