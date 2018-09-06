<script>
    import { Pie } from 'vue-chartjs'
    let vm = {}

    export default {
        extends: Pie,
        props: ['data'],
        mounted () {
            vm = this;
            this.renderChart({
                labels: ['Green', 'Orange', 'Blue', 'Pink'],
                datasets: [
                    {
                        backgroundColor: [
                            '#69b84a',
                            '#e45818',
                            '#4473ff',
                            '#dd0689',
                        ],
                        data: vm.data,
                        borderWidth: 2,
                    },
                ],
            }, {
                /*maintainAspectRatio: false,*/
                legend: {
                    display: true,
                },
                /*scales: {
                    xAxes: [{
                        gridLines: {
                            drawOnChartArea: false,
                        },
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: false,
                            /!*maxTicksLimit: 5,
                            stepSize: Math.ceil(250 / 5),
                            max: 250,*!/
                        },
                        gridLines: {
                            display: false,
                        },
                    }],
                },*/
                elements: {
                    point: {
                        radius: 0,
                        hitRadius: 10,
                        hoverRadius: 4,
                        hoverBorderWidth: 3,
                    },
                }
            })
        }
    }
</script>
