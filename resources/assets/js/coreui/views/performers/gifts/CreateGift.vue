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
                        <b-tabs pills card>
                            <b-tab title="Manually
" active>
                                <form action="">

                                    <p class="card-text header_card_simple">Campaign</p>
                                    <b-row>
                                        <b-col>
                                            <b-form-group>
                                                <label>Choose campaign<i class="custom_tooltip_label" v-b-tooltip.hover title="'Choose campaign'">?</i></label>
                                                <b-form-select dark v-model="newGift.current_campaign" :options="campaigns">
                                                    <option :value="null" disabled>Choose the campaign</option>
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

                                    <b-row>
                                        <b-col>
                                            <b-form-group id="fieldset_mainGift">
                                                <div class="custom-control custom-checkbox">
                                                    <input
                                                            type="checkbox"
                                                            id="customCheckboxMainGift"
                                                            name="customCheckboxMainGift"
                                                            class="custom-control-input"
                                                            v-model="newGift.mainGift"
                                                            :value="true">
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
                                                    <b-form-group
                                                            id="fieldset_gift_price">
                                                        <label for="gift_price">Price of gift<i class="custom_tooltip_label" v-b-tooltip.hover title="'Price of gift (counts as RUB)'">?</i></label>
                                                        <b-input-group>

                                                            <b-input-group-prepend>
                                                                <b-form-input min="1" @change="formulaCalculate('standart')" type="number" v-model="newGift.price" :data="priceGiftCurrency" id="amount_price"/>
                                                            </b-input-group-prepend>


                                                            <b-form-select dark v-model="newGift.price_gift_currency" :options="currencies"></b-form-select>

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
                                                            <b-input-group-prepend>
                                                                <b-form-input min="1" @change="formulaCalculate('standart')" type="number" v-model="newGift.price_product" :data="priceProductCurrency" id="amount_price_product"/>
                                                            </b-input-group-prepend>

                                                            <b-form-select dark v-model="newGift.price_product_currency" :options="currencies"></b-form-select>

                                                        </b-input-group>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_price_boost">
                                                        <label for="gift_price_boost">Price of boosting for 1 product<i class="custom_tooltip_label" v-b-tooltip.hover title="'Price of boosting (counts as RUB)'">?</i></label>

                                                        <b-input-group>
                                                            <b-input-group-prepend>
                                                                <b-form-input min="1" @change="formulaCalculate('standart')" type="number" v-model="newGift.price_boost" :data="priceBoostCurrency" id="amount_price_boost"/>
                                                            </b-input-group-prepend>

                                                            <b-form-select dark @change="formulaCalculate('standart')" v-model="newGift.price_boost_currency" :options="currencies">
                                                                <option :value="'%'">% of product</option>
                                                            </b-form-select>

                                                        </b-input-group>
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
                                                        <b-form-input min="1" type="number" @change="formulaCalculate('standart')" v-model="newGift.points_oneProduct" id="amount_points_oneProduct"/>
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
                                            <b-form-group
                                                    id="fieldset_gift_inStock">
                                                <label for="gift_inStock">In stock</label>
                                                <b-form-input type="number" v-model="newGift.inStock" id="gift_inStock"/>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col>
                                            <b-form-group id="fieldset_photoGift">
                                                <label for="photoProduct">Photo of gift<i class="custom_tooltip_label" v-b-tooltip.hover title="'Photo of gift'">?</i></label>
                                                <b-form-file v-model="newGift.file" accept="image/*" placeholder="Choose an image..."></b-form-file>
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

                                    <b-row>
                                        <b-col>
                                            <b-form-group>
                                                <b-button
                                                        type="submit"
                                                        class="font500 float-right uppercase"
                                                        variant="primary">Add</b-button>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </form>


                            </b-tab>
                            <b-tab title="Via Amazon">

                                <form action="">

                                    <p class="card-text header_card_simple">Campaign</p>
                                    <b-row>
                                        <b-col>
                                            <b-form-group>
                                                <label>Choose campaign<i class="custom_tooltip_label" v-b-tooltip.hover title="'Choose campaign'">?</i></label>
                                                <b-form-select dark v-model="newGift.current_campaign" :options="campaigns">
                                                    <option :value="null" disabled>Choose the campaign</option>
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

                                    <b-row>
                                        <b-col>
                                            <b-form-group id="fieldset_mainGift">
                                                <div class="custom-control custom-checkbox">
                                                    <input
                                                            type="checkbox"
                                                            id="customCheckboxMainGift"
                                                            name="customCheckboxMainGift"
                                                            class="custom-control-input"
                                                            v-model="newGift.mainGift"
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

                                                            <b-input-group-prepend>
                                                                <b-form-input min="1" @change="formulaCalculate('standart')" type="number" v-model="newGift.price" :data="priceGiftCurrency" id="amount_price"/>
                                                            </b-input-group-prepend>


                                                                <b-form-select dark v-model="newGift.price_gift_currency" :options="currencies"></b-form-select>

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
                                                            <b-input-group-prepend>
                                                                <b-form-input min="1" @change="formulaCalculate('standart')" type="number" v-model="newGift.price_product" :data="priceProductCurrency" id="amount_price_product"/>
                                                            </b-input-group-prepend>

                                                            <b-form-select dark v-model="newGift.price_product_currency" :options="currencies"></b-form-select>

                                                        </b-input-group>
                                                    </b-form-group>
                                                </b-col>
                                            </b-row>

                                            <b-row>
                                                <b-col>
                                                    <b-form-group
                                                            id="fieldset_gift_price_boost">
                                                        <label for="gift_price_boost">Price of boosting for 1 product<i class="custom_tooltip_label" v-b-tooltip.hover title="'Price of boosting (counts as RUB)'">?</i></label>

                                                        <b-input-group>
                                                            <b-input-group-prepend>
                                                                <b-form-input min="1" @change="formulaCalculate('standart')" type="number" v-model="newGift.price_boost" :data="priceBoostCurrency" id="amount_price_boost"/>
                                                            </b-input-group-prepend>

                                                            <b-form-select dark @change="formulaCalculate('standart')" v-model="newGift.price_boost_currency" :options="currencies">
                                                                <option :value="'%'">% of product</option>
                                                            </b-form-select>

                                                        </b-input-group>
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
                                                        <b-form-input min="1" type="number" @change="formulaCalculate('standart')" v-model="newGift.points_oneProduct" id="amount_points_oneProduct"/>
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
                                                        type="submit"
                                                        class="font500 float-right uppercase"
                                                        variant="primary">Add</b-button>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>
                                </form>

                            </b-tab>
                        </b-tabs>
                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};

    export default {
        name: 'CreateGift',
        data(){
            return {
                header: 'Create gift',

                newGift: {
                    name: '',
                    mainGift: null,
                    points: 1,
                    price: 1,
                    price_product: 1,
                    points_oneProduct: 1,
                    price_boost: 1,
                    inStock: 0,
                    gift_amazonId: 0,
                    amount_products: 1,
                    file: {},
                    price_gift_currency: 'RUB',
                    price_product_currency: 'RUB',
                    price_boost_currency: 'RUB',
                    current_campaign: null
                },

                last_boost_currency: 1,
                last_product_currency: 1,
                last_gift_currency: 1,

                type: 'standart',

                currencies: ['RUB', 'USD', 'EUR'],
                eur_val: 0,
                usd_val: 0,

                campaigns: ['Snacks', 'Cheese']
            }
        },
        created(){
            vm = this;
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
            formulaCalculate(type){
                vm.type = type;
            }
        },
        computed: {
            amountProducts(){
                vm.type !== 'manually' ?
                    vm.newGift.price_boost_currency !== '%' ?
                        vm.newGift.amount_products = Math.ceil(vm.newGift.price / vm.newGift.price_boost)
                        : vm.newGift.amount_products = Math.ceil(vm.newGift.price / ((vm.newGift.price_product  / 100) * vm.newGift.price_boost))
                    : vm.newGift.amount_products = Math.ceil(vm.newGift.points / vm.newGift.points_oneProduct)
            },
            amountPoints(){
                vm.newGift.points = Math.ceil(vm.newGift.amount_products * vm.newGift.points_oneProduct)
            },
            priceProductCurrency(){
                vm.newGift.price_product = Math.round(vm.newGift.price_product / vm.last_product_currency )
                vm.last_product_currency = 1;

                if (vm.newGift.price_product_currency === 'EUR') {
                    vm.newGift.price_product = Math.ceil(vm.newGift.price_product * vm.eur_val)
                    vm.last_product_currency = vm.eur_val;
                } else if (vm.newGift.price_product_currency === 'USD') {
                    vm.newGift.price_product = Math.ceil(vm.newGift.price_product * vm.usd_val)
                    vm.last_product_currency = vm.usd_val;
                }
            },
            priceBoostCurrency(){
                vm.newGift.price_boost = Math.round(vm.newGift.price_boost / vm.last_boost_currency )
                vm.last_boost_currency = 1;

                if (vm.newGift.price_boost_currency === 'EUR') {
                    vm.newGift.price_boost = Math.ceil(vm.newGift.price_boost * vm.eur_val)
                    vm.last_boost_currency = vm.eur_val;
                } else if (vm.newGift.price_boost_currency === 'USD') {
                    vm.newGift.price_boost = Math.ceil(vm.newGift.price_boost * vm.usd_val)
                    vm.last_boost_currency = vm.usd_val;
                }
            },
            priceGiftCurrency (){
                vm.newGift.price = Math.round(vm.newGift.price / vm.last_gift_currency )
                vm.last_gift_currency = 1;

                if (vm.newGift.price_gift_currency === 'EUR') {
                    vm.newGift.price = Math.ceil(vm.newGift.price * vm.eur_val)
                    vm.last_gift_currency = vm.eur_val
                } else if (vm.newGift.price_gift_currency === 'USD') {
                    vm.newGift.price = Math.ceil(vm.newGift.price * vm.usd_val)
                    vm.last_gift_currency = vm.usd_val
                }
            }
        }
    }
</script>