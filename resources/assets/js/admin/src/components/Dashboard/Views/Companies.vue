<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <ul class="content-panel-tabs">
                    <li class="content-tab"><a href="#" class="active">Active</a></li>
                    <li class="content-tab"><a href="#">Archive</a></li>
                </ul>

                <!--<div class="content-filter">
                    <select name="" id="" class="content-select-filter">
                        <option value="">Name</option>
                        <option value="">Price</option>
                    </select>
                    <input type="text" class="content-value-filter">
                </div>-->

                <paper-table :title="table1.title" :sub-title="table1.subTitle" :data="table1.data" :columns="table1.columns">

                </paper-table>
            </div>
        </div>

    </div>
</template>
<script>
    import PaperTable from '../../UIComponents/PaperTable.vue'
    const tableColumns = ['Company', 'Points', 'Check', 'Start', 'End'];
    const tableData = [{
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
        }];

    export default {
        components: {
            PaperTable
        },
        data () {
            return {
                table1: {
                    title: 'Stripped Table',
                    subTitle: 'Here is a subtitle for this table',
                    columns: [...tableColumns],
                    data: [...tableData]
                },
                table2: {
                    title: 'Table on Plain Background',
                    subTitle: 'Here is a subtitle for this table',
                    columns: [...tableColumns],
                    data: [...tableData]
                }
            }
        },
    }

</script>
<style>

</style>