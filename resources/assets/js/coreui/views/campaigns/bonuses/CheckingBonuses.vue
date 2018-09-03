<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12"
                       md="12">
                    <h2 class="h2">{{ header }}</h2>
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
                                <b-input-group-prepend>
                                    <b-form-select dark v-model="influencer_name_sort" :options="optionsUniqueNames">
                                        <option slot="first" :value="null">All influencers</option>
                                    </b-form-select>
                                </b-input-group-prepend>
                            </b-input-group>
                        </b-form-group>


                        <b-row :current-page="currentPage"
                               :per-page="perPage">
                            <b-col md="6" sm="6" xs="12" lg="4" v-for="tmpBonus in filtered(tmpAllBonuses, sortBy, campaign_name_sort, influencer_name_sort)
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
                                        <b-button href="#" variant="secondary" class="float-left">decline</b-button>
                                        <b-button href="#" variant="primary" class="float-right">accept</b-button>
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
                    </b-col>

                    <nav>
                        <b-pagination
                                :total-rows="getRowCount(tmpAllBonuses, sortBy, campaign_name_sort, influencer_name_sort)"
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

    export default {
        name: 'CheckingBonuses',
        data () {
            return {
                header: 'Checking Bonuses',

                rule: null,
                filter: null,
                sortBy: null,
                influencer_name_sort: null,
                campaign_name_sort: null,
                sortDesc: false,
                sortDirection: 'asc',
                optionsUniqueNames: [],
                optionsUniqueCampaign_name: [],

                fields: [
                    { key: 'id', label: '№' },
                    { key: 'name', label: 'Name' },
                    { key: 'campaign_name', label: 'Campaign' }
                ],

                currentPage: 1,
                perPage    : 9,
                totalRows  : 0,
                fromNumber : 0,

                tmpAllBonuses: [
                    { id: 1, name: 'Anton Ptushkin', status: 'accepted', campaign_name: 'Snacks' },
                    { id: 2, name: 'Kate Pery', status: 'waiting', campaign_name: 'Cheese' },
                    { id: 3, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Snacks' },
                    { id: 4, name: 'Yuriy Gagarin', status: 'waiting', campaign_name: 'Snacks' },
                    { id: 5, name: 'Maria Adolfovna', status: 'declined', campaign_name: 'Cheese' },
                    { id: 6, name: 'Ksenia Sobchak', status: 'declined', campaign_name: 'Cheese' },
                    { id: 7, name: 'Maria Adolfovna', status: 'accepted', campaign_name: 'Snacks' },
                    { id: 8, name: 'Maria Rasputina', status: 'waiting', campaign_name: 'Cheese' },
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
            filtered (arrays, rule, campaign_name, influencer_name_sort) {
                if(rule === null && campaign_name === null && influencer_name_sort === null) {
                    this.getRowCount(this.tmpAllBonuses);
                    return this.tmpAllBonuses
                } else {
                    let i = 0;


                    if(campaign_name === null && influencer_name_sort === null) {
                        this.tmpAllBonuses.forEach(function (item, index) {
                            if (item.status === rule) {
                                i++
                            }
                        });
                        this.getRowCount(this.tmpAllBonuses.filter(t => t.status === rule));
                        return this.tmpAllBonuses.filter(t => t.status === rule)

                    } else if(rule === null && influencer_name_sort === null) {
                        this.tmpAllBonuses.forEach(function (item, index) {
                            if (item.campaign_name === campaign_name) {
                                i++
                            }
                        });
                        this.getRowCount(this.tmpAllBonuses.filter(t => t.campaign_name === campaign_name));
                        return this.tmpAllBonuses.filter(t => t.campaign_name === campaign_name)

                    } else if(rule === null && campaign_name === null) {
                        this.tmpAllBonuses.forEach(function (item, index) {
                            if (item.name === influencer_name_sort) {
                                i++
                            }
                        });

                        this.getRowCount(this.tmpAllBonuses.filter(t => t.name === influencer_name_sort));
                        return this.tmpAllBonuses.filter(t => t.name === influencer_name_sort)

                    } else {
                        if(influencer_name_sort === null) {
                            this.tmpAllBonuses.forEach(function (item, index) {
                                if (item.status === rule && item.campaign_name === campaign_name) {
                                    i++
                                }
                            });

                            this.getRowCount(this.tmpAllBonuses.filter(t => t.status === rule && t.campaign_name === campaign_name));
                            return this.tmpAllBonuses.filter(t => t.status === rule && t.campaign_name === campaign_name);

                        } else if (campaign_name === null) {
                            this.tmpAllBonuses.forEach(function (item, index) {
                                if (item.status === rule && item.name === influencer_name_sort) {
                                    i++
                                }
                            });

                            this.getRowCount(this.tmpAllBonuses.filter(t => t.status === rule && t.name === influencer_name_sort));
                            return this.tmpAllBonuses.filter(t => t.status === rule && t.name === influencer_name_sort);

                        } else if (rule === null) {
                            this.tmpAllBonuses.forEach(function (item, index) {
                                if (item.name === influencer_name_sort && item.campaign_name === campaign_name) {
                                    i++
                                }
                            });

                            this.getRowCount(this.tmpAllBonuses.filter(t => t.name === influencer_name_sort && t.campaign_name === campaign_name));
                            return this.tmpAllBonuses.filter(t => t.name === influencer_name_sort && t.campaign_name === campaign_name);

                        } else {
                            this.tmpAllBonuses.forEach(function (item, index) {
                                if (item.status === rule && item.campaign_name === campaign_name && item.name === influencer_name_sort) {
                                    i++
                                }
                            });

                            this.getRowCount(this.tmpAllBonuses.filter(t => t.status === rule && t.campaign_name === campaign_name && t.name === influencer_name_sort));
                            return this.tmpAllBonuses.filter(t => t.status === rule && t.campaign_name === campaign_name && t.name === influencer_name_sort);
                        }
                    }
                }
            },
            getRowCount (items, rule, campaign_rule, influencer_name_sort) {
                if(rule === null && campaign_rule === null && influencer_name_sort === null) {
                    return items.length
                } else {
                    if(campaign_rule === null && influencer_name_sort === null) {
                        return items.filter(t => t.status === rule).length
                    } else if(rule === null && influencer_name_sort === null) {
                        return items.filter(t => t.campaign_name === campaign_rule).length
                    } else if(rule === null && campaign_rule === null) {
                        return items.filter(t => t.name === influencer_name_sort).length
                    } else {
                        if(rule === null) {
                            return items.filter(t => t.campaign_name === campaign_rule && t.name === influencer_name_sort).length
                        } else if (campaign_rule === null) {
                            return items.filter(t => t.status === rule && t.name === influencer_name_sort).length
                        } else if (influencer_name_sort === null) {
                            return items.filter(t => t.status === rule && t.campaign_name === campaign_rule).length
                        } else {
                            return items.filter(t => t.status === rule && t.campaign_name === campaign_rule && t.name === influencer_name_sort).length
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