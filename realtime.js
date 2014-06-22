
var io = require('socket.io').listen(6948);

io.sockets.on('connection', function (socket) {
  console.log('user connected!');

  socket.on('event_occurred', function (data) {
    console.log('Event occoured! ' + data.event);
    socket.broadcast.emit('event', data);
  });
});
