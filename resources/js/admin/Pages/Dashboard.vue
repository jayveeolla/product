<template>
  <app-layout>
    <div class="row p-4">
     
    </div>
    <div class="container-fluid">
      <!--Charts-->
      <div class="row">
        <div class="col-xl-6">
          <card header-classes="bg-transparent">
            <template v-slot:header>
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">
                    Performance
                  </h6>
                  <h5 class="h3 mb-0">Product</h5>
                </div>
              </div>
            </template>
            <div class="chart-area">
        
              <canvas  :height="350"  ref="chart"></canvas>
            </div>
          </card>
        </div>
      </div>
      <!-- End charts-->
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@admin/Layouts/AdministratorLayout";

// Charts
import { barChart } from "@admin/Components/Charts/Chart";
import Chart from "chart.js";

let chart;

export default {
  props: [
    "productData",
  ],
  components: {
    AppLayout,
  },
  data() {
    return {
      modal: {
        image: false,
        test: null,
        filename: null,
        src: "/img/image_not_found.jpg",
      },
      userRegistration: "userRegistration",
      // mL: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      // mS: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
    };
  },

  methods: {
    getData(label, data, color) {
  if (data) {
    var datasets = [
      {
        label: label,
        borderWidth: 0,
        pointRadius: 0,
        backgroundColor: color,
        data: [],
        maxBarThickness: 25,
      },
    ];
    var labels = [];
    for (var product in data) {
      labels.push(data[product]['product_title']);
      datasets[0].data.push(data[product]['quanity']);
    }
    return {
      labels: labels,
      datasets: datasets,
    };
  }

  return {
    labels: null,
    datasets: null,
  };
},
  },
 mounted() {
  this.$nextTick(() => {
    const data = {
      labels: this.productData.map(item => item.product_title),
      datasets: [{
        label: 'Quantity',
        backgroundColor: '#f87979',
        data: this.productData.map(item => item.quanity)
      }]
    };
    const options = {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    };
    const ctx = this.$refs.chart.getContext('2d');
    chart = new Chart(ctx, {
      type: 'bar',
      data: data,
      options: options
    });
  });
},
};
</script>

