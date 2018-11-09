<template>
    <div class="wrapper" id="add_assistant">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>
                        <form action="">
                            <p class="card-text header_card_simple">New collaborator</p>

                            <b-row>
                                <b-col>
                                    <b-form-group
                                            id="fieldset_email"
                                            description="">
                                        <label for="email">Assistant email</label>
                                        <b-form-input id="email" placeholder="Enter assistant email"  v-model.trim="new_assistant.email" type="email"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group id="fieldset_pass">
                                        <b-row>
                                            <b-col>
                                                <label for="pass">Password</label>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col>
                                                <b-form-input dark v-model="new_assistant.password"></b-form-input>
                                            </b-col>
                                            <b-col>
                                                <b-button :variant="'secondary'" class="uppercase font500 float-left btn-custom-create-campaign" @click="generatePass(15)">generate</b-button>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
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
                                    <b-button :variant="'primary'" class="uppercase font12 font500 float-right btn-custom-create-campaign" type="button" @submit.prevent @click="createAssistant">add</b-button>
                                </b-col>
                            </b-row>


                        </form>
                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    import Loading from 'vue-loading-spinner/src/components/Circle8'
    let vm = {};
    const emailValid = (email) => {
        const emailRegex = /^([A-Za-z0-9_\-.])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,4})$/;
        return emailRegex.test(email);
    }

    export default {
        name: 'CreateAssistant',
        data() {
            return {
                loading: false,
                header: 'Add assistant',
                new_assistant: {
                    email: '',
                    password: '',
                },

                errors: [],
                error_email: 'Email is not correct',
                error_password: 'Password must be at least 8 symbols!',

                selectedCampaigns: [],
                optionsCampaigns: [],
                
                dataRequst: {fields: ['id', 'name']}
            }
        },
        components: {
            Loading
        },
        created(){
            vm = this;
            this.loading = true;
            axios.post('/getAllCampaigns', vm.dataRequst).then(response => {
                this.loading = false;
                if(response.data.campaigns instanceof Array) {
                    this.optionsCampaigns = response.data.campaigns
                }
                if(response.data.errors){
                    vm.$swal('Unfortunately:', response.data.errors, 'error')
                }
            }).catch( err => {
                this.loading = false;
                console.log(err.message)
            })
        },
        methods: {
            generatePass(length) {
                let chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZ";
                this.new_assistant.password = '';

                for (let i=0; i<length; i++) {
                    let rnum = Math.floor(Math.random() * chars.length);
                    this.new_assistant.password += chars.substring(rnum,rnum+1);
                }
            },
            validateAssistant(){
                vm.errors = [];
                if(!emailValid(vm.new_assistant.email)){
                    vm.errors.push(vm.error_email)
                }
                if(vm.new_assistant.password.length < 8){
                    vm.errors.push(vm.error_password)
                }
                if(vm.errors.length === 0){
                    return true;
                } else {
                    let count = 0;
                    let strErrors = '';
                    vm.errors.forEach(function(item){
                        count++;
                        strErrors += '<span>' + count + ') ' + item + '</span> ' + '<br>';
                    })
                    vm.$swal( 'There are some problems:', strErrors, 'error')
                    return false;
                }
            },
            createAssistant(){
                if(vm.validateAssistant() === true){
                    vm.loading = true;
                    return axios.post('/createAssistant', {
                        email: vm.new_assistant.email,
                        password: vm.new_assistant.password,
                        campaigns: vm.selectedCampaigns
                    }).then(response => {
                        vm.loading = false;
                        if(response.status === 200) {
                            vm.$swal( 'Congratulates:', response.data.success, 'success')
                        }
                        if(response.data.errors) {
                            let strErrors = '';
                            let count = 0;
                            for(let val in response.data.errors){
                                count++;
                                strErrors += '<span>' + count + ') ' + response.data.errors[val] + '</span> ' + '<br>';
                            }
                            vm.$swal( 'There are some problems:', strErrors, 'error')
                        }
                    }).catch(err => {
                        vm.loading = false;
                        console.log(err)
                    })
                }
            }
        }
    }
</script>

<style scoped>
    #add_assistant .custom-control-label::before,
    #add_assistant .custom-control-label::after {
        display: none !important;
    }
    #add_assistant .custom-control.custom-checkbox {
        width: 25%;
        min-width: 175px;
        padding-left: 0;
        margin-right: 0;
    }
    #add_assistant .custom-control.custom-checkbox .btn-secondary {
        padding: 6px 15px;
        width: 100%;
    }
</style>