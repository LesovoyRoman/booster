<template>
    <div class="wrapper" :feedback="computedFeedback">
        <div class="animated fadeIn" v-if="feedback">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}  {{ feedback.campaign_name }}</h2>
                    <b-card>
                        id feedback => {{ feedback.id }}
                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};

    export default {
        props: ['feedback'],
        name: 'Feedback',
        data () {
            return {
                header: 'Feedback'
            }
        },
        beforeCreate(){
            vm = this;
        },
        computed: {
            computedFeedback: function() {
                if(typeof this.feedback === 'undefined') {
                    vm.$router.push('/campaigns/feedbacks/all-feedbacks');
                }
            }
        },
    }
</script>