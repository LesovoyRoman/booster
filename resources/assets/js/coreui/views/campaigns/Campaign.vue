<template>
    <div :campaign="computedCampaign" class="wrapper">
        <div class="animated fadeIn" v-if="campaign">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }} {{ campaign.campaign_name }}</h2>
                    <b-card>
                        id campaign => {{ campaign.id }}
                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};

    export default {
        props: ['campaign'],
        name: 'Campaign',
        data () {
            return {
                header: 'Campaign'
            }
        },
        mounted() {

        },
        beforeCreate(){
            vm = this;
        },
        computed: {
            computedCampaign: function() {
                if(typeof this.campaign === 'undefined') {
                    vm.$router.push('/campaigns');
                }
            }
        },
    }
</script>