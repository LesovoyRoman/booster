<script>
    import { Line } from 'vue-chartjs'
    let vm = {}

    export default {
        extends: Line,
        props: ['data'],
        mounted () {
            vm = this;
            this.renderChart({
                labels  : ['20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31'],
                datasets: [
                    {
                        label                       : '% / Period',
                        backgroundColor             : '#f0f0f0',
                        data                        : vm.data,
                        pointBorderColor            : '#fff',
                        pointBackgroundColor        : '#D44816',

                    },
                ],
            }, { responsive: false, maintainAspectRatio: true })
        },
    }
</script>
