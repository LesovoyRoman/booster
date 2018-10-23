<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                </b-col>

                <b-col v-if="loading">
                    <loading v-if="loading" style="position: fixed; z-index: 9999; left: 0; top: 0; height: 100%; width: 100%; background: rgba(2,2,2,0.70);"></loading>
                </b-col>

                <b-col>
                    <b-card>
                        <b-form-group>
                            <b-input-group>
                                <b-input-group-prepend>
                                    <b-form-select dark v-model="sortBy" :options="sortOptions">
                                        <option slot="first" :value="null">Filter</option>
                                    </b-form-select>
                                    <b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
                                        <option :value="false">Low</option>
                                        <option :value="true">High</option>
                                    </b-form-select>
                                </b-input-group-prepend>
                                <b-form-input v-model="filter" placeholder="Type name company"/>
                                <b-input-group-append>
                                    <b-btn :variant="'primary'" :disabled="!filter" @click="filter = ''">Clear</b-btn>
                                </b-input-group-append>
                            </b-input-group>
                        </b-form-group>

                        <b-table
                                :hover="false"
                                :striped="false"
                                :bordered="false"
                                :small="true"
                                :fixed="false"

                                :filter="filter"
                                :sort-by.sync="sortBy"
                                :sort-desc.sync="sortDesc"
                                :sort-direction="sortDirection"
                                @filtered="onFiltered"

                                responsive="sm"
                                :items="feedbacks"
                                :fields="fields"
                                :current-page="currentPage"
                                :per-page="perPage">
                            <template
                                    slot="name"
                                    slot-scope="data">
                                <router-link :id="id = data.item.id" :data="feedback = data.item" :to="{ name: 'Feedback', params: { feedback: feedback, id: id } }">{{ data.item.name }}</router-link>
                            </template>
                            <template slot="points" slot-scope="data">
                                {{ data.item.points }} / {{ data.item.points_checked }}
                            </template>
                            <template
                                    slot="satisfied"
                                    slot-scope="data" justified="center">
                                        <span :variant="getBadge(data.item.satisfied)">
                                            <i v-for="k in 5" v-if="data.item.satisfied >= 75" class="star_active fa fa-star"></i>
                                            <i v-for="k in 4" v-if="data.item.satisfied > 60 && data.item.satisfied < 75" class="star_active fa fa-star"></i>
                                            <i v-for="k in 3" v-if="data.item.satisfied <= 60" class="star_active fa fa-star"></i>
                                            <i v-for="k in 1" v-if="data.item.satisfied > 60 && data.item.satisfied < 75" class="fa fa-star"></i>
                                            <i v-for="k in 2" v-if="data.item.satisfied <= 60" class="fa fa-star"></i>
                                        </span>
                                <span v-if="data.item.satisfied"> {{ data.item.satisfied }}%</span>
                            </template>
                        </b-table>
                        <nav>
                            <b-pagination
                                    :total-rows="getRowCount(feedbacks)"
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
    import Loading from 'vue-loading-spinner/src/components/Circle8'
    let vm = {};

    export default {
        name: 'Feedbacks',
        components: {
            Loading
        },
        data () {
            return {
                header: 'Feedbacks',
                loading: false,

                feedbacks: [
                    { id: 1, name: 'Snacks', participants: '100', points: '30000', satisfied: 5 },
                ],
                fields: [
                    { key: 'id', label: '№' },
                    { key: 'name', sortable: true, label: 'Name' },
                    { key: 'participants',  sortable: true, label: 'Participants' },
                    { key: 'points', sortable: true, label: 'Points', 'class': 'table_points' },
                    { key: 'satisfied', 'class': 'text-center', sortable: true, label: 'Satisfied' },
                ],
                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

                dataRequst: {fields: ['id', 'name', 'participants', 'points', 'points_checked', 'satisfied']}
            }
        },
        computed: {
            sortOptions () {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => { return { text: f.label, value: f.key } })
            }
        },
        methods: {
            getBadge (satisfied) {
                return satisfied >= 75 ? 'success'
                    : satisfied > 60 && satisfied < 75 ? 'warning'
                        : satisfied <= 60 ? 'danger' : 'primary'
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
        created(){
            vm = this;
            this.loading = true;
            axios.post('/getAllCampaigns', vm.dataRequst).then(response => {
                this.loading = false;
                if(response.data.campaigns instanceof Array) {
                    this.feedbacks = response.data.campaigns
                }
                if(response.data.errors){
                    vm.$swal('Unfortunately:', response.data.errors, 'error')
                }
            }).catch( err => {
                this.loading = false;
                this.loading = false;
                console.log(err.message)
            })
        },
    }
</script>