<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12"
                       md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>

                <keep-alive>
                    <b-col>

                            <b-col
                                    sm="12"
                                    md="12">
                                <b-card>

                                <b-form-group>
                                    <b-input-group>
                                        <b-input-group-prepend>
                                            <b-form-select dark v-model="sortBy" v-if="checkedBonuses">
                                                <option :value="'accepted'">Accepted</option>
                                                <option :value="'declined'">Declined</option>
                                            </b-form-select>
                                        </b-input-group-prepend>
                                        <b-input-group-prepend>
                                            <b-form-select dark v-model="campaign_name" :options="optionsUniqueCampaign_name">
                                                <option slot="first" :value="null">All campaigns</option>
                                            </b-form-select>
                                        </b-input-group-prepend>
                                        <b-input-group-prepend>
                                            <b-form-select dark v-model="influencer_name_sort" :options="optionsUniqueNames">
                                                <option slot="first" :value="null">All influencers</option>
                                            </b-form-select>
                                        </b-input-group-prepend>
                                        <b-input-group-prepend>
                                            <b-form-select v-model="directionDate">
                                                <option slot="first" :value="'desc'">Date: New</option>
                                                <option :value="'asc'">Date: Old</option>
                                            </b-form-select>
                                        </b-input-group-prepend>

                                        <b-input-group-prepend>
                                            <div class="custom-control custom-checkbox">
                                                <input
                                                        type="checkbox"
                                                        id="customCheckboxChecked"
                                                        name="customCheckboxCountry"
                                                        class="custom-control-input"
                                                        v-model="checkedBonuses"
                                                        v-on:change="typeBonuses(false)">
                                                <label
                                                        class="custom-control-label"
                                                        for="customCheckboxChecked">Checked</label>
                                            </div>
                                        </b-input-group-prepend>
                                        <b-input-group-prepend>
                                            <div class="custom-control custom-checkbox">
                                                <input
                                                        type="checkbox"
                                                        id="customCheckboxUnchecked"
                                                        name="customCheckboxCountry"
                                                        class="custom-control-input"
                                                        v-model="uncheckedBonuses"
                                                        v-on:change="typeBonuses(true)">
                                                <label
                                                        class="custom-control-label"
                                                        for="customCheckboxUnchecked">Unchecked</label>
                                            </div>
                                        </b-input-group-prepend>
                                    </b-input-group>
                                </b-form-group>


                                <b-row :current-page="currentPage"
                                       :per-page="perPage">
                                    <b-col md="6" sm="6" xs="12" lg="4" v-for="(bonusInfluencer, index) in allBonusesComputed" v-bind:key="'bonus_id_' + bonusInfluencer.id + '_campaign_id_' + bonusInfluencer.campaign.id"> <!-- pick amount that fits to current page -->
                                        <b-card :title="bonusInfluencer.campaign_name"
                                                :img-src="storage_path + '/' + bonusInfluencer.image.image_path"
                                                img-alt="Image"
                                                img-top
                                                tag="article"
                                                class="text-center card-custom">
                                            <p class="card-text text-center">
                                                {{ bonusInfluencer.name }}
                                            </p>
                                            <p class="card-text text-center">
                                                <span v-if="bonusInfluencer.user_api_id">From API User ID: {{ bonusInfluencer.user_api_id }}</span>
                                                <span v-else>Api User ID not found</span>
                                            </p>
                                            <p class="card-text text-center">
                                                <span>Campaign: {{ bonusInfluencer.campaign.name }}</span>
                                            </p>
                                            <div>
                                                <p :variant="'primary'" class="text-center uppercase font500">
                                                    Made: {{ bonusInfluencer.photo_date }}
                                                </p>
                                            </div>
                                            <div v-if="bonusInfluencer.image.checked === '0'">
                                                <b-button variant="secondary" class="float-left" @click="changeStatusBonus('declined', bonusInfluencer)">decline</b-button>
                                                <b-button variant="primary" class="float-right" @click="changeStatusBonus('accepted', bonusInfluencer)">accept</b-button>
                                            </div>
                                            <div v-if="bonusInfluencer.image.checked === 'accepted'">
                                                <p :variant="'primary'" class="text-center uppercase font500 statusCard">
                                                    <i class="icon-check"></i>
                                                    Accepted
                                                </p>
                                            </div>
                                            <div v-if="bonusInfluencer.image.checked === 'declined'">
                                                <p :variant="'secondary'" class="text-center uppercase font500 statusCard">
                                                    <i class="icon-close"></i>
                                                    Declined
                                                </p>
                                            </div>
                                            <div class="clearfix"></div>
                                        </b-card>
                                    </b-col>
                                </b-row>

                                    <nav>
                                        <b-pagination
                                                :total-rows="allBonusesLengthComputed"
                                                :per-page="perPage"
                                                align="center"
                                                v-model="currentPage"
                                                prev-text="Prev"
                                                next-text="Next"
                                                hide-goto-end-buttons>
                                        </b-pagination>
                                    </nav>
                                </b-card>
                            </b-col>
                    </b-col>
                </keep-alive>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};

    import Loading from 'vue-loading-spinner/src/components/Circle10'

    export default {
        name: 'CheckingBonuses',
        components: {
            Loading
        },
        data () {
            return {
                loading: false,

                loadedChecked: false,
                type: 'unchecked',
                header: 'Checking Bonuses',
                filter: null,
                sortBy: null,
                influencer_name_sort: null,
                campaign_name: null,
                sortDesc: false,
                sortDirection: 'asc',
                optionsUniqueNames: [],
                optionsUniqueCampaign_name: [],
                directionDate: 'desc',

                storage_path: '',

                uncheckedBonuses: true,
                checkedBonuses: false,

                fields: [
                    { key: 'id', label: '№' },
                    { key: 'name', label: 'Name' },
                    { key: 'campaign_name', label: 'Campaign' },
                    { key: 'photo_date', label: 'Created' }
                ],

                currentPage: 1,
                perPage    : 9,
                totalRows  : 0,
                fromNumber : 0,

                allCheckedBonuses: [],
                allUncheckedBonuses: [],
                chosenBonuses: [],
            }
        },
        beforeCreate(){
            vm = this;
        },
        created(){
            this.storage_path = this.$root.storage_path;
        },
        computed: {
            allBonusesComputed() {
                if(vm.type === 'checked' && vm.loadedChecked === false) {
                    vm.loadUncheckedData('/getAllCheckedBonuses', false).then(resolve => {
                        return vm.filtered(vm.sortBy, vm.campaign_name, vm.influencer_name_sort, false, vm.type)
                    })
                } else if(vm.type !== 'checked' && vm.allUncheckedBonuses.length === 0) {
                    vm.loadUncheckedData('/getAllUncheckedBonuses', true).then(resolve => {
                        return vm.filtered(vm.sortBy, vm.campaign_name, vm.influencer_name_sort, false, vm.type)
                    })
                } else {
                    return vm.filtered(vm.sortBy, vm.campaign_name, vm.influencer_name_sort, false, vm.type)
                }
            },
            allBonusesLengthComputed() {
                return vm.filtered(vm.sortBy, vm.campaign_name, vm.influencer_name_sort, true, vm.type)
            }
        },
        watch: {
            directionDate: {
                handler:function(val) {
                    // @todo make filter of date to work !
                    //vm.filterDate(val, vm.allBonusesComputed)
                }
            }
        },
        methods: {
            checkItemDataToMakeRequest(item){
                if(!item.campaign
                    || !item.influencer
                    || !item.image) {
                    return false
                }
                return true;
            },
            checkIfLoadedCheckedDatas(){
                // return Promise if checked bonuses not loaded & load them
                return new Promise ((resolve_loaded, reject) => {
                    if(vm.allCheckedBonuses.length === 0) {
                        vm.loadUncheckedData('/getAllCheckedBonuses', false).then(resolve => {
                            vm.filtered(vm.sortBy, vm.campaign_name, vm.influencer_name_sort, false, vm.type)
                            resolve_loaded(true)
                        })
                    } else {
                        resolve_loaded(true)
                    }
                })

            },
            replaceCheckedItem(checkedItem){
                vm.allCheckedBonuses.push(checkedItem);
                let index = vm.allUncheckedBonuses.indexOf(checkedItem);
                vm.allUncheckedBonuses.splice(index, 1);
            },
            changeStatusBonus(new_status, item){
                vm.loading = true;
                if(!vm.checkItemDataToMakeRequest(item)) return vm.$swal('Oops:', 'Request data not found', 'error')
                return axios.post('/changeBonusStatus', {
                    status: new_status,
                    image_id: item.image.id,
                    campaign_id: item.campaign.id,
                    influencer_id: item.influencer.id
                }).then(function (response) {
                    vm.loading = false;
                    if(response.data.errors){
                        return vm.$swal('Unfortunately:', response.data.errors, 'error')
                    }
                    item.image.checked = response.data.image_status
                    //vm.checkIfLoadedCheckedDatas().then(resolve_loaded => {
                    vm.replaceCheckedItem(item);
                    return vm.$swal(new_status, response.data.image_status, 'success')
                    //});
                })
            },
            getOptions(items){
                return items.forEach(function (item) {
                    if(item.influencer && !vm.optionsUniqueNames.includes(item.influencer.name)) {
                        vm.optionsUniqueNames.push(item.influencer.name);
                    }
                    if(item.campaign && !vm.optionsUniqueCampaign_name.includes(item.campaign.name)) {
                        vm.optionsUniqueCampaign_name.push(item.campaign.name);
                    }
                });
            },
            typeBonuses(type){
                type ? vm.uncheckedBonuses = true : vm.uncheckedBonuses = false;
                type ? vm.checkedBonuses = false : vm.checkedBonuses = true;
                if(vm.uncheckedBonuses === true) {
                    vm.type = 'unchecked';
                    vm.sortBy = null;
                }
                if(vm.checkedBonuses === true) {
                    vm.type = 'checked';
                    vm.sortBy = 'accepted';
                }
            },
            loadUncheckedData(route, checked){
                this.loading = true;
                return new Promise((resolve, reject) => {
                    axios.post(route).then(response => {
                        vm.loading = false;
                        if(response.data.bonuses){
                            if(checked === true){
                                vm.allUncheckedBonuses = response.data.bonuses
                            } else {
                                vm.loadedChecked = true;
                                vm.allCheckedBonuses = vm.allCheckedBonuses.concat(response.data.bonuses)
                            }
                            vm.getOptions(response.data.bonuses);
                            //vm.filterDate('desc', response.data.bonuses);
                            resolve();
                        }
                        if(response.data.errors){
                            reject()
                            vm.$swal('Unfortunately:', response.data.errors, 'error')
                        }
                    }).catch( err => {
                        reject()
                        vm.loading = false;
                        console.log(err.message)
                    })
                });
            },
            filterDate(type, items) {
                items.sort(function(a,b) {
                   if ( type === 'asc' ) {
                       return a.date.getTime() - b.date.getTime()
                   } else {
                       return b.date.getTime() - a.date.getTime()
                   }
                })
                return items
            },
            callFilters(data, type, campaign_name, influencer_name_sort){
                data = vm.filterType(type, data);
                data = vm.filterCampaign(campaign_name, data);
                data = vm.filterInfluencer(influencer_name_sort, data);
                return data;
            },
            filterType(type, data){
                switch (type) {
                    case null:
                        return data;
                        break;
                    default:
                        return data.filter(data => data.image.checked === type);
                }
            },
            filterCampaign(campaign_name, data){
                switch (campaign_name) {
                    case null:
                        return data;
                        break;
                    default:
                        return data.filter(function(data){
                            if(data.campaign)
                                return data.campaign.name === campaign_name ;
                            return false
                        });
                }
            },
            filterInfluencer(influencer_name_sort, data){
                switch (influencer_name_sort) {
                    case null:
                        return data;
                        break;
                    default:
                        return data.filter(function(data){
                            if(data.influencer)
                                return data.influencer.name === influencer_name_sort ;
                            return false
                        });
                }
            },
            filtered(type, campaign_name, influencer_name_sort, count = false, typeBonuses) {
                let datas;
                typeBonuses === 'checked' ? datas = vm.allCheckedBonuses : datas = vm.allUncheckedBonuses;
                datas = vm.callFilters(datas, type, campaign_name, influencer_name_sort);
                if(count !== false) return datas.length;
                return vm.slicePerPage(datas);
            },
            getRowCount (items) {
                return items.length
            },
            slicePerPage(items){
                return items.slice((vm.currentPage - 1) * vm.perPage, vm.currentPage * vm.perPage)
            },
            sorted(arrays) {
                //return _.orderBy(arrays, 'name', 'asc');
            },
            onFiltered (filteredItems) {
                this.totalRows = filteredItems
                this.currentPage = 1
            },

        },
    }
</script>