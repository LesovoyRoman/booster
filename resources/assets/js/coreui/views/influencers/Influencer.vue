<template>
    <div class="wrapper" id="influencer" :campaign="computedInfluencer" >
        <div class="animated fadeIn" v-if="influencer">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }} {{ influencer.name }}</h2>
                </b-col>

                <b-col
                        sm="12"
                        md="12">
                    <b-card class="card-info-influencer">
                        <b-row>
                            <b-col md="3" lg="3">
                                <div class="block_logo_user">
                                    <img :src="influencer.photo" alt="" id="logo">
                                </div>
                            </b-col>

                            <b-col md="4" lg="4">
                                <p class="card-text header_card_simple">Common information</p>

                                <span class="span-row font18">Age: <span class="font500">{{ influencer.age }}</span></span>
                                <span class="span-row font18">Topic: <span class="font500">{{ influencer.type }}</span></span>
                                <span class="span-row font18">Native language: <span class="font500">{{ influencer.lang }}</span></span>

                                <span class="span-row font18">Auditory: <span class="font500">{{ influencer.auditory }}</span></span>
                                <span class="span-row font18">Influence: <span class="font500">{{ influencer.influence }}%</span></span>
                            </b-col>

                        </b-row>

                        <div class="divider_custom"></div>

                        <b-row>
                            <b-col>
                                <p class="card-text header_card_simple">Channels</p>

                                <!--<iframe width="560" height="315" src="https://www.youtube.com/embed/ecyF6KStpB8" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>-->

                                <!--<b-row  v-for="(channel, index) in influencer.channels" :key="index">
                                    <b-col>
                                        <div class="channel-block">
                                            <span class="span-row">Channel: <span class="font500">{{ channel }}</span></span>
                                            <span class="span-row">Topic: Journeys</span>
                                            <span class="span-row">Link: <a href="#">https://iamlink.com</a></span>
                                            <span class="span-row">Auditory: 250-500</span>
                                            <span class="span-row">Auditory-age: 20-30</span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="margin-top-15"></div>
                                    </b-col>
                                </b-row>-->

                                <b-row>
                                    <b-col  v-for="(channel, index) in influencer.channels" :key="index"
                                            sm="6"
                                            lg="3">
                                        <div :class="'social-box relative ' + channel">
                                            <i :class="'fa fa-' + channel"/>
                                                <a href="https://iamlink.com" target="_blank">
                                                    <div class="chart-wrapper ">
                                                        <social-box-chart-example
                                                                height="90"/>
                                                    </div>
                                                </a>
                                                <ul>
                                                    <li>
                                                        <strong :class="'color-' + channel">Topic</strong>
                                                        <span>Journeys</span>
                                                    </li>
                                                    <li>
                                                        <strong :class="'color-' + channel">Auditory</strong>
                                                        <span>250-500</span>
                                                    </li>
                                                </ul>
                                            <div class="clearfix"></div>
                                            <strong :class="'color-' + channel">{{ channel }}</strong>
                                        </div>
                                    </b-col>
                                </b-row>

                            </b-col>
                        </b-row>

                        <div class="divider_custom"></div>

                        <b-row>
                            <b-col>
                                <p class="card-text header_card_simple">Influencer campaigns</p>

                                <b-row>
                                    <b-col  v-for="(campaign, index) in influencerThis.campaigns" :key="index"
                                            sm="6"
                                            lg="3">
                                            <div :class="'block_influencer_campaign relative ' + campaign.quality">

                                                <router-link :id="id = index" :data="campaignTo = { 'campaign_name': campaign.name }" :to="{ name: 'Campaign', params: { campaign: campaignTo, id: id } }" class="link_custom_hidden_influencer">
                                                    <div class="inner_block_influener_campaign">
                                                        <div class="card_campaign_influencer_info">
                                                            <span class="name">{{ campaign.name }}</span>
                                                            <img src="~static/img/powerful.png" class="icon-influencer-power" alt="">
                                                            <span class="influence">{{ campaign.influenceMiddle }}%</span>
                                                        </div>
                                                        <social-box-chart-example
                                                               :data="campaign.influence" height="90" class="custom_chart_campaign_influencer">
                                                        </social-box-chart-example>
                                                    </div>
                                                </router-link>
                                            </div>
                                        <!--/.social-box-->
                                    </b-col>
                                </b-row>

                            </b-col>
                        </b-row>
                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let arrPoints = 0;
    let vm = {};
    import SocialBoxChartExample from './../coreComponents/dashboard/SocialBoxChartExample.vue'

    export default {
        props: ['influencer', 'idInfluencer'],
        name: 'Influencer',
        components: {
            SocialBoxChartExample,
        },
        data(){
            return {
                header: 'Influencer',

                influencerThis: {
                    campaigns: [
                        {id: 1, name: 'Snacks', influence: [10, 20, 50, 40, 70, 85, 25, 70], influenceMiddle: 0, quality: '', channel: 'twitter'},
                        {id: 2, name: 'Cheese', influence: [10, 60, 50, 55, 45, 65, 45, 90], influenceMiddle: 0, quality: '', channel: 'vk'},
                        {id: 3, name: 'Sour milk', influence: [70, 60, 70, 75, 85, 85, 70, 80], influenceMiddle: 0, quality: '', channel: 'youtube'},
                        {id: 4, name: 'Pizza', influence: [95, 80, 95, 90, 95, 100, 95, 90], influenceMiddle: 0, quality: '', channel: 'facebook'},
                    ],
                }
            }
        },
        created(){
            vm = this;
            this.countInfluence();
        },
        methods: {
            countInfluence(){
                return this.influencerThis.campaigns.forEach(function(item){
                    arrPoints = 0;
                    let i = 0;
                     item.influence.forEach(function(itemInfluence){
                         arrPoints = arrPoints + itemInfluence;
                         i++;
                    });
                    item.influenceMiddle = arrPoints;
                    item.influenceMiddle = Math.floor(item.influenceMiddle / i);
                    item.influenceMiddle < 50 ? item.quality = 'lowest' : '';
                    item.influenceMiddle >= 50 && item.influenceMiddle < 70 ? item.quality = 'low' : '';
                    item.influenceMiddle >= 70 && item.influenceMiddle < 90 ? item.quality = 'high' : '';
                    item.influenceMiddle >= 90 ? item.quality = 'highest' : '';
                })
            }
        },
        computed: {
            computedInfluencer: function() {
                if(typeof this.idInfluencer === 'undefined') {
                    vm.$router.go(-1)
                }
            },
        },
    }
</script>