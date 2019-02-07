<template>
    <div id="dashboard">
        <b-row>
            <b-col>
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
                            <div class="text-muted">Channels</div>
                            <strong>{{ influencer.channels.length }}</strong>
                            <div class="text-muted"><i v-for="(channel, index) in influencer.channels" :class="'fa fa-' + channel" style="margin: 0 3px;"></i></div>
                        </li>
                        <li>
                            <div class="text-muted">Users</div>
                            <strong>58637</strong>
                            <div class="text-muted">Auditory</div>
                        </li>
                        <li>
                            <div class="text-muted">All points</div>
                            <strong>18500</strong><small class="text-muted"> (checked)</small><br>
                            <strong>25734</strong><small class="text-muted"> (all)</small>
                        </li>
                        <li>
                            <div class="text-muted">Gifts</div>
                            <strong>{{ influencer.giftsOrdered }}</strong><small class="text-muted"> (ordered)</small><br>
                            <strong>{{ influencer.giftsGot }}</strong><small class="text-muted"> (got)</small>
                        </li>
                    </ul>
                </b-card>
            </b-col>
        </b-row>


        <b-row>
            <b-col lg="8" md="6" sm="12">
                <b-card>

                    <h5>Campaigns<span class="badge text-right float-right badge-primary badge-pill">{{ influencer.campaigns.length }}</span></h5>

                    <ul class="icons-list list-campaigns-dashboard">
                        <li v-for="(campaign, index) in influencer.campaigns">
                            <!--<i class="icon-globe bg-primary"/>-->
                            <div class="desc">
                                <div class="title">{{ campaign.campaign_name }}</div>
                                <small>
                                    <router-link :id="id = campaign.id" :data="campaignTo = campaign" :to="{ name: 'ProfileCampaign', params: { campaign:campaignTo, id: id, tabGifts: true } }">to {{ campaign.campaign_name }} shop</router-link>
                                </small>
                            </div>
                            <div class="value">
                                <div class="small text-muted">Points</div>
                                <strong>{{ campaign.pointsAccepted }}</strong><small> (checked)</small>
                                <strong>{{ campaign.pointsAll }}</strong><small> (all)</small>
                            </div>
                        </li>
                    </ul>
                </b-card>
            </b-col>

            <b-col lg="4" md="6" sm="12">
                <b-card>
                    <div class="gift">
                        <h5 class="text-left">Last gift:</h5>
                        <div class="card-gift-dashboard text-center">
                            <img :src="influencer.lastGift.url" alt="">
                            <h4>{{ influencer.lastGift.gift_name }}</h4>
                            <h6>Price: {{ influencer.lastGift.price }} points</h6>
                        </div>
                    </div>
                </b-card>
            </b-col>
        </b-row>

    </div>
</template>

<script>
    let vm = {};

    export default {
        name: 'InfluencerDashboard',

        data(){
            return {
                influencer: {
                    channels: ['facebook', 'linkedin', 'youtube', 'twitter'],
                    campaigns: [
                        { id: 1, campaign_name: 'Ferero Rosher', pointsAccepted: 372, pointsAll: 483 },
                        { id: 2, campaign_name: 'Wiskas', pointsAccepted: 23, pointsAll: 74 },
                        { id: 3, campaign_name: 'Chappi', pointsAccepted: 852, pointsAll: 1011 },
                        { id: 4, campaign_name: 'Cheese Dorblu', pointsAccepted: 399, pointsAll: 512 },
                        { id: 5, campaign_name: 'Milk "Molochko"', pointsAccepted: 307, pointsAll: 321 },
                    ],
                    lastGift: { id: 1, gift_name: 'Iphone 8', url: 'images/iphone.png', price: 11800 },
                    giftsOrdered: 17,
                    giftsGot: 12,
                }
            }
        }

    }
</script>