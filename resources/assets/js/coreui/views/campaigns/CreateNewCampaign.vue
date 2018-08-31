<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                    <b-card>
                        <p class="card-text header_card_simple">Common information</p>

                        <b-row>
                            <b-col>
                                <b-form-group
                                        id="fieldset_campaign_name"
                                        description=""
                                        label="Enter your name"
                                        placeholder="Enter name of campaign"
                                        label-for="campaign_name"
                                        :invalid-feedback="invalidFeedback"
                                        :valid-feedback="validFeedback"
                                        :state="state">
                                    <b-form-input id="campaign_name" :state="state" v-model.trim="new_campaign.campaign_name"></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <b-form-group
                                        id="fieldset_campaign_id"
                                        description=""
                                        label="Enter campaign id"
                                        placeholder="Enter ID campaign"
                                        label-for="campaign_id"
                                        :state="state">
                                    <b-form-input id="campaign_id" :state="state" v-model.trim="new_campaign.campaign_id"></b-form-input>
                                </b-form-group>
                        </b-col>
                    </b-row>

                        <b-row>
                            <b-col>
                            <b-form-group>
                                <label>Ending of campaign</label>
                                <b-form-select dark>
                                    <option :value="'date'">Date</option>
                                    <option :value="'goal'">Goal</option>
                                </b-form-select>
                                </b-form-group>
                            </b-col>

                            <b-col>
                                <b-form-group>
                                <label>Date</label>
                                <b-form-input
                                        type="date"
                                        id="date"/>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                                <b-col>
                                    <b-form-group>
                                        <label>Country of Campaign</label>
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                    type="checkbox"
                                                    id="customCheckboxCountry"
                                                    name="customCheckboxCountry"
                                                    class="custom-control-input"
                                                    v-model="new_campaign.allCountries"
                                                    :value="true">
                                            <label
                                                    class="custom-control-label"
                                                    for="customCheckboxCountry">All countries</label>
                                        </div>
                                        <b-form-select :disabled="new_campaign.allCountries" dark v-model="new_campaign.country">
                                            <option :value="null">Choose from list</option>
                                            <option :value="'Ukraine'">Ukraine</option>
                                            <option :value="'Russia'">Russia</option>
                                            <option :value="'USA'">USA</option>
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group>
                                        <label>City</label>
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                    type="checkbox"
                                                    id="customCheckboxCity"
                                                    name="customCheckboxCity"
                                                    class="custom-control-input"
                                                    v-model="new_campaign.allCities"
                                                    :value="true">
                                            <label
                                                    class="custom-control-label"
                                                    for="customCheckboxCity">All cities</label>
                                        </div>
                                        <b-form-select dark :disabled="new_campaign.allCities" v-model="new_campaign.city">
                                            <option :value="null">Choose from list</option>
                                            <option :value="'Kharkov'">Ukraine</option>
                                            <option :value="'Moscow'">Russia</option>
                                            <option :value="'Los Santos'">USA</option>
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                        </b-row>

                        <div class="divider_custom"></div>

                        <p class="card-text header_card_simple">Product for campaign</p>

                        <b-row>
                            <b-col>
                                <b-form-group
                                        id="fieldset_campaign_product_name"
                                        description=""
                                        label="Enter your product name"
                                        placeholder="Enter product name"
                                        label-for="campaign_product_name"
                                        :state="state">
                                    <b-form-input id="campaign_product_name" :state="state" v-model.trim="new_campaign.product_name"></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <b-form-group
                                        id="fieldset_campaign_link_youtube"
                                        description=""
                                        label="Enter YouTube link"
                                        label-for="campaign_link_youtube"
                                        placeholder="Enter YouTube link"
                                        :state="state">
                                    <b-form-input id="campaign_link_youtube" :state="state" v-model.trim="new_campaign.link_youtube"></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <b-form-group>
                                    <label>Photo of product</label>
                                    <b-form-file v-model="new_campaign.file" accept="image/*" placeholder="Choose an image..."></b-form-file>
                                </b-form-group>

                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col md="6" lg="6" sm="12" xs="12">
                                <b-form-group>
                                    <b-row>
                                        <b-col>
                                            <label>Middle price</label>
                                            <b-form-input type="number" v-model="new_campaign.product_price" id="product_price"/>
                                        </b-col>
                                        <b-col>
                                            <label>Currency</label>
                                            <b-form-select dark v-model="new_campaign.currency">
                                                <option :value="'RUB'">RUB</option>
                                                <option :value="'UAH'">UAH</option>
                                            </b-form-select>
                                        </b-col>
                                    </b-row>
                                </b-form-group>
                            </b-col>
                        </b-row>
                        
                        <b-row>
                            <b-col>
                                <b-form-group
                                        id="fieldset_campaign_points"
                                        label="Amount of points for one product"
                                        label-for="campaign_product_points">
                                    <b-form-input type="number" v-model="new_campaign.product_points" id="amount_points"/>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <div class="divider_custom"></div>

                        <p class="card-text header_card_simple">Additional information</p>

                        <b-row>
                            <b-col>
                                <b-form-group>
                                    <b-row>
                                        <b-col>
                                            <label>Checking type</label>
                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col>
                                            <b-form-select dark v-model="new_campaign.checking_type">
                                                <option :value="'Serial number'">Serial number</option>
                                                <option :value="'Photo'">Ukraine</option>
                                            </b-form-select>
                                        </b-col>
                                        <b-col>
                                            <b-button :variant="'secondary'" class="uppercase font500 float-left btn-custom-create-campaign">generate</b-button>
                                            <b-button :variant="'secondary'" class="uppercase font500 float-right btn-custom-create-campaign">import</b-button>
                                        </b-col>
                                    </b-row>


                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <b-form-group>
                                    <b-form-textarea id="campaign_conditions"
                                                     v-model="new_campaign.conditions"
                                                     placeholder="Enter conditions of campaign"
                                                     :rows="5"
                                                     :max-rows="50">
                                    </b-form-textarea>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <b-form-group>
                                    <b-form-textarea id="campaign_conditions"
                                                     v-model="new_campaign.instructions"
                                                     placeholder="Enter instruction for bloggers"
                                                     :rows="5"
                                                     :max-rows="50">
                                    </b-form-textarea>
                                </b-form-group>
                            </b-col>
                        </b-row>

                        <b-row>
                            <b-col>
                                <b-form-group>
                                    <b-button
                                            type="submit"
                                            class="font500 float-right uppercase"
                                            variant="primary">Submit</b-button>
                                </b-form-group>
                            </b-col>
                        </b-row>

                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'AddNewCampaign',
        data() {
            return {
                header: 'Create new campaign',

                new_campaign: {
                    campaign_name: '',
                    campaign_id: '',
                    country: null,
                    city: null,
                    allCountries: false,
                    allCities: false,

                    product_name: '',
                    link_youtube: '',
                    file: {},
                    product_price: 0.00,
                    currency: 'RUB',
                    product_points: 0,

                    checking_type: 'Serial number',
                    conditions: '',
                    instructions: ''


                }
            }
        },
        created() {

        },
        computed: {
            state () {
               // return this.new_campaign.campaign_name.length >= 4 ? true : false
            },
            invalidFeedback () {
                if (this.new_campaign.campaign_name.length > 4) {
                    return ''
                } else if (this.new_campaign.campaign_name.length > 0) {
                    return 'Enter at least 4 characters'
                } else {
                    return 'Please enter something'
                }
            },
            validFeedback () {
                return this.state === true ? 'Thank you' : ''
            }
        },
    }
</script>