<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2" id="createGiftHeader">{{ header }}</h2>
                </b-col>

                <b-col v-if="loading">
                    <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>
                </b-col>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>
                        <b-tabs pills card>
                            <b-tab title="Manually
" active>
                                <form action="" @submit.prevent>

                                    <p class="card-text header_card_simple">Campaign</p>
                                    <b-row v-if="!idCampaign">
                                        <b-col>
                                            <b-form-group>
                                                <label>Choose campaign<i class="custom_tooltip_label" v-b-tooltip.hover title="'Choose campaign'">?</i></label>
                                                <b-form-select v-if="!idCampaign" dark v-model="newGift.current_campaign">
                                                    <option :value="null" disabled>Choose the campaign</option>
                                                    <option v-for="(campaign, index) in campaigns" :value="campaign.id">{{ campaign.name }}</option>
                                                </b-form-select>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <p class="card-text header_card_simple">New gift</p>
                                    <b-row>
                                        <b-col>
                                            <b-form-group
                                                    id="fieldset_gift_name"
                                                    description=""
                                                    >
                                                <label for="gift_name">Enter gift name<i class="custom_tooltip_label" v-b-tooltip.hover title="'Enter gift name'">?</i></label>
                                                <b-form-input id="gift_name" placeholder="Enter gift name"  v-model.trim="newGift.name"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row v-if="!idCampaign">
                                        <b-col>
                                            <b-form-group id="fieldset_is_main">
                                                <div class="custom-control custom-checkbox">
                                                    <input
                                                            type="checkbox"
                                                            id="customCheckboxMainGift"
                                                            name="customCheckboxMainGift"
                                                            class="custom-control-input"
                                                            v-model="newGift.is_main"
                                                            :value="1">
                                                    <label
                                                            class="custom-control-label"
                                                            for="customCheckboxMainGift">Sign as main<i class="custom_tooltip_label" v-b-tooltip.hover title="'Sign as main'">?</i></label>
                                                </div>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>




                                    <div class="divider_custom"></div>

                                    <p class="card-text header_card_simple">Calculating the price</p>

                                    <b-row>

                                        <b-col md="4" lg="4">

                                            <b-row>
                                                <b-col>
                                                    <b-form-group>
                                                        <label>Currency</label>
                                                        <b-input-group>
                                                            <b-form-select dark v-model="newGift.currency" :options="currencies"></b-form-select>
                                                        </b-input-group>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_price">
                                                        <label for="gift_price">Price of gift<i class="custom_tooltip_label" v-b-tooltip.hover title="'Price of gift (counts as RUB)'">?</i></label>
                                                        <b-input-group>

                                                            <b-input-group>
                                                                <b-form-input min="1" @change="formulaCalculate('standart')" type="number" v-model="newGift.price"  id="amount_price"/>
                                                            </b-input-group>




                                                        </b-input-group>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_price_product">
                                                        <label for="gift_price_product">Price for 1 product<i class="custom_tooltip_label" v-b-tooltip.hover title="'Price of product (counts as RUB)'">?</i></label>

                                                        <b-input-group>
                                                            <b-input-group>
                                                                <b-form-input min="1" @change="formulaCalculate('standart')" type="number" v-model="newGift.price_product" id="amount_price_product"/>
                                                            </b-input-group>


                                                        </b-input-group>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_price_boost">
                                                        <label for="gift_price_boost">Price of boosting for 1 product<i class="custom_tooltip_label" v-b-tooltip.hover title="'Price of boosting (counts as RUB)'">?</i></label>

                                                        <b-row>
                                                            <b-col>
                                                                <b-input-group>
                                                                    <b-input-group>
                                                                        <b-form-input min="1" @change="formulaCalculate('standart')" type="number" v-model="newGift.price_boost" id="amount_price_boost"/>
                                                                    </b-input-group>
                                                                </b-input-group>
                                                            </b-col>
                                                            <b-col>
                                                                <b-input-group>

                                                                    <b-input-group>
                                                                        <b-form-select dark @change="formulaCalculate('standart')" v-model="newGift.type_boosting">
                                                                            <option :value="newGift.currency">{{ newGift.currency }}</option>
                                                                            <option :value="'%'">% of product</option>
                                                                        </b-form-select>
                                                                    </b-input-group>

                                                                </b-input-group>
                                                            </b-col>
                                                        </b-row>

                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                        </b-col>

                                        <b-col md="4" lg="4">

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_points_oneProduct">
                                                        <label for="gift_points_oneProduct">Points for 1 product<i class="custom_tooltip_label" v-b-tooltip.hover title="'Points for 1 product'">?</i></label>
                                                        <b-form-input disabled type="number" @change="formulaCalculate('standart')" v-model="newGift.points_oneProduct" id="amount_points_oneProduct"/>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_amount_products">
                                                        <label for="gift_amount_products">Products should be sold<i class="custom_tooltip_label" v-b-tooltip.hover title="'Products should be sold'">?</i></label>
                                                        <b-form-input min="1" disabled type="number" :data="amountProducts" v-model="newGift.amount_products" id="amount_poducts"/>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_points">
                                                        <label for="gift_points">Amount of points<i class="custom_tooltip_label" v-b-tooltip.hover title="'Amount of points'">?</i></label>
                                                        <b-form-input min="1" type="number" :data="amountPoints" @change="formulaCalculate('manually')" v-model="newGift.points" id="amount_points"/>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                        </b-col>

                                        <b-col md="4" lg="4">
                                            <h4>Results:</h4>

                                            <span>To get a gift: <span class="font24 font500">{{ newGift.points }}</span> points</span>
                                            <br>
                                            <span>Price of 1 point: <span class="font500 font24">{{ newGift.points_oneProduct }}</span></span>
                                        </b-col>

                                    </b-row>

                                    <div class="divider_custom"></div>


                                    <b-row>
                                        <b-col md="6" lg="6" xs="12" sm="12">
                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_in_stock">
                                                        <label for="gift_in_stock">In stock</label>
                                                        <b-form-input type="number" v-model="newGift.in_stock" id="gift_in_stock"/>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>
                                                    <b-form-group>
                                                        <label for="newGift_instructions">Instruction<i class="custom_tooltip_label" v-b-tooltip.hover title="'Instructions'">?</i></label>
                                                        <b-form-textarea id="campaign_instructions"
                                                                         v-model="newGift.instructions"
                                                                         placeholder="Enter instruction how to get a gift"
                                                                         :rows="5"
                                                                         :max-rows="50">
                                                        </b-form-textarea>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>
                                        </b-col>


                                        <b-col md="6" lg="6" xs="12" sm="12">

                                            <b-row>
                                                <b-col>
                                                    <b-form-group id="fieldset_photoGift">
                                                        <label for="photoProduct">Photo of gift<i class="custom_tooltip_label" v-b-tooltip.hover title="'Photo of gift'">?</i></label>
                                                        <b-form-file @change="onFileChange" v-model="newGift.file" id="logoGift" accept="image/*" placeholder="Choose an image..."></b-form-file>
                                                    </b-form-group>

                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>
                                                    <b-form-group>
                                                    <div id="renderedImageBlock"><img v-if="urlImage" :src="urlImage"></div>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                        </b-col>
                                    </b-row>


                                    <b-row>
                                        <b-col>
                                            <b-form-group>
                                                <b-button
                                                        @click="createGift"
                                                        @submit.prevent
                                                        type="button"
                                                        class="font500 float-right uppercase"
                                                        variant="primary">Add</b-button>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </form>

                            </b-tab>




                            <b-tab title="Via Amazon">

                                <form action="" @submit.prevent>

                                    <p class="card-text header_card_simple">Campaign</p>
                                    <b-row v-if="!idCampaign">
                                        <b-col>
                                            <b-form-group>
                                                <label>Choose campaign<i class="custom_tooltip_label" v-b-tooltip.hover title="'Choose campaign'">?</i></label>
                                                <b-form-select v-if="!idCampaign" dark v-model="newGift.current_campaign">
                                                    <option :value="null" disabled>Choose the campaign</option>
                                                    <option v-for="(campaign, index) in campaigns" :value="campaign.id">{{ campaign.name }}</option>
                                                </b-form-select>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col>
                                            <b-form-group>
                                                <b-button style="padding-bottom: 7px"
                                                        type="button"
                                                        class="font500 float-left uppercase"
                                                        variant="primary">Synchronize with Amazon</b-button>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <p class="card-text header_card_simple">New gift</p>
                                    <b-row>
                                        <b-col>
                                            <b-form-group
                                                    id="fieldset_gift_name"
                                                    description=""
                                            >
                                                <label for="gift_name">Enter gift name<i class="custom_tooltip_label" v-b-tooltip.hover title="'Enter gift name'">?</i></label>
                                                <b-form-input id="gift_name" placeholder="Enter gift name"  v-model.trim="newGift.name"></b-form-input>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row v-if="!idCampaign">
                                        <b-col>
                                            <b-form-group id="fieldset_is_main">
                                                <div class="custom-control custom-checkbox">
                                                    <input
                                                            type="checkbox"
                                                            id="customCheckboxMainGift"
                                                            name="customCheckboxMainGift"
                                                            class="custom-control-input"
                                                            v-model="newGift.is_main"
                                                            :value="true">
                                                    <label
                                                            class="custom-control-label"
                                                            for="customCheckboxMainGift">Sign as main<i class="custom_tooltip_label" v-b-tooltip.hover title="'Sign as main'">?</i></label>
                                                </div>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col>
                                            <b-form-group
                                                    id="fieldset_gift_amazonId">
                                                <label for="gift_points">ID of gift in Amazon<i class="custom_tooltip_label" v-b-tooltip.hover title="'ID Amazon'">?</i></label>
                                                <b-form-input type="number" v-model="newGift.gift_amazonId" id="gift_amazonId"/>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <div class="divider_custom"></div>

                                    <p class="card-text header_card_simple">Calculating the price</p>

                                    <b-row>

                                        <b-col md="4" lg="4">

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_price">
                                                        <label for="gift_price">Price of gift<i class="custom_tooltip_label" v-b-tooltip.hover title="'Price of gift (counts as RUB)'">?</i></label>
                                                        <b-input-group>

                                                            <b-input-group>
                                                                <b-form-input min="1" @change="formulaCalculate('standart')" type="number" v-model="newGift.price" id="amount_price"/>
                                                            </b-input-group>

                                                        </b-input-group>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_price_product">
                                                        <label for="gift_price_product">Price for 1 product<i class="custom_tooltip_label" v-b-tooltip.hover title="'Price of product (counts as RUB)'">?</i></label>

                                                        <b-input-group>
                                                            <b-input-group>
                                                                <b-form-input min="1" @change="formulaCalculate('standart')" type="number" v-model="newGift.price_product"  id="amount_price_product"/>
                                                            </b-input-group>


                                                        </b-input-group>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_price_boost">
                                                        <label for="gift_price_boost">Price of boosting for 1 product<i class="custom_tooltip_label" v-b-tooltip.hover title="'Price of boosting (counts as RUB)'">?</i></label>

                                                        <b-row>
                                                            <b-col>
                                                                <b-input-group>
                                                                    <b-input-group>
                                                                        <b-form-input min="1" @change="formulaCalculate('standart')" type="number" v-model="newGift.price_boost" id="amount_price_boost"/>
                                                                    </b-input-group>
                                                                </b-input-group>
                                                            </b-col>
                                                            <b-col>
                                                                <b-input-group>

                                                                    <b-input-group>
                                                                        <b-form-select dark @change="formulaCalculate('standart')" v-model="newGift.type_boosting">
                                                                            <option :value="newGift.currency">{{ newGift.currency }}</option>
                                                                            <option :value="'%'">% of product</option>
                                                                        </b-form-select>
                                                                    </b-input-group>

                                                                </b-input-group>
                                                            </b-col>
                                                        </b-row>

                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                        </b-col>

                                        <b-col md="4" lg="4">

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_points_oneProduct">
                                                        <label for="gift_points_oneProduct">Points for 1 product<i class="custom_tooltip_label" v-b-tooltip.hover title="'Price for 1 product'">?</i></label>
                                                        <b-form-input disabled type="number" @change="formulaCalculate('standart')" v-model="newGift.points_oneProduct" id="amount_points_oneProduct"/>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_amount_products">
                                                        <label for="gift_amount_products">Products should be sold<i class="custom_tooltip_label" v-b-tooltip.hover title="'Products should be sold'">?</i></label>
                                                        <b-form-input min="1" disabled type="number" :data="amountProducts" v-model="newGift.amount_products" id="amount_poducts"/>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_points">
                                                        <label for="gift_points">Amount of points<i class="custom_tooltip_label" v-b-tooltip.hover title="'Amount of points'">?</i></label>
                                                        <b-form-input min="1" type="number" :data="amountPoints" @change="formulaCalculate('manually')" v-model="newGift.points" id="amount_points"/>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                        </b-col>

                                        <b-col md="4" lg="4">
                                            <h4>Results:</h4>

                                            <span>To get a gift: <span class="font24 font500">{{ newGift.points }}</span> points</span>
                                            <br>
                                            <span>Price of 1 point: <span class="font500 font24">{{ newGift.points_oneProduct }}</span></span>
                                        </b-col>

                                    </b-row>

                                    <div class="divider_custom"></div>

                                    <b-row>
                                        <b-col>
                                            <b-form-group>
                                                <label for="newGift_instructions">Instruction<i class="custom_tooltip_label" v-b-tooltip.hover title="'Instructions'">?</i></label>
                                                <b-form-textarea id="campaign_instructions"
                                                                 v-model="newGift.instructions"
                                                                 placeholder="Enter instruction how to get a gift"
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
                                                        @click="createGift"
                                                        type="submit"
                                                        class="font500 float-right uppercase"
                                                        variant="primary">Add</b-button>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </form>

                            </b-tab>

                            <b-tab title="via AliExpress">

                            </b-tab>
                        </b-tabs>
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
        name: 'CreateGift',
        props: ['idCampaign'],
        components: {
            Loading
        },
        data(){
            return {
                header: 'Create gift',
                loading: false,
                urlImage: '',

                newGift: {
                    name: '',
                    is_main: 0,
                    points: 1,
                    price: 1,
                    price_product: 1,
                    points_oneProduct: 1,
                    price_boost: 1,
                    in_stock: 0,
                    gift_amazonId: 0,
                    amount_products: 1,
                    file: {},
                    type_boosting: 'RUB',
                    current_campaign: null,
                    instructions: '',
                    currency: 'RUB',
                },

                type: 'standart',

                currencies: ['RUB', 'USD', 'EUR'],
                eur_val: 0,
                usd_val: 0,

                campaigns: [],
                dataRequst: {fields: ['id', 'name']}
            }
        },
        created(){
            if(this.idCampaign) {
                this.newGift.current_campaign = this.idCampaign;
                this.newGift.is_main = 1;
                //console.log('gift' + this.newGift.current_campaign)
            }
            vm = this;
            this.loading = true;
            axios.post('/getAllCampaigns', vm.dataRequst).then(response => {
                this.loading = false;
                if(response.data.campaigns instanceof Array) {
                    // from DB
                    //console.log('campaigns id, name from DB');
                    this.campaigns = response.data.campaigns
                } else {
                    // from Redis
                    //console.log('campaigns id, name from Redis');
                    this.campaigns = JSON.parse(response.data.campaigns);
                }
                //console.log(response.data.campaigns);
            }).catch( err => {
                this.loading = false;
                this.loading = false;
                console.log(err.message)
            })
        },
        beforeCreate(){
            $.ajax({
                url: 'https://free.currencyconverterapi.com/api/v4/convert?q=EUR_INR&compact=ultra',
                dataType: 'jsonp',
                success: function(data) {
                    vm.eur_val = data.EUR_INR;
                }
            })
            $.ajax({
                url: 'https://free.currencyconverterapi.com/api/v4/convert?q=USD_INR&compact=ultra',
                dataType: 'jsonp',
                success: function(data) {
                    vm.usd_val = data.USD_INR;
                }
            })
        },
        methods: {
            onFileChange(e) {
                const file = e.target.files[0];
                this.urlImage = URL.createObjectURL(file);
            },
            formulaCalculate(type){
                vm.type = type;
            },
            scrollToTop(){
                return window.scrollTo(0,0)
            },
            createGift(){
                //console.log(this.newGift);
                let formData = new FormData();
                for (let gift_data in this.newGift) {
                    if(gift_data == 'file'){
                        formData.append('file', document.getElementById('logoGift').files[0]);
                    } else {
                        formData.append(gift_data, this.newGift[gift_data]);
                    }
                }
                this.loading = true;
                axios.post('/createNewGift', formData).then(response => {
                    this.loading = false;
                    if(response.data.errors) {
                        let strErrors = '';
                        let count = 0;
                        for(let val in response.data.errors){
                            count++;
                            strErrors += '<span>' + count + ') ' + response.data.errors[val] + '</span> ' + '<br>';
                        }
                        vm.$swal( 'There are some problems:', strErrors, 'error')
                        console.log(response.data.errors)
                    } else {
                        if(response.status === 200) {
                            if(this.idCampaign) {
                                vm.$swal({
                                    title: 'Congratulates, you made it:',
                                    html: `
                                <div id="steps_create_campaign">
                                    <ul class="steps success">
                                        <li class="success">Step 1. Create Campaign</li>
                                        <li class="success">Step 2. Create Gift</li>
                                    </ul>
                                </div>`,
                                    type: 'success',
                                    confirmButtonText: 'Add more',
                                    showCancelButton: true,
                                    cancelButtonText: 'To campaigns',
                                }).then((result) => {
                                    if(result.value) {
                                        vm.newGift = {
                                            name: '',
                                            points: 1,
                                            price: 1,
                                            is_main: 0,
                                            price_product: 1,
                                            points_oneProduct: 1,
                                            price_boost: 1,
                                            in_stock: 0,
                                            gift_amazonId: 0,
                                            amount_products: 1,
                                            file: {},
                                            type_boosting: 'RUB',
                                            instructions: '',
                                            currency: 'RUB',
                                            current_campaign: vm.idCampaign
                                        };
                                    } else if (result.dismiss === vm.$swal.DismissReason.cancel) {
                                        vm.$router.push({name: 'MyCampaigns'})
                                    }
                                }).then(function () {
                                    setTimeout(function () {
                                        vm.scrollToTop()
                                    }, 500)
                                })
                            } else {
                                vm.$swal({
                                    title: 'Congratules:',
                                    text: 'You have created gift!',
                                    type: 'success',
                                    confirmButtonText: 'To gifts!'
                                }).then(() => {
                                    vm.$router.push({name: 'GiftsList'})
                                })
                            }

                        } else if (response.status === 206){
                            console.log(response.data.errors)
                        }
                    }
                }).catch(err => {
                    this.loading = false;
                    console.log(err);
                })
            }
        },
        computed: {
            amountProducts(){
                vm.type !== 'manually' ?
                    vm.newGift.type_boosting !== '%' ?
                        vm.newGift.amount_products = Math.ceil(vm.newGift.price / vm.newGift.price_boost)
                        : vm.newGift.amount_products = Math.ceil(vm.newGift.price / ((vm.newGift.price_product  / 100) * vm.newGift.price_boost))
                    : vm.newGift.amount_products = Math.ceil(vm.newGift.points / vm.newGift.points_oneProduct)
            },
            amountPoints(){
                vm.newGift.points = Math.ceil(vm.newGift.amount_products * vm.newGift.points_oneProduct)
            },
        }
    }
</script>