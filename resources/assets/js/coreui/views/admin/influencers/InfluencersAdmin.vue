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
                                    <i style="cursor: pointer" :class="data.item.star ? 'fa fa-star star_influencer star_active' : 'fa fa-star star_influencer'"  @click="data.item.star = !data.item.star"></i>
                                    <keep-alive><img :src="data.item.photo" alt="photo_influencer" class="photo_influencer_table"></keep-alive>
                                </div>
                                <div class="influencer-name-block">
                                    <router-link :id="id = data.item.id" :data="influencer = data.item" :to="{ name: 'Influencer', params: { influencer: influencer, id: id, campaign_name: '' } }"><span class="link_influencer">{{ data.item.name }}</span></router-link>
                                    <br><span>{{ data.item.type }}</span>
                                </div>
                            </template>
                            <template slot="channels" slot-scope="data">
                                <div class="icons_influencer">
                                    <i v-for="itemIcon in data.item.channels" :class="'fa fa-' + itemIcon"></i>
                                </div>
                            </template>
                            <template slot="influence" slot-scope="data">
                                <span class="showsTableCards">Influence coefficient:</span><span class="font500"> {{ data.item.influence }}%</span>
                            </template>
                            <template slot="auditory" slot-scope="data">
                                <span class="showsTableCards">Auditory:</span> {{ data.item.auditory }}
                            </template>
                            <template slot="age" slot-scope="data">
                                <span class="showsTableCards">Age:</span> {{ data.item.age }}
                            </template>

                            <template slot="action" slot-scope="row">
                                <b-button size="sm"  @click="row.item.action = !row.item.action" class="custom_btn_change" :variant="'primary'">
                                    <i :class="row.item.action ? 'fa fa-stop-circle' : 'fa fa-play-circle'"></i>
                                </b-button>
                                <b-button size="sm" style="margin-left: 10px" @click="removeElement(row)" class="custom_btn_change" :variant="'primary'">
                                    <i class="icon-close"></i>
                                </b-button>
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
        
    </div>
</template>

<script>
    let vm = {};

    export default {
        name: 'InfluencersAdmin',
        data() {
            return {
                header: 'Influencers',
                filterChannels: null,
                influencer_topic: null,
                influencer_lang: null,
                influencersList: true,
                influencersCards: false,
                chosenInfluencer: {},


                optionsInfluenceLanguages: ['Russian', 'English'],
                optionsInflueceChannels: ['twitter', 'facebook', 'youtube', 'behance'],
                optionsTopics: ['Wizard', 'Fashion', 'Nature'],

                campaignsForOffer: ['Snacks', 'Cheese'],
                chosenCampaignOffer: 'Snacks',

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

                influencers: [
                    { id: 1, photo: '../images/6.jpg', name: 'Harry Potter', type: 'Wizard', channels: ['twitter', 'facebook', 'youtube'], auditory: 5000000, age: '18-60', influence: 75, star: true, lang: 'Russian', action: false },
                    { id: 2, photo: '../images/7.jpg', name: 'Ron Weasley', type: 'Wizard', channels: ['twitter', 'youtube'], auditory: 500000, age: '20-50', influence: 60, star: false, lang: 'English', action: true },
                    { id: 3, photo: '../images/8.jpg', name: 'Drako Malfoy', type: 'Fashion', channels: ['facebook'], auditory: 100500, age: '20-50', influence: 50, star: true, lang: 'Russian', action: true },
                    { id: 4, photo: '../images/6.jpg', name: 'Harry Potter', type: 'Wizard', channels: ['twitter', 'facebook', 'youtube'], auditory: 5000000, age: '18-60', influence: 75, star: true, lang: 'English', action: false },
                    { id: 5, photo: '../images/7.jpg', name: 'Ron Weasley', type: 'Wizard', channels: ['twitter', 'youtube'], auditory: 500000, age: '20-50', influence: 60, star: false, lang: 'English', action: true },
                    { id: 6, photo: '../images/8.jpg', name: 'Drako Malfoy', type: 'Fashion', channels: ['facebook'], auditory: 100500, age: '20-50', influence: 50, star: true, lang: 'Russian', action: true },
                    { id: 7, photo: '../images/6.jpg', name: 'Harry Potter', type: 'Wizard', channels: ['twitter', 'facebook', 'youtube'], auditory: 5000000, age: '18-60', influence: 75, star: true, lang: 'English', action: true },
                    { id: 8, photo: '../images/7.jpg', name: 'Ron Weasley', type: 'Wizard', channels: ['twitter', 'youtube'], auditory: 500000, age: '20-50', influence: 60, star: false, lang: 'English', action: false },
                    { id: 9, photo: '../images/8.jpg', name: 'Drako Malfoy', type: 'Fashion', channels: ['facebook'], auditory: 100500, age: '20-50', influence: 50, star: true, lang: 'Russian', action: true },
                    { id: 10, photo: '../images/8.jpg', name: 'Drako Malfoy', type: 'Fashion', channels: ['facebook'], auditory: 100500, age: '20-50', influence: 50, star: true, lang: 'English', action: false },
                    { id: 11, photo: '../images/8.jpg', name: 'Drako Malfoy', type: 'Fashion', channels: ['facebook'], auditory: 100500, age: '20-50', influence: 50, star: true, lang: 'English', action: true },
                ],
                fields: [
                    { key: 'name', sortable: true, 'class': 'name_influncer' },
                    { key: 'channels', sortable: false, 'class': 'channels_influencer' },
                    { key: 'auditory', sortable: true, 'class':'auditory_influencer' },
                    { key: 'age', sortable: true, 'class':'auditory_age_influencer' },
                    { key: 'influence', sortable: true, 'class': 'influence_influencer' },
                    { key: 'action', label: '', 'class': 'table_label_hidden'},

                ]
            }
        },
        created() {
            vm = this;
        },
        methods: {
            filterMedia(val){
                val ? vm.influencersList = false : vm.influencersList = true;
                val ? vm.influencersCards = true : vm.influencersCards = false;
                val ? vm.perPage = 9 : vm.perPage = 10;
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
            removeElement: function (item) {
                if(confirm("Are you sure?")) {
                    this.influencers.splice(item.index, 1);
                }
            },

            select: function() {
                vm.allSelected = false;
            },
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