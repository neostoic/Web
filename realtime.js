var io = require('socket.io').listen(6948);
var events_per_second = 0;

io.sockets.on('connection', function (socket) {
  console.log('user connected!');

  socket.on('event_occurred', function (data) {
    events_per_second++;
    console.log('Event occoured! ' + data.event);
    socket.broadcast.emit('event', data);
  });
});

setInterval(function(){
  io.sockets.emit('events_per_second', events_per_second);
  events_per_second = 0;
}, 1000);