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
            })
        },
    }
</script>
