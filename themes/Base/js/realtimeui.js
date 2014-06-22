jQuery(document).ready(function(){

  var socket = io.connect('http://intervent.io:6948',{'flash policy port':6948, transport:'polling'});
  socket.on('event', function (data) {
    var table = jQuery('table.events-list');
    var table_body = jQuery('tbody', table);
    table_body.prepend("" +
      "<tr>" +
      "<td>" + data.Application.name + "</td>" +
      "<td>" + data.event + "</td>" +
      "<td>" + data.value + "</td>" +
      "<td>" + data.local_time + "</td>" +
      "</tr>")
    console.log(data);
  });
});
