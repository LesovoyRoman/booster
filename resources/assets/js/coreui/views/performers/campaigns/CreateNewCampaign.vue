<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                    <b-card>
                        <form action="">
                            <p class="card-text header_card_simple">Common information</p>

                            <b-row>
                                <b-col>
                                    <b-form-group
                                            id="fieldset_campaign_name"
                                            description=""
                                            :invalid-feedback="invalidFeedback"
                                            :valid-feedback="validFeedback"
                                            :state="state">
                                        <label for="campaign_name">Enter campaign name<i class="custom_tooltip_label" v-b-tooltip.hover title="'Enter campaign name'">?</i></label>
                                        <b-form-input id="campaign_name" placeholder="Enter name of campaign" :state="state" v-model.trim="new_campaign.campaign_name"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                           <!-- <b-row>
                                <b-col>
                                    <b-form-group
                                            id="fieldset_campaign_id"
                                            description=""
                                            :state="state">
                                        <label for="campaign_id">Enter campaign id<i class="custom_tooltip_label" v-b-tooltip.hover title="'Enter campaign id'">?</i></label>
                                        <b-form-input id="campaign_id" placeholder="Enter ID campaign" :state="state" v-model.trim="new_campaign.campaign_id"></b-form-input>
                                    </b-form-group>
                            </b-col>
                        </b-row>-->

                            <b-row>
                                <b-col>
                                <b-form-group id="fieldset_end_campaign">
                                    <label for="end_campaign">Ending of campaign<i class="custom_tooltip_label" v-b-tooltip.hover title="'Ending of campaign'">?</i></label>
                                    <b-form-select dark v-model="new_campaign.end_type">
                                        <option :value="'date'">Date</option>
                                        <option :value="'points'">Points</option>
                                    </b-form-select>
                                    </b-form-group>
                                </b-col>

                                <b-col>
                                    <b-form-group v-show="new_campaign.end_type == 'date'">
                                    <label>Date</label>
                                    <b-form-input v-model="new_campaign.end_campaign"
                                            type="date"
                                            id="date"/>
                                    </b-form-group>
                                    <b-form-group v-show="new_campaign.end_type == 'points'">
                                        <label>Points</label>
                                        <b-form-input id="end_points" min="100" v-model.trim="new_campaign.end_points"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                    <b-col>
                                        <b-form-group id="fieldset_campaignCountry">
                                            <label for="campaignCountry">Country of Campaign<i class="custom_tooltip_label" v-b-tooltip.hover title="'Country of Campaign'">?</i></label>
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
                                        <b-form-group id="fieldset_campaignCity">
                                            <label for="campaignCity">City of Campaign</label>
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
                                                <option :value="'Kharkov'">Kharkov</option>
                                                <option :value="'Moscow'">Moscow</option>
                                                <option :value="'Los Santos'">Los Santos</option>
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
                                            :state="state">
                                        <label for="campaign_product_name">Enter your product name<i class="custom_tooltip_label" v-b-tooltip.hover title="'Enter your product name'">?</i></label>
                                        <b-form-input id="campaign_product_name" placeholder="Enter product name" :state="state" v-model.trim="new_campaign.product_name"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group
                                            id="fieldset_campaign_link_youtube"
                                            description=""
                                            :state="state">
                                        <label for="campaign_link_youtube">Enter YouTube link<i class="custom_tooltip_label" v-b-tooltip.hover title="'Enter YouTube link'">?</i></label>
                                        <b-form-input id="campaign_link_youtube" placeholder="Enter YouTube link" :state="state" v-model.trim="new_campaign.link_youtube"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group id="fieldset_photoProduct">
                                        <label for="photoProduct">Photo of product<i class="custom_tooltip_label" v-b-tooltip.hover title="'Photo of product'">?</i></label>
                                        <b-form-file v-model="new_campaign.file" accept="image/*" placeholder="Choose an image..."></b-form-file>
                                    </b-form-group>

                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group
                                            id="fieldset_campaign_products_in_stock"
                                            description="">
                                        <label for="campaign_products_in_stock">Enter products in stock<i class="custom_tooltip_label" v-b-tooltip.hover title="'Enter products in stock'">?</i></label>
                                        <b-form-input type="number" id="campaign_products_in_stock" placeholder="100" v-model.trim="new_campaign.products_in_stock"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>


                            <b-row>
                                <b-col md="6" lg="6" sm="12" xs="12">
                                    <b-form-group>
                                        <b-row>
                                            <b-col>
                                                <label for="productPrice">Middle price<i class="custom_tooltip_label" v-b-tooltip.hover title="'Middle price'">?</i></label>
                                                <b-form-input id="productPrice" type="number" v-model="new_campaign.product_price"/>
                                            </b-col>
                                            <b-col>
                                                <label for="campaign_currency">Currency</label>
                                                <b-form-select id="campaign_currency" dark v-model="new_campaign.currency">
                                                    <option :value="'RUB'">RUB</option>
                                                    <option :value="'UAH'">UAH</option>
                                                </b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                           <!-- <b-row>
                                <b-col>
                                    <b-form-group
                                            id="fieldset_campaign_points">
                                        <label for="campaign_product_points">Amount of points for one product<i class="custom_tooltip_label" v-b-tooltip.hover title="'Amount of points for one product'">?</i></label>
                                        <b-form-input disabled type="number" v-model="new_campaign.product_points" id="amount_points"/>
                                    </b-form-group>
                                </b-col>
                            </b-row>-->

                            <div class="divider_custom"></div>

                            <p class="card-text header_card_simple">Additional information</p>

                            <b-row>
                                <b-col>
                                    <b-form-group id="fieldset_checkingType">
                                        <b-row>
                                            <b-col>
                                                <label for="checkingType">Checking type<i class="custom_tooltip_label" v-b-tooltip.hover title="'Checking type'">?</i></label>
                                            </b-col>
                                        </b-row>
                                        <b-row>
                                            <b-col>
                                                <b-form-select dark v-model="new_campaign.checking_type">
                                                    <option :value="'Serial number'">Serial number</option>
                                                    <option :value="'Photo'">Photo</option>
                                                </b-form-select>
                                            </b-col>
                                            <b-col v-show="new_campaign.checking_type == 'Serial number'">
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
                                        <label for="campaign_conditions">Conditions<i class="custom_tooltip_label" v-b-tooltip.hover title="'Conditions'">?</i></label>
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
                                        <label for="campaign_instructions">Instructions fo bloggers<i class="custom_tooltip_label" v-b-tooltip.hover title="'Instructions fo bloggers'">?</i></label>
                                        <b-form-textarea id="campaign_instructions"
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
                                        <router-link v-bind:to="'/gifts/create-gift'">Don't forget to create a gift for the campaign</router-link>

                                        <b-button
                                                class="font500 float-right uppercase" @click="createNewCampaign"
                                                variant="primary">Submit</b-button>
                                    </b-form-group>
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
                    end_campaign: null,
                    end_points: 100,
                    end_type: 'points',

                    products_in_stock: 0,
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
        methods: {
            createNewCampaign(){
                console.log(this.new_campaign);
                //return;
                axios.post('/createNewCampaign', this.new_campaign).then(response => {
                    if(response.data.errors) {
                        console.log(response.data.errors)
                    } else {
                        console.log(response.data.response)
                    }
                }).catch(err => {
                    console.log(err);
                })
            }
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