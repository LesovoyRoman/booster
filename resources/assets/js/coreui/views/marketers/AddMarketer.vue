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
                    <b-card>
                        <form action="">
                            <p class="card-text header_card_simple">New collaborator</p>

                            <b-row>
                                <b-col>
                                    <b-form-group
                                            id="fieldset_marketer_email"
                                            description="">
                                        <label for="marketer_email">Marketer email</label>
                                        <b-form-input id="marketer_email" placeholder="Enter marketer email"  v-model.trim="new_marketer.marketer_email" type="email"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group id="fieldset_marketer_pass">
                                        <b-row>
                                            <b-col>
                                                <label for="marketer_pass">Password</label>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col>
                                                <b-form-input dark v-model="new_marketer.marketer_pass"></b-form-input>
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
                                    <b-form-group id="fieldset_marketer_access">
                                        <b-row>
                                            <b-col>
                                                <label for="marketer_access">Access to campaigns</label>
                                            </b-col>
                                        </b-row>
                                        <b-form-checkbox-group button-variant="secondary" buttons v-model="selectedCampaigns" name="btnsCampaigns" :options="optionsCampaigns">
                                        </b-form-checkbox-group>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-button :variant="'primary'" class="uppercase font12 font500 float-right btn-custom-create-campaign" type="submit">add</b-button>
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
    export default {
        name: 'CreateMarketer',
        data() {
            return {
                header: 'Add marketer',
                new_marketer: {
                    marketer_pass: '',
                },

                selectedCampaigns: [],
                optionsCampaigns: [
                    {text: 'Snacks', value: 'snacks'},
                    {text: 'Cheese', value: 'cheese'},
                    {text: 'Pineapple', value: 'pineapple'},
                    {text: 'Grape', value: 'grape'}
                ]
            }
        },
        created() {

        },
        methods: {
            generatePass(length) {
                let chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZ";
                this.new_marketer.marketer_pass = '';

                for (let i=0; i<length; i++) {
                    let rnum = Math.floor(Math.random() * chars.length);
                    this.new_marketer.marketer_pass += chars.substring(rnum,rnum+1);
                }
            }
        }
    }
</script>