<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card campaign-card campaign-results">
                <div class="form-group">
                    <div class="form-group-part part-sm">
                        <b-form-select size="sm" v-model="selectedCampaigns" :options="allCampaigns" class="mb-3"></b-form-select>
                    </div>
                </div>

                <chart-card v-if="show" :chart-data="currentCampaignsChart" :chart-options="campaignsCharts.options">
                    <h4 class="title" slot="title">Campaigns statistic</h4>
                    <span slot="subTitle"> 24 Hours performance</span>
                    <span slot="footer">
        <i class="ti-reload"></i> Updated 3 minutes ago</span>
                    <div slot="legend">

                    </div>
                </chart-card>

                <paper-table :title="table1.title" :sub-title="table1.subTitle" :data="table1.data" :columns="table1.columns"></paper-table>

                <div class="pagination-custom" id="pagination-custom">
                    <b-pagination size="sm" :limit="9" hide-goto-end-buttons :total-rows="100" v-model="currentPage" :per-page="10"></b-pagination>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import PaperTable from '../../../UIComponents/PaperTable.vue'
    import StatsCard from '../../../UIComponents/Cards/StatsCard.vue'
    import ChartCard from '../../../UIComponents/Cards/ChartCard.vue'

    const tableColumns = ['Campaign', 'Blogger', 'All points', 'Satisfied'];
    const tableData1 = [
        {
            campaign: 'milk',
            blogger: 'Chet Faker',
            all_points: '100500',
            satisfied: '45000 (45%)',
        },
        {
            campaign: 'milk',
            blogger: 'Chet Faker',
            all_points: '100500',
            satisfied: '45000 (45%)',
        },
        {
            campaign: 'milk',
            blogger: 'Chet Faker',
            all_points: '100500',
            satisfied: '45000 (45%)',
        },
        {
            campaign: 'milk',
            blogger: 'Chet Faker',
            all_points: '100500',
            satisfied: '45000 (45%)',
        },
        {
            campaign: 'milk',
            blogger: 'Chet Faker',
            all_points: '100500',
            satisfied: '45000 (45%)',
        },
        {
            campaign: 'milk',
            blogger: 'Chet Faker',
            all_points: '100500',
            satisfied: '45000 (45%)',
        },
        {
            campaign: 'milk',
            blogger: 'Chet Faker',
            all_points: '100500',
            satisfied: '45000 (45%)',
        },
        {
            campaign: 'milk',
            blogger: 'Chet Faker',
            all_points: '100500',
            satisfied: '45000 (45%)',
        },
        {
            campaign: 'milk',
            blogger: 'Chet Faker',
            all_points: '100500',
            satisfied: '45000 (45%)',
        },
        {
            campaign: 'milk',
            blogger: 'Chet Faker',
            all_points: '100500',
            satisfied: '45000 (45%)',
        }
    ];

    export default {
        components: {
            StatsCard,
            ChartCard,
            PaperTable
        },
        data() {
            return {
                currentPage: 3,
                tabIndex: 0,
                table1: {
                    title: 'Stripped Table',
                    subTitle: 'Here is a subtitle for this table',
                    columns: [...tableColumns],
                    data: [...tableData1]
                },
                selectedCampaigns: 1,
                show: true,
                allCampaigns: [
                    {value: 1, text: 'All campaigns'},
                    {value: 2, text: 'Last campaign'}
                ],
                campaignsCharts: {
                    data: {
                        1: {
                            labels: ['9:00AM', '12:00AM', '3:00PM', '6:00PM', '9:00PM', '12:00PM', '3:00AM', '6:00AM'],
                            series: [
                                [287, 385, 490, 562, 594, 626, 698, 895, 952],
                                [67, 152, 193, 240, 387, 435, 535, 642, 744],
                                [23, 113, 67, 108, 190, 239, 307, 410, 410]
                            ]
                        },
                        2: {
                            labels: ['9:00AM', '12:00AM', '3:00PM', '6:00PM', '9:00PM', '12:00PM', '3:00AM', '6:00AM'],
                            series: [
                                [456, 385, 390, 502, 394, 726, 598, 895, 952],
                                [93, 252, 293, 340, 437, 535, 735, 542, 444],
                                [123, 213, 167, 508, 290, 439, 607, 710, 810]
                            ]
                        }
                    },
                    options: {
                        low: 0,
                        high: 1000,
                        showArea: true,
                        height: '245px',
                        axisX: {
                            showGrid: true
                        },
                        lineSmooth: this.$Chartist.Interpolation.simple({
                            divisor: 3
                        }),
                        showLine: true,
                        showPoint: true
                    }
                },
                currentCampaignsChart: {
                    labels: ['9:00AM', '12:00AM', '3:00PM', '6:00PM', '9:00PM', '12:00PM', '3:00AM', '6:00AM'],
                    series: [
                        [287, 385, 490, 562, 594, 626, 698, 895, 952],
                        [67, 152, 193, 240, 387, 435, 535, 642, 744],
                        [23, 113, 67, 108, 190, 239, 307, 410, 410]
                    ]
                },
            }
        },
        watch: {
            selectedCampaigns(val) {
                this.currentCampaignsChart = this.campaignsCharts.data[val];
                let self = this;
                self.show = false;

                Vue.nextTick(function (){
                    self.show = true;
                })
            }
        }
    }
</script>