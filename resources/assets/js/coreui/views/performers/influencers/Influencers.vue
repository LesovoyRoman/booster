<template>
    <div class="wrapper influencers">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>

                <b-col
                        sm="12"
                        md="12">
                    <b-card>

                        <b-form-group>
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-select dark v-model="filterChannels" :options="optionsInflueceChannels">
                                        <option slot="first" :value="null">All channels</option>
                                    </b-form-select>
                                </b-input-group-prepend>
                                <b-input-group-prepend>
                                    <b-form-select dark v-model="influencer_topic" :options="optionsTopics">
                                        <option slot="first" :value="null">All topics</option>
                                    </b-form-select>
                                </b-input-group-prepend>
                                <b-input-group-prepend>
                                    <b-form-select dark v-model="influencer_lang" :options="optionsInfluenceLanguages">
                                        <option slot="first" :value="null">All languages</option>
                                    </b-form-select>
                                </b-input-group-prepend>
                                <b-form-input v-model="filter" placeholder="Type influencer name or smth"/>
                                <b-input-group-append>
                                    <b-btn :variant="'primary'" :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                </b-input-group-append>

                                <b-input-group-append class="pull-right" style="margin-left: 15px;">
                                    <div class="">
                                        <input
                                                type="checkbox"
                                                id="customCheckboxInfluencersList"
                                                name="customCheckboxCountry"
                                                class="custom-control-input"
                                                v-model="influencersList"
                                                v-on:change="filterMedia(false)">
                                        <label
                                                style="display: block"
                                                class="control-type-grid control-type-grid-list"
                                                for="customCheckboxInfluencersList"></label>
                                    </div>
                                    <div class="">
                                        <input
                                                type="checkbox"
                                                id="customCheckboxInfluencersCards"
                                                name="customCheckboxCountry"
                                                class="custom-control-input"
                                                v-on:change="filterMedia(true)"
                                                v-model="influencersCards">
                                        <label
                                                style="display: block"
                                                class="control-type-grid control-type-grid-cards"
                                                for="customCheckboxInfluencersCards"></label>
                                    </div>
                                </b-input-group-append>
                            </b-input-group>
                        </b-form-group>


                        <b-table
                                :id="influencersCards ? 'table_cards' : ''"
                                :hover="false"
                                :striped="false"
                                :bordered="false"
                                :small="true"
                                :fixed="false"
                                responsive="sm"
                                :items="filtered(influencers, influencer_topic, filterChannels, influencer_lang)"
                                :fields="fields"

                                :filter="filter"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                @filtered="onFiltered"

                                :current-page="currentPage"
                                :per-page="perPage">
                            <template slot="name" slot-scope="data">
                                <div class="photo_influencer-block">
                                    <i class="fa fa-star star_active star_influencer" v-if="data.item.star === 1"></i>
                                    <keep-alive>
                                        <img v-if="data.item.images.length !== 0" :src="storage_path + '/' + data.item.images[0].image_path" alt="photo" class="photo_influencer_table">
                                        <img v-else :src="storage_path + '/' + noimage" alt="photo" class="photo_influencer_table">
                                    </keep-alive>
                                </div>
                                <div class="influencer-name-block">
                                    <router-link :id="id = data.item.id" :data="influencer = data.item" :to="{ name: 'Influencer', params: { influencer: influencer, idInfluencer: id, campaign_name: '' } }"><span class="link_influencer">{{ data.item.name }}</span></router-link>
                                    <br><span>{{ data.item.type }}</span>
                                </div>
                            </template>
                            <template slot="channels" slot-scope="data">
                                <div class="icons_influencer">
                                    <i v-for="itemIcon in data.item.channels" :class="'fa fa-' + itemIcon.name"></i>
                                    <span v-for="item in data.item.channels">{{ item.name }}</span>
                                </div>
                            </template>
                            <template slot="influence" slot-scope="data">
                                <span class="showsTableCards">Influence coefficient:</span><span class="font500"> {{ data.item.influence }}%</span>
                            </template>
                            <template slot="auditory" slot-scope="data">
                                <span class="showsTableCards">Auditory:</span> {{ data.item.auditory }}
                            </template>
                            <template slot="birth_date" slot-scope="data">
                                <span class="showsTableCards" v-if="data.item.birth_date">Birth date:</span> {{ data.item.birth_date }}
                            </template>
                            <template slot="sendOffer" justified="center" slot-scope="row">
                                <b-button :variant="'primary'" @click="prepareSendOffer(row)" class="sendOffer">Send offer</b-button>
                            </template>
                        </b-table>

                        <nav>
                            <b-pagination
                                    :total-rows="getRowCount(influencers, influencer_topic, filterChannels, influencer_lang)"
                                    :per-page="perPage"
                                    align="center"
                                    v-model="currentPage"
                                    prev-text="Prev"
                                    next-text="Next"
                                    hide-goto-end-buttons/>
                        </nav>

                    </b-card>
                </b-col>
            </b-row>
        </div>


        <b-modal id="modalOffer" ref="modalOffer" hide-footer hide-header>
            <button type="button" aria-label="Close" class="close" @click="closeModal">×</button>
            <h2>Send offer to</h2>
            <h3 class="modal_indluencer_name">{{ sendTo }}</h3>

            <h5>for participationg in</h5>
            <form id="form_sendOffer">
                <b-form-select dark v-model="chosenCampaignOffer">
                    <option :value="null" disabled>Choose the campaign</option>
                    <option v-for="(campaign, index) in campaigns" :value="campaign.id">{{ campaign.name }}</option>
                </b-form-select>
                <b-btn :variant="'primary'" @click="sendRequest(chosenInfluencer)" class="sendOfferModal">Send offer</b-btn>
            </form>

        </b-modal>
    </div>
</template>

<script>
    import Loading from 'vue-loading-spinner/src/components/Circle8'
    let vm = {};

    export default {
        name: 'Influencers',
        components: {
            Loading
        },
        data() {
            return {
                loading: false,
                header: 'Influencers',
                filterChannels: null,
                influencer_topic: null,
                influencer_lang: null,
                influencersList: true,
                influencersCards: false,
                chosenInfluencer: {},

                // @change it !
                optionsInfluenceLanguages: [],
                optionsInflueceChannels: [],
                optionsTopics: [],

                campaigns: [],
                chosenCampaignOffer: null,

                storage_path: '',
                noimage: 'images/noimage.jpg',

                checkbox_group: {},
                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                sendTo: '',

                selected: [],
                allSelected: false,
                userIds: [],

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                dataRequst: {fields: ['id', 'name']},

                influencers: [],
                fields: [
                    { key: 'name', sortable: true, 'class': 'name_influncer' },
                    { key: 'channels', sortable: false, 'class': 'channels_influencer' },
                    { key: 'auditory', sortable: true, 'class':'auditory_influencer' },
                    { key: 'birth_date', sortable: true, 'class':'auditory_age_influencer' },
                    { key: 'influence', sortable: true, 'class': 'influence_influencer' },
                    { key: 'sendOffer', label: '', 'class': 'table_label_hidden'},
                ]
            }
        },
        created() {
            vm = this;
            this.storage_path = this.$root.storage_path;
            this.loading = true;
            axios.post('/getInfluencersPerformer').then(response => {
                this.influencers = response.data.influencers;
                this.getOptions();
                console.log(this.influencers);
                axios.post('/getAllCampaigns', vm.dataRequst).then(response => {
                    this.loading = false;
                    if(response.data.campaigns instanceof Array) {
                        this.campaigns = response.data.campaigns
                    }
                    if(response.data.errors){
                        vm.$swal('Unfortunately:', response.data.errors, 'error')
                    }
                }).catch( err => {
                    this.loading = false;
                    console.log(err.message)
                })
            }).catch(err => {
                this.loading = false;
                console.log(err)
            });

        },
        methods: {
            filterMedia(val){
                val ? vm.influencersList = false : vm.influencersList = true;
                val ? vm.influencersCards = true : vm.influencersCards = false;
                val ? vm.perPage = 9 : vm.perPage = 10;
            },
            getBadge (status) {
                return status === 5 ? 'success'
                    : status === 4 ? 'warning'
                        : status === 3 ? 'danger' : 'primary'
            },
            closeModal: function () {
                this.$refs.modalOffer.hide();
            },
            sendRequest(){
                vm.loading = true;
                axios.post('/sendOfferInfluencer', {
                    influencer_id: this.chosenInfluencer.id,
                    campaign_id: this.chosenCampaignOffer,
                }).then(response => {
                    this.clearChoseInfluencer();
                    this.$refs.modalOffer.hide();
                    vm.loading = false;
                }).catch(err => {
                    this.$refs.modalOffer.hide();
                    vm.loading = false;
                    console.log(err)
                })
            },
            prepareSendOffer: function(row) {
                vm.sendTo = row.item.name;
                vm.chosenInfluencer = row.item;
                this.$refs.modalOffer.show();
            },
            clearChoseInfluencer(){
                vm.chosenInfluencer = {};
                vm.sendTo = '';
            },
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            selectAll: function() {
                vm.allSelected = !vm.allSelected;
                vm.userIds = [];

                if (vm.allSelected) {
                    vm.activeTable.forEach(function(item){
                        vm.userIds.push(item.id);
                    })
                }
            },
            select: function() {
                vm.allSelected = false;
            },

            // @ REMAKE IT !!!
            filtered (arrays, topic, channel, lang) {
                if(topic === null && channel === null && lang === null) {
                    this.getRowCount(this.influencers);
                    return this.influencers
                } else {
                    let i = 0;
                    if(channel === null) {
                        if(lang === null) {
                            this.influencers.forEach(function (item, index) {
                                if (item.type === topic) {
                                    i++
                                }
                            });

                            this.getRowCount(this.influencers.filter(t => t.type === topic));
                            return this.influencers.filter(t => t.type === topic)

                        } else if(topic === null) {
                            this.influencers.forEach(function (item, index) {
                                if (item.lang === lang) {
                                    i++
                                }
                            });

                            this.getRowCount(this.influencers.filter(t => t.lang === lang));
                            return this.influencers.filter(t => t.lang === lang)

                        } else {
                            this.influencers.forEach(function (item, index) {
                                if (item.type === topic && item.lang === lang) {
                                    i++
                                }
                            });

                            this.getRowCount(this.influencers.filter(t => t.type === topic && t.lang === lang));
                            return this.influencers.filter(t => t.type === topic && t.lang === lang)
                        }


                    } else if (topic === null) {
                        if (channel === null) {
                            this.influencers.forEach(function (item, index) {
                                if (item.lang === lang) {
                                    i++
                                }
                            });

                            this.getRowCount(this.influencers.filter(t => t.lang === lang));
                            return this.influencers.filter(t => t.lang === lang)

                        } else if (lang === null) {
                            this.influencers.forEach(function (item, index) {
                                if (item.channels.includes(channel)) {
                                    i++
                                }
                            });

                            this.getRowCount(this.influencers.filter(t => t.channels.includes(channel)));
                            return this.influencers.filter(t => t.channels.includes(channel))

                        } else {
                            this.influencers.forEach(function (item, index) {
                                if (item.type === topic && item.channels.includes(channel)) {
                                    i++
                                }
                            });

                            this.getRowCount(this.influencers.filter(t => t.channels.includes(channel) && t.lang === lang));
                            return this.influencers.filter(t => t.channels.includes(channel) && t.lang === lang)
                        }

                        } else if (lang === null){
                            if(channel === null) {
                                this.influencers.forEach(function (item, index) {
                                    if (item.type === topic) {
                                        i++
                                    }
                                });

                                this.getRowCount(this.influencers.filter(t => t.type === topic));
                                return this.influencers.filter(t => t.type === topic)

                            } else if(topic === null) {
                                this.influencers.forEach(function (item, index) {
                                    if (item.channels.includes(channel)) {
                                        i++
                                    }
                                });

                                this.getRowCount(this.influencers.filter(t => t.channels.includes(channel)));
                                return this.influencers.filter(t => t.channels.includes(channel))

                            } else {
                                this.influencers.forEach(function (item, index) {
                                    if (item.type === topic && item.channels.includes(channel)) {
                                        i++
                                    }
                                });

                                this.getRowCount(this.influencers.filter(t => t.type === topic && t.channels.includes(channel)));
                                return this.influencers.filter(t => t.type === topic && t.channels.includes(channel))
                            }

                    } else {
                        this.influencers.forEach(function (item, index) {
                            if (item.type === topic && item.channels.includes(channel)) {
                                i++
                            }
                        });

                        this.getRowCount(this.influencers.filter(t => t.type === topic && t.channels.includes(channel)));
                        return this.influencers.filter(t => t.type === topic && t.channels.includes(channel));
                    }
                }
            },
            getOptions(){
                this.influencers.forEach(function(item){
                    item.channels.forEach(function(item){
                        // channels
                        if(!vm.optionsInflueceChannels.includes(item.name)) {
                            vm.optionsInflueceChannels.push(item.name);
                        }
                        // topics
                        if(!vm.optionsTopics.includes(item.topic)) {
                            vm.optionsTopics.push(item.topic);
                        }
                    })
                    // languages
                    if(!vm.optionsInfluenceLanguages.includes(item.chosen_lang)) {
                        vm.optionsInfluenceLanguages.push(item.chosen_lang);
                    }
                })
            },

            // @CHECK IT !!!
            getRowCount (items, topic, channel, lang) {
                if(topic === null && channel === null && lang === null) {
                    return items.length
                } else {
                    if(channel === null) {
                        if(lang === null) {
                            return items.filter(t => t.status === topic).length
                        } else if (topic === null) {
                            return items.filter(t => t.lang === lang).length
                        } else {
                            return items.filter(t => t.lang === lang && t.type === topic).length
                        }
                    } else if (topic === null){
                        if(lang === null) {
                            return items.filter(t => t.channels.includes(channel)).length
                        } else if (channel === null) {
                            return items.filter(t => t.lang === lang).length
                        } else {
                            return items.filter(t => t.lang === lang && t.channels.includes(channel)).length
                        }
                    } else if (lang === null) {
                        if(topic === null) {
                            return items.filter(t => t.channels.includes(channel)).length
                        } else if (channel === null) {
                            return items.filter(t => t.type === topic).length
                        } else {
                            return items.filter(t => t.type === topic && t.channels.includes(channel)).length
                        }
                    } else {
                        return items.filter(t => t.type === topic && t.channels.includes(channel) && t.lang === lang).length
                    }
                }
            },
        },
        computed: {
            sortOptions () {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => { return { text: f.label, value: f.key } })
            },
        }
    }
</script>