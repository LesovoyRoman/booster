<script>
    import { Bar } from 'vue-chartjs'
    let vm = {}

    export default {
        extends: Bar,
        props: ['data'],
        mounted () {
            vm = this;
            // Overwriting base render method with actual data.
            this.renderChart({
                labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [
                    {
                        label          : 'Rating',
                        backgroundColor: '#D44816',
                        data           : vm.data,
                    },
                ],
            }, {
                /*maintainAspectRatio: false,*/
                legend: {
                    display: false,
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            drawOnChartArea: false,
                        },
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            /*maxTicksLimit: 5,
                            stepSize: Math.ceil(250 / 5),
                            max: 250,*/
                        },
                        gridLines: {
                            display: true,
                        },
                    }],
                },
                elements: {
                    point: {
                        radius: 0,
                        hitRadius: 10,
                        hoverRadius: 4,
                        hoverBorderWidth: 3,
                    },
                }
            })
        },
    }
</script>
