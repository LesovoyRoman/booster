<script>
    import { Line } from 'vue-chartjs'

    // const brandPrimary = '#20a8d8'
    const brandSuccess = '#4dbd74'
    const brandInfo = '#63c2de'
    const brandDanger = '#f86c6b'

    function convertHex (hex, opacity) {
        hex = hex.replace('#', '')
        const r = parseInt(hex.substring(0, 2), 16)
        const g = parseInt(hex.substring(2, 4), 16)
        const b = parseInt(hex.substring(4, 6), 16)

        const result = `rgba(${r},${g},${b},${opacity / 100})`
        return result
    }

    let vm = {}
    export default {
        extends: Line,
        props  : ['height', 'options'],
        methods: {
            createChart(){

                this.renderChart({
                    labels  : vm.options.labels,
                    datasets: [
                        {
                            label                    : vm.options.label,
                            backgroundColor          : convertHex(brandInfo, 10),
                            borderColor              : brandInfo,
                            pointHoverBackgroundColor: '#fff',
                            borderWidth              : 2,
                            data                     : vm.options.datas,
                        },
                        {
                            label                    : vm.options.labelAdd,
                            backgroundColor          : convertHex(brandInfo, 25),
                            borderColor              : brandInfo,
                            pointHoverBackgroundColor: '#fff',
                            borderWidth              : 2,
                            data                     : vm.options.datasAdd,
                        },
                    ],
                }, {
                    maintainAspectRatio: false,
                    legend             : {
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
                                beginAtZero  : true,
                                maxTicksLimit: 5,
                                stepSize     : Math.ceil(250 / 5),
                                max          : 250,
                            },
                            gridLines: {
                                display: true,
                            },
                        }],
                    },
                    elements: {
                        point: {
                            radius          : 0,
                            hitRadius       : 10,
                            hoverRadius     : 4,
                            hoverBorderWidth: 3,
                        },
                    },
                })
            }
        },
        mounted () {
            vm = this;
            this.createChart();
        },
        watch: {
            options: function() {
                this._data._chart.destroy();
                this.createChart();
            }
        }
    }
</script>
