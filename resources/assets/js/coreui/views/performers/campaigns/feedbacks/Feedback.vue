<template>
    <div class="wrapper" :feedback="computedFeedback">
        <div class="animated fadeIn" v-if="feedback">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }} of campaign {{ feedback.campaign_name }}</h2>
                </b-col>

                <b-col
                        sm="12"
                        md="12">
                    <b-card id="feedback">

                        <b-form-group>
                            <b-input-group>
                                <b-input-group-prepend>
                                    <!--<b-form-select dark v-model="influencer_name" :options="optionsUniqueInfluencers">
                                        <option slot="first" :value="null">All campaigns</option>
                                    </b-form-select>-->
                                </b-input-group-prepend>
                                <b-input-group-prepend>
                                    <b-form-select dark v-model="sortBy" :options="sortOptions">
                                        <option slot="first" :value="null">Filter</option>
                                    </b-form-select>
                                    <b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
                                        <option :value="false">Low</option>
                                        <option :value="true">High</option>
                                    </b-form-select>
                                </b-input-group-prepend>
                                <b-form-input v-model="filter" placeholder="Type what you are looking for"/>
                                <b-input-group-append>
                                    <b-btn :variant="'primary'" :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                </b-input-group-append>
                            </b-input-group>
                        </b-form-group>

                        <p class="card-header-custom">Middle grade <span class="font500">{{ feedback.status }}</span></p>

                        <div class="stars">
                            <i v-for="k in 5" class="star_active fa fa-star"></i>
                            <span class="title_stars">Set up 100 people (60%)</span>
                            <br>
                            <i v-for="k in 4" class="star_active fa fa-star"></i><i class="fa fa-star"></i>
                            <span class="title_stars">Set up 70 people (35%)</span>
                            <br>
                            <i v-for="k in 3" class="star_active fa fa-star"></i><i v-for="k in 2" class="fa fa-star"></i>
                            <span class="title_stars">Set up 30 people (15%)</span>
                            <br>
                            <i v-for="k in 2" class="star_active fa fa-star"></i><i v-for="k in 3" class="fa fa-star"></i>
                            <span class="title_stars">Set up 20 people (10%)</span>
                            <br>
                            <i class="star_active fa fa-star"></i><i v-for="k in 4" class="fa fa-star"></i>
                            <span class="title_stars">Set up 2 people (1%)</span>
                        </div>

                        <div class="divider_custom"></div>

                        <b-table
                                :hover="false"
                                :striped="false"
                                :bordered="false"
                                :small="true"
                                :fixed="false"
                                stacked

                                :filter="filter"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                @filtered="onFiltered"

                                responsive="sm"
                                :items="tmpFeedbacks"
                                :fields="fields"
                                :current-page="currentPage"
                                :per-page="perPage">
                            <template slot="id" v-show="false" slot-scope="data">

                            </template>
                            <template slot="fromInfluencer" slot-scope="data">
                                From influencer:
                                <router-link :id="id = data.item.id" :name="data.item.name = data.item.fromInfluencer" :data="influencer = data.item" :to="{ name: 'Influencer', params: { influencer: influencer, idInfluencer: id, campaign_name: campaign_name } }">{{ data.item.fromInfluencer }}</router-link>
                            </template>
                            <template
                                    slot="status"
                                    slot-scope="data">
                                        <span :variant="getBadge(data.item.status)">
                                            <i v-for="k in data.item.status" class="star_active fa fa-star"></i>
                                            <i v-for="k in 2" v-if="data.item.status === 3" class="fa fa-star"></i>
                                            <i v-if="data.item.status === 4" class="fa fa-star"></i>
                                        </span>
                                <span v-if="data.item.status === 3"> (60%)</span>
                                <span v-if="data.item.status === 4"> (80%)</span>
                                <span v-if="data.item.status === 5"> (100%)</span>
                            </template>
                        </b-table>
                        <nav>
                            <b-pagination
                                    :total-rows="getRowCount(tmpFeedbacks)"
                                    :per-page="perPage"
                                    v-model="currentPage"
                                    prev-text="Prev"
                                    align="center"
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
        props: ['feedback', 'campaign_name'],
        name: 'Feedback',
        data () {
            return {
                header: 'Feedback',
                influencer_name: null,

                tmpFeedbacks: [
                    { id: 1, name: 'Olga M.', fromInfluencer: 'Angelika Martynenko', status: 4, date: '2017.10.10', text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, nesciunt vitae! Culpa, explicabo laudantium odio quasi rerum sit soluta vero.'},
                    { id: 2, name: 'Oleg V.', fromInfluencer: 'Max Gulkin', status: 3, date: '2018.09.09', text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, nesciunt vitae! Culpa, explicabo laudantium odio quasi rerum sit soluta vero.'},
                    { id: 3, name: 'Maximus', fromInfluencer: 'Angelika Martynenko', status: 4, date: '2019.02.03', text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, nesciunt vitae! Culpa, explicabo laudantium odio quasi rerum sit soluta vero.'},
                    { id: 4, name: 'Somebody', fromInfluencer: 'Angelika Martynenko', status: 5, date: '2019.03.02', text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, nesciunt vitae! Culpa, explicabo laudantium odio quasi rerum sit soluta vero.'},
                    { id: 5, name: 'Olga', fromInfluencer: 'Angelika Martynenko', status: 4, date: '2018.10.08', text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, nesciunt vitae! Culpa, explicabo laudantium odio quasi rerum sit soluta vero.'},
                    { id: 6, name: 'Oleg', fromInfluencer: 'Max Gulkin', status: 3, date: '2017.12.12', text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, nesciunt vitae! Culpa, explicabo laudantium odio quasi rerum sit soluta vero.'},
                    { id: 7, name: 'Max', fromInfluencer: 'Angelika Martynenko', status: 4, date: '2016.12.12', text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, nesciunt vitae! Culpa, explicabo laudantium odio quasi rerum sit soluta vero.'},
                    { id: 8, name: 'Maximus', fromInfluencer: 'Maria Rasputina', status: 5, date: '2015.12.31', text: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magnam, nesciunt vitae! Culpa, explicabo laudantium odio quasi rerum sit soluta vero.'},
                ],

                fields: [
                    { key: 'id', labelOption: '№', label: '', 'class': 'comment_id' },
                    { key: 'name', sortable: true, labelOption: 'Name', label: '', 'class': 'comment_username'  },
                    { key: 'fromInfluencer', sortable: true, labelOption: 'Iinfluencer', label: '', 'class': 'fromInfluencer' },
                    { key: 'status', 'class': 'text-left', sortable: true, labelOption: 'Satisfied', label: '',  },
                    { key: 'text',  labelOption: 'Comment text', label: '', 'class': 'comment_text' },
                    { key: 'date', labelOption: 'Date', sortable: true, label: '', 'class': 'comment_time'}
                ],
                currentPage: 1,
                perPage    : 4,
                totalRows  : 0,

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
            }
        },
        beforeCreate(){
            vm = this;
        },
        computed: {
            computedFeedback: function() {
                if(typeof this.feedback === 'undefined') {
                   // vm.$router.push('/campaigns/feedbacks/all-feedbacks');
                    vm.$router.go(-1)
                }
            },
            sortOptions () {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => { return { text: f.labelOption, value: f.key } })
            }
        },
        methods: {
            getBadge (status) {
                return status === '5' ? 'success'
                    : status === '4' ? 'warning'
                        : status === '3' ? 'danger' : 'primary'
            },
            getRowCount (items) {
                return items.length
            },
            onFiltered (filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }
        },
    }
</script>