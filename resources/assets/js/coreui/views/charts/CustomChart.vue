<script>
    import { Line } from 'vue-chartjs'
    let vm = {}

    export default {
        extends: Line,
        props: ['data'],
        mounted () {
            vm = this;
            vm.$nextTick(function () {
                this.renderChart({
                    labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [
                        {
                            label                       : '% / Period',
                            backgroundColor             : '#f0f0f0',
                            data                        : vm.data,
                            pointBorderColor            : '#fff',
                            pointBackgroundColor        : '#D44816',
                        },
                    ],
                }, { responsive: true, maintainAspectRatio: false })
            });
        },
    }
</script>
