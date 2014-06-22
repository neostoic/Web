jQuery(document).ready(function(){

  var socket = io.connect('http://eventsd.local:6948',{'flash policy port':6948});
  socket.on('event', function (data) {
    console.log(data);
  });
});
