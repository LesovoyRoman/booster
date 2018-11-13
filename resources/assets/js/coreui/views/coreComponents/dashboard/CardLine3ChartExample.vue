<script>
import { Line } from 'vue-chartjs'

const datasets = [
  {
    label          : 'My First dataset',
    //backgroundColor: 'rgba(255,255,255,.2)',
    borderColor    : 'rgba(255,255,255,.55)',
  },
]

export default {
  extends: Line,
  props  : ['height', 'data', 'colorBg'],
  mounted () {
    this.renderChart({
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
            {
                datasets,
                pointHoverBackgroundColor : '#fff',
                data                      : this.data,
                backgroundColor           : this.colorBg,
            },
        ],
    }, {
      maintainAspectRatio: false,
      legend             : {
        display: false,
      },
      scales: {
        xAxes: [{
          display: false,
        }],
        yAxes: [{
          display: false,
        }],
      },
      elements: {
        line: {
          borderWidth: 2,
        },
        point: {
          radius     : 0,
          hitRadius  : 10,
          hoverRadius: 4,
        },
      },
    })
  },
}
</script>
