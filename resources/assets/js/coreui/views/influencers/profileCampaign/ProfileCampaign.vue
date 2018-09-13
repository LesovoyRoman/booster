<template>
    <div :campaign="computedProfileCampaign" class="wrapper" id="profileCampaign">
        <div class="animated fadeIn" v-if="campaign">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }} {{ campaign.campaign_name }}</h2>
                </b-col>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>

                        <b-tabs pills card>
                            <b-tab title="Info" active>
                                <p class="card-text header_card_simple">Common information</p>

                                <div class="group-info-custom">
                                    <p class="paragraph_simple">Campaign ends</p>

                                    <span class="span-row">21.09.2019</span>
                                </div>

                                <b-row>
                                    <b-col md="3" lg="3">
                                        <p class="paragraph_simple">Campaign countries</p>
                                        <span class="span-row">Ukraine</span>
                                        <span class="span-row">Russia</span>
                                        <span class="span-row">USA</span>
                                    </b-col>
                                    <b-col md="3" lg="3">
                                        <p class="paragraph_simple">Campaign cities</p>
                                        <span class="span-row">All</span>
                                    </b-col>
                                </b-row>

                                <div class="divider_custom"></div>

                                <p class="card-text header_card_simple">Product for campaign</p>

                                <p class="paragraph_simple">{{ campaign.campaign_name }}</p>

                                <span class="span-row"><a href="#">https://test.com</a></span>

                                <div class="holder-img-profile-campaign">
                                    <img src="~static/img/iphone.png" alt="">
                                </div>

                                <div class="group-info-custom">
                                    <span class="span-row font500">Middle price 250 Rub</span>

                                    <span class="span-row font500">1 point for 1 product</span>
                                </div>

                                <div class="divider_custom"></div>

                                <p class="card-text header_card_simple">Additional information</p>

                                <div class="group-info-custom">
                                    <p class="paragraph_simple">Checking type</p>

                                    <span class="span-row">Input serial number</span>
                                </div>

                                <div class="group-info-custom">
                                    <p class="paragraph_simple">Conditions</p>

                                    <span class="span-row">1 point for 1 product</span>
                                </div>

                                <div class="group-info-custom">
                                    <p class="paragraph_simple">Instructions</p>

                                    <span class="span-row">Lorem ipsum dolor sit amet, consectetur adipisicing elit. At consectetur culpa cumque ducimus earum, explicabo facilis fugiat illum iste itaque neque provident quas, qui recusandae repellat repellendus, sunt suscipit tempora!</span>
                                </div>

                            </b-tab>
                            <b-tab title="Gifts">

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
        name: 'ProfileCampaign',
        props: ['campaign'],
        data(){
            return {
                header: 'Profile of Campaign',

            }
        },
        created(){
            vm = this;
        },
        methods: {

        },
        computed: {
            computedProfileCampaign: function () {
                if (typeof this.campaign === 'undefined') {
                    vm.$router.go(-1)
                }
            },
        }
    }
</script>