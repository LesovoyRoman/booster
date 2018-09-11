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
                                            id="fieldset_assistant_email"
                                            description="">
                                        <label for="assistant_email">Assistant email</label>
                                        <b-form-input id="assistant_email" placeholder="Enter assistant email"  v-model.trim="new_assistant.assistant_email" type="email"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group id="fieldset_assistant_pass">
                                        <b-row>
                                            <b-col>
                                                <label for="assistant_pass">Password</label>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col>
                                                <b-form-input dark v-model="new_assistant.assistant_pass"></b-form-input>
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
        name: 'CreateAssistant',
        data() {
            return {
                header: 'Add assistant',
                new_assistant: {
                    assistant_pass: '',
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
                this.new_assistant.assistant_pass = '';

                for (let i=0; i<length; i++) {
                    let rnum = Math.floor(Math.random() * chars.length);
                    this.new_assistant.assistant_pass += chars.substring(rnum,rnum+1);
                }
            }
        }
    }
</script>