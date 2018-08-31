<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
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
                                    slot="campaign_name"
                                    slot-scope="data">
                                <router-link :data="feedback = data.item" :to="{ name: 'Feedback', params: { feedback } }">{{ data.item.campaign_name }}</router-link>
                            </template>
                            <template
                                    slot="status"
                                    slot-scope="data" justified="center">
                                        <span :variant="getBadge(data.item.status)" v-if="data.item.status === '5'">
                                            <i class="fa fa-star star_active"></i>
                                            <i class="fa fa-star star_active"></i>
                                            <i class="fa fa-star star_active"></i>
                                            <i class="fa fa-star star_active"></i>
                                            <i class="fa fa-star star_active"></i>
                                        </span>
                                <span :variant="getBadge(data.item.status)" v-if="data.item.status === '4'">
                                            <i class="fa fa-star star_active"></i>
                                            <i class="fa fa-star star_active"></i>
                                            <i class="fa fa-star star_active"></i>
                                            <i class="fa fa-star star_active"></i>
                                            <i class="fa fa-star"></i>
                                        </span>
                                <span :variant="getBadge(data.item.status)" v-if="data.item.status === '3'">
                                            <i class="fa fa-star star_active"></i>
                                            <i class="fa fa-star star_active"></i>
                                            <i class="fa fa-star star_active"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </span>

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
    const shuffleArray = (array) => {
        /*for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1))
            const temp = array[i]
            array[i] = array[j]
            array[j] = temp
        }*/
        return array
    }

    export default {
        name: 'Feedbacks',
        data () {
            return {
                header: 'Feedbacks',

                feedbacks: shuffleArray([
                    { id: 1, campaign_name: 'Snacks', participants: '100', status: '5' },
                    { id: 2, campaign_name: 'Snacks', participants: '200', status: '5' },
                    { id: 3, campaign_name: 'Snacks', participants: '300', status: '5' },
                    { id: 4, campaign_name: 'Snacks', participants: '500', status: '5' },
                    { id: 5, campaign_name: 'Snacks', participants: '1000', status: '5' },
                    { id: 6, campaign_name: 'Snacks', participants: '100', status: '5' },
                    { id: 7, campaign_name: 'Snacks', participants: '200', status: '5' },
                    { id: 8, campaign_name: 'Snacks', participants: '300', status: '5' },
                    { id: 9, campaign_name: 'Snacks', participants: '500', status: '5' },
                    { id: 10, campaign_name: 'Snacks', participants: '100', status: '5' },
                    { id: 11, campaign_name: 'Snacks', participants: '200', status: '5' },
                    { id: 12, campaign_name: 'Snacks', participants: '300', status: '4' },
                    { id: 13, campaign_name: 'Snacks', participants: '500', status: '5' },
                    { id: 14, campaign_name: 'Snacks', participants: '1000', status: '5' },
                    { id: 15, campaign_name: 'Snacks', participants: '100', status: '5' },
                    { id: 16, campaign_name: 'Snacks', participants: '200', status: '5' },
                    { id: 17, campaign_name: 'Snacks', participants: '300', status: '5' },
                    { id: 18, campaign_name: 'Snacks', participants: '500', status: '5' },
                    { id: 19, campaign_name: 'Snacks', participants: '1000', status: '4' },
                    { id: 20, campaign_name: 'Snacks', participants: '100', status: '5' },
                    { id: 21, campaign_name: 'Snacks', participants: '200', status: '5' },
                    { id: 22, campaign_name: 'Snacks', participants: '300', status: '5' },
                    { id: 23, campaign_name: 'Snacks', participants: '500', status: '5' },
                    { id: 24, campaign_name: 'Snacks', participants: '100', status: '3' },
                    { id: 25, campaign_name: 'Snacks', participants: '200', status: '5' },
                    { id: 26, campaign_name: 'Snacks', participants: '300', status: '3' },
                    { id: 27, campaign_name: 'Snacks', participants: '500', status: '5' },
                    { id: 28, campaign_name: 'Snacks', participants: '1000', status: '5' },
                    { id: 29, campaign_name: 'Snacks', participants: '100', status: '5' },
                    { id: 30, campaign_name: 'Snacks', participants: '200', status: '5' },
                    { id: 31, campaign_name: 'Snacks', participants: '300', status: '5' },
                    { id: 32, campaign_name: 'Snacks', participants: '500', status: '5' },
                    { id: 33, campaign_name: 'Snacks', participants: '1000', status: '5' },
                ]),
                fields: [
                    { key: 'id', label: '№' },
                    { key: 'campaign_name', sortable: true, label: 'Name' },
                    { key: 'participants',  sortable: true, label: 'Participants' },
                    { key: 'status', 'class': 'text-center', sortable: true, label: 'Status' },
                ],
                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,

                filter: null,
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',

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