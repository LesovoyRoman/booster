<template>
    <div class="wrapper" :idAssistant="computedIdAssistant" id="update_assistant">
        <div class="animated fadeIn"  v-if="idAssistant">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>

                        <b-row v-if="assistant !== []">
                            <b-col>
                                <h3>{{ assistant.name }} ({{ assistant.email }})</h3>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <b-form-group id="fieldset_assistant_access">
                                    <b-row>
                                        <b-col>
                                            <label for="assistant_access">Access to campaigns</label>
                                        </b-col>
                                    </b-row>
                                    <div
                                            style="margin-top: 5px; margin-bottom: 5px;"
                                            v-for="(item, index) in optionsCampaigns"
                                            :key="index"
                                            class="custom-control custom-checkbox custom-control-inline">
                                        <input
                                                :id="'assistant_campaign_checkbox_' + index"
                                                type="checkbox"
                                                autocomplete="off"
                                                class="custom-control-input"
                                                v-model="selectedCampaigns"
                                                :value="item.id" hidden>
                                        <label :for="'assistant_campaign_checkbox_' + index"
                                               :class="selectedCampaigns.includes(item.id) ? 'btn btn-secondary active custom-control-label' : 'btn btn-secondary custom-control-label'">
                                            {{ item.name }}
                                        </label>
                                    </div>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <b-button :variant="'primary'" class="uppercase font12 font500 float-right btn-custom-create-campaign" type="button" @submit.prevent @click="updateAssistant">update</b-button>
                            </b-col>
                        </b-row>
                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    import Loading from 'vue-loading-spinner/src/components/Circle10'
    let vm = {};

    export default {
        name: 'UpdateAssistant',
        props: ['idAssistant'],
        components: {
            Loading
        },
        data() {
            return {
                header: 'UpdateAssistant',
                loading: false,
                assistant: [],

                selectedCampaigns: [],
                optionsCampaigns: [],

                dataRequst: {fields: ['id', 'name']}
            }
        },
        created(){
            vm = this;
            this.loading = true;
            this.storage_path = this.$root.storage_path;
            axios.post('/getAllCampaigns', vm.dataRequst).then(response => {
                if(response.data.campaigns instanceof Array) {
                    this.optionsCampaigns = response.data.campaigns
                }
                if(response.data.errors){
                    vm.$swal('Unfortunately:', response.data.errors, 'error')
                }
            }).catch( err => {
                console.log(err.message)
            });
            axios.post('/getAssistantById', {
                assistant_id: this.idAssistant,
            }).then(response => {
                this.loading = false;
                if(response.status === 200 && response.data.assistant) {
                    vm.assistant = response.data.assistant;
                    if(vm.assistant.campaigns.length > 0){
                        vm.selectedCampaigns = vm.assistant.campaigns.map((item) => { return item.id })
                    }
                }
                if(response.data.errors){
                    vm.$swal('Unfortunately:', response.data.errors, 'error')
                    vm.$router.go(-1);
                }
            }).catch(err => {
                this.loading = false;
                console.log(err.message)
            })
        },
        methods: {
            updateAssistant(){
                this.loading = true;
                axios.post('/syncAssistantCampaigns', {
                    assistant_id: vm.idAssistant,
                    campaign_ids: vm.selectedCampaigns
                }).then(response => {
                    this.loading = false;
                    if(response.status === 200 && !response.data.errors){
                        vm.$swal('Congratulates:', 'Your request successful!', 'success')
                    }
                    if(response.data.errors){
                        vm.$swal('Unfortunately:', response.data.errors, 'error')
                        vm.$router.go(-1);
                    }
                }).catch(err => {
                    this.loading = false;
                    console.log(err);
                })
            }
        },
        computed: {
            computedIdAssistant: function () {
                if (typeof this.idAssistant === 'undefined') {
                    vm.$router.go(-1)
                }
            },
        },
    }

</script>

<style scoped>
    #update_assistant .custom-control-label::before,
    #update_assistant .custom-control-label::after {
        display: none !important;
    }
    #update_assistant .custom-control.custom-checkbox {
        width: 25%;
        min-width: 175px;
        padding-left: 0;
        margin-right: 0;
    }
    #update_assistant .custom-control.custom-checkbox .btn-secondary {
        padding: 6px 15px;
        width: 100%;
    }
</style>