<template>
    <div class="wrapper" :influencer="computedInfluencer">
        <div class="animated fadeIn"  v-if="influencer">
            <b-row>
                <b-col sm="12"
                       md="12">
                    <h2 class="h2">{{ header }} {{ influencer.name }}</h2>
                </b-col>

                <b-card>

                    <b-col
                            sm="12"
                            md="12">

                        <b-form-group>
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-select dark v-model="sortBy">
                                        <option slot="first" :value="null">All</option>
                                        <option :value="'accepted'">Accepted</option>
                                        <option :value="'declined'">Declined</option>
                                        <option :value="'waiting'">Waiting</option>
                                    </b-form-select>
                                </b-input-group-prepend>
                                <b-input-group-prepend>
                                    <b-form-select dark v-model="campaign_name_sort" :options="optionsUniqueCampaign_name">
                                        <option slot="first" :value="null">All campaigns</option>
                                    </b-form-select>
                                </b-input-group-prepend>
                            </b-input-group>
                        </b-form-group>


                        <b-row :current-page="currentPage"
                               :per-page="perPage">
                            <b-col md="6" sm="6" xs="12" lg="4" v-for="tmpInfluencer in filtered(tmpInfluencers, sortBy, campaign_name_sort)
                            .slice((currentPage - 1) * perPage, currentPage * perPage)" v-bind:key="tmpInfluencer.id"> <!-- pick amount that fits to current page -->
                                <b-card :title="tmpInfluencer.campaign_name"
                                        img-src="https://picsum.photos/600/300/?image=25"
                                        img-alt="Image"
                                        img-top
                                        tag="article"
                                        class="text-center card-custom">
                                    <p class="card-text text-center">
                                        {{ tmpInfluencer.name }}
                                    </p>
                                    <p class="card-text text-center">
                                        from user id {{ tmpInfluencer.id }}
                                    </p>
                                    <p class="card-text text-center">
                                        Iphone
                                    </p>
                                    <div v-if="tmpInfluencer.status === 'waiting'">
                                        <b-button href="#" variant="secondary" class="float-left">decline</b-button>
                                        <b-button href="#" variant="primary" class="float-right">accept</b-button>
                                    </div>
                                    <div v-if="tmpInfluencer.status === 'accepted'">
                                        <p :variant="'primary'" class="text-center uppercase font500 statusCard">
                                            <i class="icon-check"></i>
                                            Accepted
                                        </p>
                                    </div>
                                    <div v-if="tmpInfluencer.status === 'declined'">
                                        <p :variant="'secondary'" class="text-center uppercase font500 statusCard">
                                            <i class="icon-close"></i>
                                            Declined
                                        </p>
                                    </div>
                                    <div class="clearfix"></div>
                                </b-card>
                            </b-col>
                        </b-row>
                    </b-col>

                    <nav>
                        <b-pagination
                                :total-rows="getRowCount(tmpInfluencers, sortBy, campaign_name_sort)"
                                :per-page="perPage"
                                align="center"
                                v-model="currentPage"
                                prev-text="Prev"
                                next-text="Next"
                                hide-goto-end-buttons/>
                    </nav>
                </b-card>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};
    let arr = {};

    export default {
        props: ['influencer', 'campaign_name'],
        name: 'Influencerbonuses',
        data () {
            return {
                header: 'Bonuses of',

                rule: null,
                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                optionsUniqueCampaign_name: [],
                campaign_name_sort: null,

                fields: [
                    { key: 'id', label: '№', sortable: true },
                    { key: 'name', sortable: true, label: 'Name' },
                ],

                currentPage: 1,
                perPage    : 9,
                totalRows  : 0,
                fromNumber : 0,

                tmpInfluencers: [
                    { id: 1, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Snacks' },
                    { id: 2, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Cheese' },
                    { id: 3, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Snacks' },
                    { id: 4, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Snacks' },
                    { id: 5, name: 'Maria Adolfovna', status: 'declined', campaign_name: 'Cheese' },
                    { id: 6, name: 'Maria Adolfovna', status: 'declined', campaign_name: 'Cheese' },
                    { id: 7, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Snacks' },
                    { id: 8, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Cheese' },
                    { id: 9, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Snacks' },
                    { id: 10, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Snacks' },
                    { id: 11, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Snacks' },
                    { id: 12, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Cheese' },
                    { id: 13, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Snacks' },
                    { id: 14, name: 'Maria Adolfovna', status: 'declined', campaign_name: 'Cheese' },
                    { id: 15, name: 'Maria Adolfovna', status: 'declined', campaign_name: 'Snacks' },
                    { id: 16, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Cheese' },
                    { id: 17, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Cheese' },
                    { id: 18, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Cheese' },
                    { id: 19, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Cheese' },
                    { id: 20, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Snacks' },
                    { id: 21, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Snacks' },
                    { id: 22, name: 'Maria Adolfovna', status: 'declined', campaign_name: 'Cheese' },
                    { id: 23, name: 'Maria Adolfovna', status: 'declined', campaign_name: 'Snacks' },
                    { id: 24, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Cheese' },
                    { id: 25, name: 'Maria Adolfovna', status: 'waiting', campaign_name: 'Snacks' },
                    { id: 26, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Cheese' }
                ],
            }
        },
        beforeCreate(){
            vm = this;
        },
        created(){
            this.getOptions();
        },
        computed: {
            computedInfluencer: function() {
                if(typeof this.influencer === 'undefined') {
                    vm.$router.go(-1)
                }
            },
        },
        methods: {
            getOptions(){
                this.tmpInfluencers.forEach(function (item, i) {
                    if(!vm.optionsUniqueCampaign_name.includes(item.campaign_name)) {
                        vm.optionsUniqueCampaign_name.push(item.campaign_name);
                    }
                });
            },
            filtered (arrays, rule, campaign_name) {
                if(rule === null && campaign_name === null) {
                    this.getRowCount(this.tmpInfluencers);
                    return this.tmpInfluencers
                } else {
                    let i = 0;
                    if(campaign_name === null) {
                        this.tmpInfluencers.forEach(function (item, index) {
                            if (item.status === rule) {
                                i++
                            }
                        });

                        this.getRowCount(this.tmpInfluencers.filter(t => t.status === rule));
                        return this.tmpInfluencers.filter(t => t.status === rule)
                    } else if (rule === null){
                        this.tmpInfluencers.forEach(function (item, index) {
                            if (item.campaign_name === campaign_name) {
                                i++
                            }
                        });

                        this.getRowCount(this.tmpInfluencers.filter(t => t.campaign_name === campaign_name));
                        return this.tmpInfluencers.filter(t => t.campaign_name === campaign_name);
                    } else {
                        this.tmpInfluencers.forEach(function (item, index) {
                            if (item.status === rule && item.campaign_name === campaign_name) {
                                i++
                            }
                        });

                        this.getRowCount(this.tmpInfluencers.filter(t => t.status === rule && t.campaign_name === campaign_name));
                        return this.tmpInfluencers.filter(t => t.status === rule && t.campaign_name === campaign_name);
                    }
                }
            },
            getRowCount (items, rule, campaign_rule) {
                if(rule === null && campaign_rule === null) {
                    return items.length
                } else {
                    if(campaign_rule === null) {
                        return items.filter(t => t.status === rule).length
                    } else {
                        if(rule === null) {
                            return items.filter(t => t.campaign_name === campaign_rule).length
                        } else {
                            return items.filter(t => t.status === rule && t.campaign_name === campaign_rule).length
                        }
                    }
                }
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