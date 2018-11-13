<template>
    <div class="wrapper" :idGift="computedIdGift">
        <div class="animated fadeIn" v-if="idGift">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }} id {{ idGift }}</h2>
                </b-col>

                <b-col v-if="loading">
                    <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>
                </b-col>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>

                        <form action="" @submit.prevent>

                            <p class="card-text header_card_simple">New gift</p>
                            <b-row>
                                <b-col>
                                    <b-form-group
                                            id="fieldset_gift_name"
                                            description=""
                                    >
                                        <label for="gift_name">Enter gift name<i class="custom_tooltip_label" v-b-tooltip.hover title="'Enter gift name'">?</i></label>
                                        <b-form-input id="gift_name" placeholder="Enter gift name"  v-model.trim="gift.name"></b-form-input>
                                    </b-form-group>
                                </b-col>
                            </b-row>

                            <b-row>
                                <b-col>
                                    <b-form-group id="fieldset_is_main">
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                    type="checkbox"
                                                    id="customCheckboxMainGift"
                                                    name="customCheckboxMainGift"
                                                    class="custom-control-input"
                                                    v-model="gift.is_main"
                                                    :value="true">
                                            <label
                                                    class="custom-control-label"
                                                    for="customCheckboxMainGift">Sign as main<i class="custom_tooltip_label" v-b-tooltip.hover title="'Sign as main'">?</i></label>
                                        </div>
                                    </b-form-group>
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
                                                <b-form-input type="number" v-model="gift.in_stock" id="gift_in_stock"/>
                                            </b-form-group>
                                        </b-col>
                                    </b-row>

                                    <b-row>
                                        <b-col>
                                            <b-form-group>
                                                <label for="gift_instructions">Instruction<i class="custom_tooltip_label" v-b-tooltip.hover title="'Instructions'">?</i></label>
                                                <b-form-textarea id="campaign_instructions"
                                                                 v-model="gift.instructions"
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
                                                <b-form-file @change="onFileChange" v-model="gift.file" id="logoGift" accept="image/*" placeholder="Choose an image..."></b-form-file>
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
                                                @click="updateGift"
                                                type="submit"
                                                class="font500 float-right uppercase"
                                                variant="primary">Update</b-button>
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
        name: 'UpdateGift',
        props: ['idGift'],
        components: {
            Loading
        },
        data(){
            return {
                header: 'Update gift',
                loading: false,
                urlImage: '',
                storage_path: '',

                gift: {
                    name: '',
                    is_main: null,
                    in_stock: 0,
                    id: vm.idGift,
                    //gift_amazonId: 0,
                    file: {},
                    instructions: '',
                },

                type: 'standart',

                //campaigns: [],
                //dataRequst: {fields: ['id', 'name']}
            }
        },
        computed: {
            computedIdGift: function () {
                if (typeof this.idGift === 'undefined') {
                    vm.$router.go(-1)
                }
            },
        },
        methods: {
            onFileChange(e) {
                const file = e.target.files[0];
                this.urlImage = URL.createObjectURL(file);
            },
            updateGift(){
                let formData = new FormData();
                for (let gift_data in this.gift) {
                    if(gift_data == 'file'){
                        formData.append('file', document.getElementById('logoGift').files[0]);
                    } else {
                        formData.append(gift_data, this.gift[gift_data]);
                    }
                }
                this.loading = true;
                axios.post('/updateGift', formData).then(response => {
                    //console.log(response)
                    this.loading = false;
                    if(response.status === 200) {
                        vm.$swal( 'Congratulates:', 'You have updated gift!', 'success')
                    }
                    if(response.status === 206) {
                        console.log(response.data.errors)
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
        created(){
            vm = this;
            this.loading = true;
            this.storage_path = this.$root.storage_path;
            axios.post('/getGiftById', {
                id: this.idGift,
            }).then(response => {
                //console.log(response.data.gift)
                this.loading = false;
                if(response.status === 200 && response.data.gift) {
                    vm.gift = response.data.gift[0];

                    if(response.data.gift[0].images[0] !== null) {
                        vm.urlImage = this.storage_path + '/' + response.data.gift[0].images[0].image_path;
                    }
                }
                if(response.data.errors){
                    vm.$swal('Unfortunately:', response.data.errors, 'error')
                }
            }).catch(err => {
                this.loading = false;
                console.log(err.message)
            })
        },
    }
</script>