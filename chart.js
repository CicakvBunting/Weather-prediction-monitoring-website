/* global Chart:false */

$(function () {
  'use strict'
    var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

const skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;
const down = (ctx, value) => ctx.p0.parsed.y > ctx.p1.parsed.y ? value : undefined;
const genericOptions = {
  fill: false,
  interaction: {
    intersect: false
  },
  radius: 0,
};

  var mode = 'index'
  var intersect = true
  // data bpm
  databpm = [10,56,70,80,90,43,23,67,80,90,120,20,30,80,50,60,90,32,67,89,67,80,90,65];
  var $bpmChart = $('#bpm-chart');
  var ctx = document.getElementById('#bpm-chart').getContext('2d');
  let Lastbpm = databpm.slice(-1);
  document.getElementById("Lbpm").innerHTML = Lastbpm;
  // eslint-disable-next-line no-unused-vars
  var bpmChart = new Chart($bpmChart, {
    data: {
      labels: ['00:00','1:00','2:00','3:00','4:00','5:00','6:00','7:00','8:00','9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00'],
      datasets: [{
        type: 'line',
        data: radiasi,
        label: 'Beats per minute',
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 205, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(201, 203, 207, 0.2)'
        ],

        segment: {
          borderColor: (ctx) => {
            val = ctx.p0.parsed.y;
            return val >= 80 ? 'green' : 'red'
          }
        },
        pointBorderColor: 'green',
        pointBackgroundColor: 'black',
        pointRadius:3,
        fill: false,
        pointHoverBackgroundColor: '#007bff',
        pointHoverBorderColor    : '#007bff'
      }]
    },
plugins: [{
beforeRender: (x, options) => {
  const c = x.chart;
  const dataset = x.data.datasets[0];
  const yScale = x.scales['y-axis-0'];
  const yPos = yScale.getPixelForValue(70);

  const gradientFill = c.ctx.createLinearGradient(0, 0, 0, c.height);
  gradientFill.addColorStop(0, 'rgb(86,188,77)');
  gradientFill.addColorStop(yPos / c.height, 'rgb(86,188,77)');
  gradientFill.addColorStop(yPos / c.height, 'rgb(229,66,66)');
  gradientFill.addColorStop(1, 'rgb(229,66,66)');

  const model = x.data.datasets[0]._meta[Object.keys(dataset._meta)[0]].dataset._model;
  model.borderColor = gradientFill;
},
}],
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 150
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
  

 
  
 


  const datatemp = [30,28,29,28,29,27,30,30,40,20,31,17,18,19,12,23,25,26,26,27,24,25,26,24];

  let Lasttemp = datatemp.slice(-1);
  document.getElementById("Ltemp").innerHTML = Lasttemp;
  var $TempsChart = $('#temps-chart')
  // eslint-disable-next-line no-unused-vars
  var TempsChart = new Chart($TempsChart, {
    data: {
      labels: ['00:00','1:00','2:00','3:00','4:00','5:00','6:00','7:00','8:00','9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00'],
      datasets: [{
        type: 'line',
        data: datatemp,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        pointBorderColor: 'balck',
        pointBackgroundColor: 'black',
        pointRadius:3,
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },
    plugins: [{
      beforeRender: (x, options) => {
        const c = x.chart;
        const dataset = x.data.datasets[0];
        const yScale = x.scales['y-axis-0'];
        const yPos = yScale.getPixelForValue(23);
    
        const gradientFill = c.ctx.createLinearGradient(0, 0, 0, c.height);
        gradientFill.addColorStop(0, 'rgb(86,188,77)');
        gradientFill.addColorStop(yPos / c.height, 'rgb(86,188,77)');
        gradientFill.addColorStop(yPos / c.height, 'rgb(229,66,66)');
        gradientFill.addColorStop(1, 'rgb(229,66,66)');
    
        const model = x.data.datasets[0]._meta[Object.keys(dataset._meta)[0]].dataset._model;
        model.borderColor = gradientFill;
      },
    }],
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 60
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })

  //temp 2
  const datatemp2 = [30,28,29,28,29,27,30,30,40,20,31,17,18,19,12,23,25,26,26,27,24,25,26,50];

  let Lasttemp2 = datatemp2.slice(-1);
  document.getElementById("Ltemp").innerHTML = Lasttemp2;

  var $TempsChart2 = $('#temps-chart2')
  // eslint-disable-next-line no-unused-vars
  var TempsChart2 = new Chart($TempsChart2, {
    data: {
      labels: ['00:00','1:00','2:00','3:00','4:00','5:00','6:00','7:00','8:00','9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00'],
      datasets: [{
        type: 'line',
        data: datatemp2,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        pointBorderColor: 'balck',
        pointBackgroundColor: 'black',
        pointRadius:3,
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },
    plugins: [{
      beforeRender: (x, options) => {
        const c = x.chart;
        const dataset = x.data.datasets[0];
        const yScale = x.scales['y-axis-0'];
        const yPos = yScale.getPixelForValue(23);
    
        const gradientFill = c.ctx.createLinearGradient(0, 0, 0, c.height);
        gradientFill.addColorStop(0, 'rgb(86,188,77)');
        gradientFill.addColorStop(yPos / c.height, 'rgb(86,188,77)');
        gradientFill.addColorStop(yPos / c.height, 'rgb(229,66,66)');
        gradientFill.addColorStop(1, 'rgb(229,66,66)');
    
        const model = x.data.datasets[0]._meta[Object.keys(dataset._meta)[0]].dataset._model;
        model.borderColor = gradientFill;
      },
    }],
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,
            suggestedMax: 60
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })
  

      // data bpm2
      const databpm2 = [60,56,70,80,90,43,23,67,80,90,100,20,30,80,50,60,90,32,67,89,67,80,90,65];
      var $bpmChart2 = $('#bpm-chart2')
      let Lastbpm2 = databpm2.slice(-1);
      document.getElementById("Lbpm").innerHTML = Lastbpm2;
      // eslint-disable-next-line no-unused-vars
      var bpmChart2 = new Chart($bpmChart2, {
        data: {
          labels: ['00:00','1:00','2:00','3:00','4:00','5:00','6:00','7:00','8:00','9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00','22:00','23:00'],
          datasets: [{
            type: 'line',
            data: databpm2,
            label: 'Beats per minute',
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 159, 64, 0.2)',
              'rgba(255, 205, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(153, 102, 255, 0.2)',
              'rgba(201, 203, 207, 0.2)'
            ],
  
            segment: {
              borderColor: (ctx) => {
                val = ctx.p0.parsed.y;
                return val >= 80 ? 'green' : 'red'
              }
            },
            pointBorderColor: 'green',
            pointBackgroundColor: 'black',
            pointRadius:3,
            fill: false,
            pointHoverBackgroundColor: '#007bff',
            pointHoverBorderColor    : '#007bff'
          }]
        },
  plugins: [{
    beforeRender: (x, options) => {
      const c = x.chart;
      const dataset = x.data.datasets[0];
      const yScale = x.scales['y-axis-0'];
      const yPos = yScale.getPixelForValue(70);
  
      const gradientFill = c.ctx.createLinearGradient(0, 0, 0, c.height);
      gradientFill.addColorStop(0, 'rgb(86,188,77)');
      gradientFill.addColorStop(yPos / c.height, 'rgb(86,188,77)');
      gradientFill.addColorStop(yPos / c.height, 'rgb(229,66,66)');
      gradientFill.addColorStop(1, 'rgb(229,66,66)');
  
      const model = x.data.datasets[0]._meta[Object.keys(dataset._meta)[0]].dataset._model;
      model.borderColor = gradientFill;
    },
  }],
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              // display: false,
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
                suggestedMax: 150
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })








})



// lgtm [js/unused-local-variable]
