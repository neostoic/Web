jQuery(document).ready(function(){

  var socket = io.connect('http://' + location.hostname + ':6948');
  socket.on('event', function (data) {
    var table = jQuery('table.events-list');
    var table_body = jQuery('tbody', table);
    table_body.prepend("" +
      "<tr>" +
      "<td>" + data.Application.name + "</td>" +
      "<td>" + data.event + "</td>" +
      "<td>" + data.value + "</td>" +
      "<td>" + data.hostname + "</td>" +
      "<td>" + data.local_time + "</td>" +
      "</tr>")
    console.log(data);
  });
});
