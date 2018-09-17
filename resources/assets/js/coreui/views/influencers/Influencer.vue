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

                                <b-row  v-for="(channel, index) in influencer.channels" :key="index">
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

                                </b-row>

                            </b-col>
                        </b-row>

                        <div class="divider_custom"></div>

                        <b-row>
                            <b-col>
                                <p class="card-text header_card_simple">Influencer campaigns</p>

                                <span v-for="(campaign, index) in influencerThis.campaigns">

                                    <router-link class="font18" :id="id = index" :data="campaignTo = { 'campaign_name': campaign }" :to="{ name: 'Campaign', params: { campaign:campaignTo, id: id } }">{{ campaign }}</router-link> <span v-if="index !== influencerThis.campaigns.length - 1">, </span>

                                </span>

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
        props: ['influencer'],
        name: 'Influencer',
        data(){
            return {
                header: 'Influencer',

                influencerThis: { campaigns: ['Snacks', 'Cheese', 'Sour milk'] }
            }
        },
        created(){
            vm = this;
            console.log(this.influencer);
        },
        methods: {

        },
        computed: {
            computedInfluencer: function() {
                if(typeof this.influencer === 'undefined') {
                    vm.$router.go(-1)
                }
            },
        },
    }
</script>