jQuery(document).ready(function(){

  var socket = io.connect('http://' + location.hostname + ':6948');
  socket.on('events_per_second', function (data) {
    console.log(data)
    var sec_chart = jQuery('#rate-container-second').highcharts();
    var min_chart = jQuery('#rate-container-minute').highcharts();

    if (sec_chart) {
      var sec_point = sec_chart.series[0].points[0];
      sec_point.update(data.second);
    }
    if (min_chart) {
      var min_point = min_chart.series[0].points[0];
      min_point.update(data.minute_sum);
    }
  });
});
