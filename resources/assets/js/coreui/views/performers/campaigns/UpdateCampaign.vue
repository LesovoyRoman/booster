<template>
    <div id="updateCampaign" :idCampaign="computedIdCampaign">
        <div class="animated fadeIn" v-if="idCampaign">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }} id {{ idCampaign }}</h2>
                </b-col>

                <b-col v-if="loading">
                    <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>
                </b-col>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>

                        <form action="" @submit.prevent>
                            <p class="card-text header_card_simple">Common information</p>

                            <b-row>
                                <b-col>
                                    <b-form-group
                                            id="fieldset_name"
                                            description="">
                                        <label for="name">Enter campaign name<i class="custom_tooltip_label" v-b-tooltip.hover title="'Enter campaign name'">?</i></label>
                                        <b-form-input id="name" placeholder="Enter name of campaign" v-model.trim="campaign.name"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group id="fieldset_end_campaign">
                                        <label for="end_campaign">Ending of campaign<i class="custom_tooltip_label" v-b-tooltip.hover title="'Ending of campaign'">?</i></label>
                                        <b-form-select dark v-model="campaign.end_type">
                                            <option :value="'date'">Date</option>
                                            <option :value="'points'">Points</option>
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>

                                <b-col>
                                    <b-form-group v-show="campaign.end_type == 'date'">
                                        <label>Date</label>
                                        <b-form-input v-model="campaign.end_campaign"
                                                      type="date"
                                                      id="date"/>
                                    </b-form-group>
                                    <b-form-group v-show="campaign.end_type == 'points'">
                                        <label>Points</label>
                                        <b-form-input id="end_points" min="100" v-model.trim="campaign.end_points"></b-form-input>
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
                                                    v-model="campaign.allCountries"
                                                    @change="chooseAllCountries"
                                                    :value="true">
                                            <label
                                                    class="custom-control-label"
                                                    for="customCheckboxCountry">All countries</label>
                                        </div>
                                        <b-form-select :disabled="campaign.allCountries" dark v-model="campaign.country">
                                            <option :value="null">Choose from list</option>
                                            <option v-for="country in countries" :value="country.id">{{ country.name }}</option>
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                                <b-col>
                                    <b-form-group id="fieldset_campaignCity">
                                        <label for="campaignCity">Region of Campaign</label>
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                    type="checkbox"
                                                    id="customCheckboxCity"
                                                    name="customCheckboxCity"
                                                    class="custom-control-input"
                                                    v-model="campaign.allCities"
                                                    @click="campaign.city = null"
                                                    :value="true">
                                            <label
                                                    class="custom-control-label"
                                                    for="customCheckboxCity">All regions</label>
                                        </div>
                                        <b-form-select dark :disabled="campaign.allCities" v-model="campaign.city">
                                            <option :value="null">Choose from list</option>
                                            <option v-for="city in cities" :value="city.id" v-if="campaign.country == city.country_id" >{{ city.name }}</option>
                                        </b-form-select>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <div class="divider_custom"></div>

                            <p class="card-text header_card_simple">Product for campaign</p>

                            <b-row>
                                <b-col md="6" lg="6" sm="12" xs="12">
                                    <b-row>
                                        <b-col>
                                            <b-form-group
                                                    id="fieldset_campaign_product_name"
                                                    description=""
                                                    >
                                                <label for="campaign_product_name">Enter your product name<i class="custom_tooltip_label" v-b-tooltip.hover title="'Enter your product name'">?</i></label>
                                                <b-form-input id="campaign_product_name" placeholder="Enter product name"  v-model.trim="campaign.product_name"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col>
                                            <b-form-group
                                                    id="fieldset_campaign_youtube_link"
                                                    description=""
                                                    >
                                                <label for="campaign_youtube_link">Enter YouTube link<i class="custom_tooltip_label" v-b-tooltip.hover title="'Enter YouTube link'">?</i></label>
                                                <b-form-input id="campaign_youtube_link" placeholder="Enter YouTube link"  v-model.trim="campaign.youtube_link"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col>
                                            <b-form-group
                                                    id="fieldset_campaign_products_in_stock"
                                                    description="">
                                                <label for="campaign_products_in_stock">Enter products in stock<i class="custom_tooltip_label" v-b-tooltip.hover title="'Enter products in stock'">?</i></label>
                                                <b-form-input type="number" id="campaign_products_in_stock" placeholder="100" v-model.trim="campaign.products_in_stock"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>


                                    <b-row>
                                        <b-col>
                                            <b-form-group>
                                                <b-row>
                                                    <b-col>
                                                        <label for="productPrice">Middle price<i class="custom_tooltip_label" v-b-tooltip.hover title="'Middle price'">?</i></label>
                                                        <b-form-input id="productPrice" type="number" v-model="campaign.product_price"/>
                                                    </b-col>
                                                    <b-col>
                                                        <label for="campaign_currency">Currency</label>
                                                        <b-form-select id="campaign_currency" dark v-model="campaign.currency">
                                                            <option :value="'RUB'">RUB</option>
                                                            <option :value="'UAH'">UAH</option>
                                                        </b-form-select>
                                                    </b-col>
                                                </b-row>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                </b-col>
                                <b-col md="6" lg="6" sm="12" xs="12">
                                    <b-row>
                                        <b-col>
                                            <b-form-group id="fieldset_photoProduct">
                                                <label for="photoProduct">Photo of product<i class="custom_tooltip_label" v-b-tooltip.hover title="'Photo of product'">?</i></label>
                                                <b-form-file @change="onFileChange" id="logoCampaign" v-model="campaign.file" accept="image/*" placeholder="Choose an image..."></b-form-file>
                                            </b-form-group>

                                        </b-col>
                                    </b-row>
                                    <b-row>
                                        <b-col>
                                            <div id="renderedImageBlock"><img v-if="urlImage" :src="urlImage"></div>
                                        </b-col>
                                    </b-row>
                                </b-col>
                            </b-row>


                           <!-- <b-row>
                                <b-col md="6" lg="6" sm="12" xs="12">
                                    <b-form-group>
                                        <b-row>
                                            <b-col>
                                                <label for="productPrice">Middle price<i class="custom_tooltip_label" v-b-tooltip.hover title="'Middle price'">?</i></label>
                                                <b-form-input id="productPrice" type="number" v-model="campaign.product_price"/>
                                            </b-col>
                                            <b-col>
                                                <label for="campaign_currency">Currency</label>
                                                <b-form-select id="campaign_currency" dark v-model="campaign.currency">
                                                    <option :value="'RUB'">RUB</option>
                                                    <option :value="'UAH'">UAH</option>
                                                </b-form-select>
                                            </b-col>
                                        </b-row>
                                    </b-form-group>
                                </b-col>
                            </b-row>-->

                            <div class="divider_custom"></div>

                            <p class="card-text header_card_simple">Additional information</p>

                            <b-row>
                                <b-col>
                                    <b-form-group>
                                        <label for="campaign_conditions">Conditions<i class="custom_tooltip_label" v-b-tooltip.hover title="'Conditions'">?</i></label>
                                        <b-form-textarea id="campaign_conditions"
                                                         v-model="campaign.conditions"
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
                                                         v-model="campaign.instructions"
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
                                                class="font500 float-right uppercase" @click="updateCampaign"
                                                variant="primary">Save</b-button>
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
    import Loading from 'vue-loading-spinner/src/components/Circle10'
    let vm = {};

    export default {
        name: 'UpdateCampaign',
        props: ['idCampaign'],
        components: {
            Loading
        },
        created(){
            this.storage_path = this.$root.storage_path;
            vm = this;
            this.loading = true;
            axios.post('/getCampaignById', {
                id: this.idCampaign,
            }).then(response => {
                this.loading = false;
                if(response.status === 200) {
                    let response_data = {};
                    if(typeof response.data.campaign[0] !== 'undefined'){
                        response_data = response.data.campaign[0];
                    } else {
                        response_data = response.data.campaign;
                    }
                    vm.campaign = response_data;
                    //console.log(vm.campaign);
                    if(response_data.image !== null) {
                        let image;
                        try {
                            image = JSON.parse(response_data.image)
                            //console.log(image)
                        } catch (e){
                            image = response_data.image
                        }
                        vm.urlImage = this.storage_path + '/' + image.image_path;
                    }
                    if(response_data.end_campaign === '2000-01-01 00:00:00' ||
                        response_data.end_campaign == 'null' || response_data.end_campaign == null) {
                        vm.campaign.end_type = 'points'
                    } else {
                        vm.campaign.end_type = 'date'
                        vm.campaign.end_campaign = response_data.end_campaign.substring(0, 10) // substr need to be cut cuz' input uses only y.m.d (not the particular time)
                    }
                    if(response_data.city === 'all') {
                        vm.campaign.allCities = true;
                    }
                    if(response_data.country === 'all') {
                        vm.campaign.allCountries = true;
                    }
                }
                if (response.status === 206){
                    console.log(response.data.errors)
                }
            }).catch(err => {
                this.loading = false;
                //console.log(err.message)
            })
        },
        data(){
            return {
                storage_path: '',
                header: 'Update campaign',
                loading: false,
                urlImage: null,

                campaign: {

                    name: null,
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
                    youtube_link: '',
                    file: {},
                    currency: 'RUB',
                    product_price: 0.00,
                    product_points: 0,
                    conditions: '',
                    instructions: ''

                },
            }
        },
        computed: {
            computedIdCampaign: function () {
                if (typeof this.idCampaign === 'undefined') {
                    vm.$router.go(-1)
                }
            },
            countries(){
                return vm.$root.countries
            },
            cities(){
                return vm.$root.cities
            }
        },
        methods: {
            chooseAllCountries(){
                vm.campaign.country = null;
                if(vm.campaign.allCountries === true) vm.campaign.allCities = true;
            },
            onFileChange(e) {
                const file = e.target.files[0];
                this.urlImage = URL.createObjectURL(file);
            },
            updateCampaign(){
                this.loading = true;
                let formData = new FormData();
                for (let campaign_data in this.campaign) {
                    if(campaign_data == 'file'){
                        formData.append('file', document.getElementById('logoCampaign').files[0]);
                    } else {
                        formData.append(campaign_data, this.campaign[campaign_data]);
                    }
                }

                //formData.append('data', this.campaign);
                axios.post('/updateCampaign', formData).then(response => {
                    this.loading = false;
                    if(response.status === 200 && !response.data.errors) {
                        vm.$swal( 'Congratulates:', 'You have updated campaign!', 'success')
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
                    this.loading = false;
                    console.log(err.message)
                })
            }
        },
    }
</script>