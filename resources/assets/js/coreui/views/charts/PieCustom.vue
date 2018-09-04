<script>
    import { Pie } from 'vue-chartjs'
    let vm = {}

    export default {
        extends: Pie,
        props: ['data'],
        mounted () {
            vm = this;
            this.renderChart({
                labels  : ['Green', 'Orange', 'Blue', 'Pink'],
                datasets: [
                    {
                        backgroundColor: [
                            '#69b84a',
                            '#e45818',
                            '#4473ff',
                            '#dd0689',
                        ],
                        data: vm.data,
                    },
                ],
            }, { responsive: true, maintainAspectRatio: true })
        },
    }
</script>
