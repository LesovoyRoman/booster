<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12"
                       md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

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
                                <b-col md="6" sm="6" xs="12" lg="4" v-for="(tmpBonus, index) in filtered(sortBy, campaign_name, influencer_name_sort)
                                .slice((currentPage - 1) * perPage, currentPage * perPage)" v-bind:key="tmpBonus.id"> <!-- pick amount that fits to current page -->
                                    <b-card :title="tmpBonus.campaign_name"
                                            img-src="https://picsum.photos/600/300/?image=25"
                                            img-alt="Image"
                                            img-top
                                            tag="article"
                                            class="text-center card-custom">
                                        <p class="card-text text-center">
                                            {{ tmpBonus.name }}
                                        </p>
                                        <p class="card-text text-center">
                                            from user id {{ tmpBonus.id }}
                                        </p>
                                        <p class="card-text text-center">
                                            Iphone
                                        </p>
                                        <div v-if="tmpBonus.status === 'waiting'">
                                            <b-button variant="secondary" class="float-left" @click="tmpBonus.status = 'declined'">decline</b-button>
                                            <b-button variant="primary" class="float-right" @click="tmpBonus.status = 'accepted';">accept</b-button>
                                        </div>
                                        <div v-if="tmpBonus.status === 'accepted'">
                                            <p :variant="'primary'" class="text-center uppercase font500 statusCard">
                                                <i class="icon-check"></i>
                                                Accepted
                                            </p>
                                        </div>
                                        <div v-if="tmpBonus.status === 'declined'">
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
                                            :total-rows="filtered(sortBy, campaign_name, influencer_name_sort, true)"
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
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};

    export default {
        name: 'CheckingBonuses',
        data () {
            return {
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

                uncheckedBonuses: true,
                checkedBonuses: false,

                fields: [
                    { key: 'id', label: '№' },
                    { key: 'name', label: 'Name' },
                    { key: 'campaign_name', label: 'Campaign' },
                ],

                currentPage: 1,
                perPage    : 9,
                totalRows  : 0,
                fromNumber : 0,

                tmpAllBonuses: [
                    { id: 1, name: 'Anton Ptushkin', status: 'accepted', campaign_name: 'Snacks', date: new Date('2015-03-25') },
                    { id: 2, name: 'Kate Pery', status: 'waiting', campaign_name: 'Cheese', date: new Date('2016-03-25') },
                    { id: 3, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Snacks', date: new Date('2017-03-25') },
                    { id: 4, name: 'Yuriy Gagarin', status: 'waiting', campaign_name: 'Snacks', date: new Date('2018-03-25') },
                    { id: 5, name: 'Maria Adolfovna', status: 'declined', campaign_name: 'Cheese', date: new Date('2015-03-25') },
                    { id: 6, name: 'Ksenia Sobchak', status: 'declined', campaign_name: 'Cheese', date: new Date('2015-03-25') },
                    { id: 7, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Snacks', date: new Date('2019-03-25') },
                    { id: 8, name: 'Maria Rasputina', status: 'waiting', campaign_name: 'Cheese', date: new Date('2015-03-25') },
                    { id: 9, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Snacks', date: new Date('2015-03-25') },
                    { id: 10, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Snacks', date: new Date('2015-03-10') },
                    { id: 11, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Snacks', date: new Date('2020-03-25') },
                    { id: 12, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Cheese', date: new Date('2015-03-25') },
                    { id: 13, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Snacks', date: new Date('2015-05-25') },
                    { id: 14, name: 'Maria Adolfovna', status: 'declined', campaign_name: 'Cheese', date: new Date('2015-03-25') },
                    { id: 15, name: 'Maria Adolfovna', status: 'declined', campaign_name: 'Snacks', date: new Date('2015-07-25') },
                    { id: 16, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Cheese', date: new Date('2015-03-09') },
                    { id: 17, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Cheese', date: new Date('2015-09-25') },
                    { id: 18, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Cheese', date: new Date('2015-03-25') },
                    { id: 19, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Cheese', date: new Date('2015-03-25') },
                    { id: 20, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Snacks', date: new Date('2015-12-25') },
                    { id: 21, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Snacks', date: new Date('2015-03-25') },
                    { id: 22, name: 'Maria Adolfovna', status: 'declined', campaign_name: 'Cheese', date: new Date('2015-03-29') },
                    { id: 23, name: 'Maria Adolfovna', status: 'declined', campaign_name: 'Snacks', date: new Date('2015-03-25') },
                    { id: 24, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Cheese', date: new Date('2015-03-30') },
                    { id: 25, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Snacks', date: new Date('2015-03-25') },
                    { id: 26, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Cheese', date: new Date('2015-03-31') }
                ],
            }
        },
        beforeCreate(){
            vm = this;
        },
        created(){
            this.getOptions();
            this.filterDate('desc');
        },
        computed: {

        },
        watch: {
            directionDate: {
                handler:function(val, oldVal,changed) {
                    vm.filterDate(val)
                }
            }
        },
        methods: {
            getOptions(){
                this.tmpAllBonuses.forEach(function (item, i) {
                    if(!vm.optionsUniqueNames.includes(item.name)) {
                        vm.optionsUniqueNames.push(item.name);
                    }
                    if(!vm.optionsUniqueCampaign_name.includes(item.campaign_name)) {
                        vm.optionsUniqueCampaign_name.push(item.campaign_name);
                    }
                });
            },
            typeBonuses(type){
                type ? vm.uncheckedBonuses = true : vm.uncheckedBonuses = false;
                type ? vm.checkedBonuses = false : vm.checkedBonuses = true;
                if(vm.uncheckedBonuses === true) vm.sortBy = 'waiting';
                if(vm.checkedBonuses === true) vm.sortBy = 'accepted';
            },
            filterDate(type) {
                this.tmpAllBonuses.sort(function(a,b) {
                   if ( type === 'asc' ) {
                       return a.date.getTime() - b.date.getTime()
                   } else {
                       return b.date.getTime() - a.date.getTime()
                   }
                })
                return this.tmpAllBonuses
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
                        return data.filter(data => data.status === type);
                }
            },
            filterCampaign(campaign_name, data){
                switch (campaign_name) {
                    case null:
                        return data;
                        break;
                    default:
                        return data.filter(data => data.campaign_name === campaign_name);
                }
            },
            filterInfluencer(influencer_name_sort, data){
                switch (influencer_name_sort) {
                    case null:
                        return data;
                        break;
                    default:
                        return data.filter(data => data.name === influencer_name_sort);
                }
            },
            filtered(type, campaign_name, influencer_name_sort, count = false) {
                let datas = vm.tmpAllBonuses;
                datas = vm.callFilters(datas, type, campaign_name, influencer_name_sort);
                if(count !== false) return datas.length;
                return datas;
            },
            getRowCount (items) {
                return items.length
            },
            sorted(arrays) {
                //return _.orderBy(arrays, 'name', 'asc');
            },
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems
                this.currentPage = 1
            },

        },
    }
</script>