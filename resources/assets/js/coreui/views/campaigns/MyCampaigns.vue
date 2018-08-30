<template>
    <div class="wrapper">
        <div class="animated fadeIn">
            <b-row>
                <b-col sm="12" md="12">
                    <h2 class="h2">{{ header }}</h2>

                    <b-card>
                        <b-tabs pills card>
                            <b-tab title="Active" active>

                                <b-form-group>
                                    <b-input-group>
                                        <!-- Attach Left button -->
                                        <b-input-group-prepend>
                                            <b-dropdown
                                                    text="Filter"
                                                    variant="primary">
                                                <b-dropdown-item>Name</b-dropdown-item>
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
                                        :items="activeTable"
                                        :fields="fields"
                                        :current-page="currentPage"
                                        :per-page="perPage">
                                    <template
                                            slot="status"
                                            slot-scope="data" justified="center">
                                        <b-badge :variant="getBadge(data.item.status)">{{ data.item.status }}</b-badge>
                                    </template>
                                    <template slot="change" justified="center" slot-scope="row">
                                        <b-button size="sm" class="custom_btn_change" :variant="'primary'">
                                            <i class="icon-pencil"></i>
                                        </b-button>
                                    </template>
                                </b-table>
                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(activeTable)"
                                            :per-page="perPage"
                                            v-model="currentPage"
                                            prev-text="Prev"
                                            align="center"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>

                            </b-tab>

                            <b-tab title="Archive">

                                <b-form-group>
                                    <b-input-group>
                                        <!-- Attach Left button -->
                                        <b-input-group-prepend>
                                            <b-dropdown
                                                    text="Filter"
                                                    variant="primary">
                                                <b-dropdown-item>Name</b-dropdown-item>
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
                                        :items="archiveTable"
                                        :fields="fields"
                                        :current-page="currentPage"
                                        :per-page="perPage">
                                    <template
                                            slot="status"
                                            slot-scope="data">
                                        <b-badge :variant="getBadge(data.item.status)">{{ data.item.status }}</b-badge>
                                    </template>
                                    <template slot="change" justified="center" slot-scope="row">
                                        <b-button size="sm" class="custom_btn_change" :variant="'primary'">
                                            <i class="icon-pencil"></i>
                                        </b-button>
                                    </template>
                                </b-table>
                                <nav>
                                    <b-pagination
                                            :total-rows="getRowCount(archiveTable)"
                                            :per-page="perPage"
                                            align="center"
                                            v-model="currentPage"
                                            prev-text="Prev"
                                            next-text="Next"
                                            hide-goto-end-buttons/>
                                </nav>

                            </b-tab>
                        </b-tabs>
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
        name: 'MyCampaigns',
        data: () => {
            return {
                header: 'My campaigns',
                activeTable: shuffleArray([
                    { campaign_name: 'Snacks', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Snacks', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '3', change: '' },
                    { campaign_name: 'Snacks', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Snacks', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Snacks', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Snacks', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Snacks', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '3', change: '' },
                    { campaign_name: 'Snacks', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Snacks', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Snacks', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Snacks', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Snacks', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '3', change: '' },
                    { campaign_name: 'Snacks', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Snacks', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Snacks', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Snacks', points: '40000/30000', check_type: 'Photo', start: '20/08/2018', finish: '31/12/2018', status: '5', change: '' },
                    { campaign_name: 'Snacks', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '3', change: '' },
                    { campaign_name: 'Snacks', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Snacks', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Snacks', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Snacks', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Snacks', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: '3', change: '' },
                    { campaign_name: 'Snacks', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Snacks', points: '60000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Snacks', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                ]),
                archiveTable: shuffleArray([
                    { campaign_name: 'Cheese', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Cheese', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '3', change: '' },
                    { campaign_name: 'Cheese', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Cheese', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Cheese', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Cheese', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Cheese', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '3', change: '' },
                    { campaign_name: 'Cheese', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Cheese', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Cheese', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Cheese', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Cheese', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '3', change: '' },
                    { campaign_name: 'Cheese', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Cheese', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Cheese', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Cheese', points: '40000/30000', check_type: 'Photo', start: '20/08/2018', finish: '31/12/2018', status: '5', change: '' },
                    { campaign_name: 'Cheese', points: '70000/30000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '3', change: '' },
                    { campaign_name: 'Cheese', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Cheese', points: '60000/50000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Cheese', points: '50000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Cheese', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Cheese', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: '3', change: '' },
                    { campaign_name: 'Cheese', points: '70000/30000', check_type: 'Serial number',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                    { campaign_name: 'Cheese', points: '60000/35000', check_type: 'Photo & number',  start: '20/08/2018', finish: '31/12/2018',  status: '5', change: '' },
                    { campaign_name: 'Cheese', points: '40000/30000', check_type: 'Photo',  start: '20/08/2018', finish: '31/12/2018',  status: '4', change: '' },
                ]),
                fields: [
                    { key: 'campaign_name' },
                    { key: 'points' },
                    { key: 'check_type' },
                    { key: 'start' },
                    { key: 'finish' },
                    { key: 'status', 'class': 'text-center' },
                    { key: 'change', 'class': 'text-center' }
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