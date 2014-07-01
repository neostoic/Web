jQuery(document).ready(function(){

  var socket = io.connect('http://' + location.hostname + ':6948');
  socket.on('events_per_second', function (data) {
    var chart = jQuery('#rate-container').highcharts();
    if (chart) {
      var point = chart.series[0].points[0];

      point.update(data);
    }
  });
});
