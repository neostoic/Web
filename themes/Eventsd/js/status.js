jQuery(document).ready(function() {
    var max_per_second = 250;
    var gaugeOptions = {

      chart: {
        type: 'solidgauge'
      },

      title: null,

      pane: {
        center: ['50%', '85%'],
        size: '140%',
        startAngle: -90,
        endAngle: 90,
        background: {
          backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
          innerRadius: '60%',
          outerRadius: '100%',
          shape: 'arc'
        }
      },

      tooltip: {
        enabled: false
      },

      // the value axis
      yAxis: {
        stops: [
          [0.1, '#55BF3B'], // green
          [0.5, '#DDDF0D'], // yellow
          [0.9, '#DF5353'] // red
        ],
        lineWidth: 0,
        minorTickInterval: null,
        tickPixelInterval: 400,
        tickWidth: 0,
        title: {
          y: -70
        },
        labels: {
          y: 16
        }
      },

      plotOptions: {
        solidgauge: {
          dataLabels: {
            y: -30,
            borderWidth: 0,
            useHTML: true
          }
        }
      }
    };

  // The speed gauge
  jQuery('#rate-container-second').highcharts(Highcharts.merge(gaugeOptions, {
    yAxis: {
      min: 0,
      max: max_per_second,
      title: {
        text: null
      }
    },
    credits: {
      enabled: false
    },

    series: [{
      name: 'Speed',
      data: [0],
      dataLabels: {
        format: '<div style="text-align:center"><span style="font-size:25px;color:' +
          ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
          '<span style="font-size:12px;color:silver">events/sec</span></div>'
      },
      tooltip: {
        valueSuffix: ' events/second'
      }
    }]

  }));

  // The speed gauge
  jQuery('#rate-container-minute').highcharts(Highcharts.merge(gaugeOptions, {
    yAxis: {
      min: 0,
      max: max_per_second*60,
      title: {
        text: null
      }
    },
    credits: {
      enabled: false
    },

    series: [{
      name: 'Speed',
      data: [0],
      dataLabels: {
        format: '<div style="text-align:center"><span style="font-size:25px;color:' +
          ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}</span><br/>' +
          '<span style="font-size:12px;color:silver">events/min</span></div>'
      },
      tooltip: {
        valueSuffix: ' events/minute'
      }
    }]

  }));
});