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

                    </b-card>
                </b-col>
            </b-row>
        </div>
    </div>
</template>

<script>
    let vm = {};

    export default {
        name: 'Influencers',
        data() {
            return {
                header: 'Influencers',
                filterChannels: null,
                influencer_topic: null,
                influencersList: true,
                influencersCards: false,

                optionsInflueceChannels: {},
                optionsTopics: {},

                checkbox_group: {},
                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                selected: [],
                allSelected: false,
                userIds: [],

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',


            }
        },
        created() {
            vm = this;
        },
        methods: {
            filterMedia(val){
                val ? vm.influencersList = false : vm.influencersList = true;
                val ? vm.influencersCards = true : vm.influencersCards = false;
            }
        },
        computed: {

        }
    }
</script>