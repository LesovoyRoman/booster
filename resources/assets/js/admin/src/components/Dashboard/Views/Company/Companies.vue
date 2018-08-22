<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <ul class="content-panel-tabs">
                    <li class="content-tab"><a id="activeCompanies" href="#" :class="{active:'activeCompanies' == selected}" @click="tabIndex = 0; selected = 'activeCompanies'">Active</a></li>
                    <li class="content-tab"><a id="archiveCompanies" href="#" :class="{active:'archiveCompanies' == selected}" @click="tabIndex = 1; selected = 'archiveCompanies'">Archive</a></li>
                </ul>

                <div class="content-filter">
                    <drop-down ref="dropdown" title="Filter">
                        <li><a href="#" @click="changeOptionFilter('Name')">Name</a></li>
                        <li><a href="#" @click="changeOptionFilter('Price')">Price</a></li>
                    </drop-down>
                    <label for="content-value-filter" class="label-content-value-filter"><i class="ti ti-search"></i></label>
                    <input type="text" id="content-value-filter" class="content-value-filter" placeholder="Type name of company you are looking for">
                </div>

                <b-tabs v-model="tabIndex">
                    <b-tab active>
                        <paper-table :title="table1.title" :sub-title="table1.subTitle" :data="table1.data" :columns="table1.columns"></paper-table>
                    </b-tab>
                    <b-tab>
                        <paper-table :title="table2.title" :sub-title="table2.subTitle" :data="table2.data" :columns="table2.columns"></paper-table>
                    </b-tab>
                </b-tabs>

                <div class="pagination-custom" id="pagination-custom">
                    <b-pagination size="sm" :limit="9" hide-goto-end-buttons :total-rows="100" v-model="currentPage" :per-page="10"></b-pagination>
                </div>

            </div>
        </div>

    </div>
</template>
<script>
    import PaperTable from '../../../UIComponents/PaperTable.vue'
    const tableColumns = ['Company', 'Points', 'Check', 'Start', 'End'];
    const tableData1 = [
        {
            company: 'milk',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'sugar',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'tomatoes',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'cheese',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'crisps',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'milk',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'sugar',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'tomatoes',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'cheese',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'crisps',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        }
    ];
    const tableData2 = [
        {
            company: 'sour milk',
            points: '600/400',
            check: 'photo & recognizing',
            start: '07.07.2018',
            end: '07.07.2019'
        },
        {
            company: 'brown sugar',
            points: '500/400',
            check: 'photo & recognizing',
            start: '07.07.2018',
            end: '07.07.2019'
        },
        {
            company: 'tomatoes',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'cheese',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'crisps',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'sour milk',
            points: '600/400',
            check: 'photo & recognizing',
            start: '07.07.2018',
            end: '07.07.2019'
        },
        {
            company: 'brown sugar',
            points: '500/400',
            check: 'photo & recognizing',
            start: '07.07.2018',
            end: '07.07.2019'
        },
        {
            company: 'tomatoes',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'cheese',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        },
        {
            company: 'crisps',
            points: '500/400',
            check: 'photo & recognizing',
            start: '08.08.2018',
            end: '08.08.2019'
        }
    ];

    export default {
        components: {
            PaperTable
        },
        data () {
            return {
                currentPage: 3,
                selected: 'activeCompanies',
                tabIndex: 0,
                table1: {
                    title: 'Stripped Table',
                    subTitle: 'Here is a subtitle for this table',
                    columns: [...tableColumns],
                    data: [...tableData1]
                },
                table2: {
                    title: 'Table on Plain Background',
                    subTitle: 'Here is a subtitle for this table',
                    columns: [...tableColumns],
                    data: [...tableData2]
                }
            }
        },
        methods: {
            changeOptionFilter(opt) {
                this.$refs.dropdown.clickDropDown(opt);
            }
        }
    }

</script>
<style>

</style>