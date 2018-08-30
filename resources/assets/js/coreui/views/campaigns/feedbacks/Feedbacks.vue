<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>
                    <b-card>

                        <b-form-group>
                            <b-input-group>
                                <!-- Attach Left button -->
                                <b-input-group-prepend>
                                    <b-dropdown
                                            text="Filter"
                                            variant="primary">
                                        <b-dropdown-item>Name</b-dropdown-item>
                                        <b-dropdown-item>Participants</b-dropdown-item>
                                        <b-dropdown-item>Status</b-dropdown-item>
                                    </b-dropdown>
                                </b-input-group-prepend>
                                <b-form-input placeholder="Type name company or influencer"/>
                            </b-input-group>
                        </b-form-group>

                        <b-table
                                :hover="false"
                                :striped="false"
                                :bordered="false"
                                :small="true"
                                :fixed="false"
                                responsive="sm"
                                :items="feedbacks"
                                :fields="fields"
                                :current-page="currentPage"
                                :per-page="perPage">
                            <template
                                    slot="campaign_name"
                                    slot-scope="data">
                                <!--<router-link v-bind:to="'/campaigns/feedbacks/feedback'">-->{{ data.item.campaign_name }}<!--</router-link>-->
                            </template>
                            <template
                                    slot="status"
                                    slot-scope="data">
                                <b-badge :variant="getBadge(data.item.status)">{{ data.item.status }}</b-badge>
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
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1))
            const temp = array[i]
            array[i] = array[j]
            array[j] = temp
        }
        return array
    }

    export default {
        name: 'Feedbacks',
        data () {
            return {
                header: 'Feedbacks',

                feedbacks: shuffleArray([
                    { campaign_name: 'Snacks', participants: '100', status: '5' },
                    { campaign_name: 'Snacks', participants: '200', status: '5' },
                    { campaign_name: 'Snacks', participants: '300', status: '5' },
                    { campaign_name: 'Snacks', participants: '500', status: '5' },
                    { campaign_name: 'Snacks', participants: '1000', status: '5' },
                    { campaign_name: 'Snacks', participants: '100', status: '5' },
                    { campaign_name: 'Snacks', participants: '200', status: '5' },
                    { campaign_name: 'Snacks', participants: '300', status: '5' },
                    { campaign_name: 'Snacks', participants: '500', status: '5' },
                    { campaign_name: 'Snacks', participants: '100', status: '5' },
                    { campaign_name: 'Snacks', participants: '200', status: '5' },
                    { campaign_name: 'Snacks', participants: '300', status: '5' },
                    { campaign_name: 'Snacks', participants: '500', status: '5' },
                    { campaign_name: 'Snacks', participants: '1000', status: '5' },
                    { campaign_name: 'Snacks', participants: '100', status: '5' },
                    { campaign_name: 'Snacks', participants: '200', status: '5' },
                    { campaign_name: 'Snacks', participants: '300', status: '5' },
                    { campaign_name: 'Snacks', participants: '500', status: '5' },
                    { campaign_name: 'Snacks', participants: '1000', status: '5' },
                    { campaign_name: 'Snacks', participants: '100', status: '5' },
                    { campaign_name: 'Snacks', participants: '200', status: '5' },
                    { campaign_name: 'Snacks', participants: '300', status: '5' },
                    { campaign_name: 'Snacks', participants: '500', status: '5' },
                    { campaign_name: 'Snacks', participants: '100', status: '5' },
                    { campaign_name: 'Snacks', participants: '200', status: '5' },
                    { campaign_name: 'Snacks', participants: '300', status: '5' },
                    { campaign_name: 'Snacks', participants: '500', status: '5' },
                    { campaign_name: 'Snacks', participants: '1000', status: '5' },
                    { campaign_name: 'Snacks', participants: '100', status: '5' },
                    { campaign_name: 'Snacks', participants: '200', status: '5' },
                    { campaign_name: 'Snacks', participants: '300', status: '5' },
                    { campaign_name: 'Snacks', participants: '500', status: '5' },
                    { campaign_name: 'Snacks', participants: '1000', status: '5' },
                ]),
                fields: [
                    { key: 'campaign_name' },
                    { key: 'participants' },
                    { key: 'status', 'class': 'text-center' },
                ],
                currentPage: 1,
                perPage    : 10,
                totalRows  : 0,
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
        },
    }
</script>