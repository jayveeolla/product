import Chart from "chart.js";
import "./roundedCornersExtension";

function randomScalingFactor() {
  return Math.round(Math.random() * 100);
}

export const barChart = {
  createChart(chartId, labels,datasets) {
    const ctx = document.getElementById(chartId).getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: datasets,
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutoutPercentage: 0,
        barPercentage: 1.6,
        legend: {
          display: false,
        },
        tooltips: {
          enabled: true,
          mode: "index",
          intersect: false,
        },
        scales: {
          display: false,
          yAxes: [
            {
              stacked: true,
              gridLines: {
                borderDash: [2],
                borderDashOffset: [2],
                zeroLineColor: "#dee2e6",
                drawBorder: false,
                drawTicks: false,
                lineWidth: 1,
                zeroLineWidth: 1,
                zeroLineBorderDash: [2],
                zeroLineBorderDashOffset: [2],
              },
              ticks: {
                beginAtZero: true,
                padding: 10,
                fontSize: 13,
                fontColor: "#8898aa",
                fontFamily: "Open Sans",
              },
            },
          ],
          xAxes: [
            {
              stacked: true,
              gridLines: {
                drawBorder: false,
                color: "transparent",
                zeroLineColor: "transparent",
              },
              ticks: {
                fontSize: 13,
                fontColor: "#8898aa",
                fontFamily: "Open Sans",
              },
            },
          ],
        },
        layout: {
          padding: 0,
        },
      },
    });
  },
};

const funcs = {
  barChart() {},
};

export default funcs;
