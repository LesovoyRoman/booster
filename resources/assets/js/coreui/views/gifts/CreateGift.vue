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
                                                    id="fieldset_gift_points">
                                                <label for="gift_points">Amount of points<i class="custom_tooltip_label" v-b-tooltip.hover title="'Amount of points'">?</i></label>
                                                <b-form-input type="number" v-model="newGift.points" id="amount_points"/>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

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
                                                <b-form-input type="number" v-model="newGift.amazonId" id="gift_amazonId"/>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col>
                                            <b-form-group
                                                    id="fieldset_gift_points">
                                                <label for="gift_points">Amount of points<i class="custom_tooltip_label" v-b-tooltip.hover title="'Amount of points'">?</i></label>
                                                <b-form-input type="number" v-model="newGift.points" id="amount_points"/>
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
                    points: 0,
                    inStock: 0,
                    gift_amazonId: 0,
                    file: {},

                }
            }
        },
        created(){
            vm = this;
        },
    }
</script>