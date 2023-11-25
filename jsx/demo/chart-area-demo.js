// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#000000';

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
var myLineChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ["2:00 น", "4:00 น", "6:00 น", "8:00 น", "10:00 น", "12:00 น", "14:00 น", "16:00 น", "18:00 น", "20:00 น", "22:00 น", "เที่ยงคืน"],
    datasets: [{
      label: "Sessions",
      lineTension: 0.5,
      backgroundColor: "rgb(163, 82, 41,1)",
      borderColor: "#802b00",
      pointRadius: 5,
      pointBackgroundColor: "rgba(2,117,216,1)",
      pointBorderColor: "rgba(255,255,255,0.8)",
      pointHoverRadius: 5,
      pointHoverBackgroundColor: "rgba(2,117,216,1)",
      pointHitRadius: 50,
      pointBorderWidth: 2,
      data: [66, 78, 80, 86, 90, 96, 95, 80, 70, 65, 63, 60],
    }],
  },
  options: {
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          min: 0,
          max: 100,
          maxTicksLimit: 5
        },
        gridLines: {
          color: "#000000",
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
