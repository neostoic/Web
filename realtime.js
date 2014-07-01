var io = require('socket.io').listen(6948);
var events_per_second = 0;
var events_per_minute = [];

if ( 'function' !== typeof Array.prototype.reduce ) {
  Array.prototype.reduce = function( callback /*, initialValue*/ ) {
    'use strict';
    if ( null === this || 'undefined' === typeof this ) {
      throw new TypeError(
        'Array.prototype.reduce called on null or undefined' );
    }
    if ( 'function' !== typeof callback ) {
      throw new TypeError( callback + ' is not a function' );
    }
    var t = Object( this ), len = t.length >>> 0, k = 0, value;
    if ( arguments.length >= 2 ) {
      value = arguments[1];
    } else {
      while ( k < len && ! k in t ) k++;
      if ( k >= len )
        throw new TypeError('Reduce of empty array with no initial value');
      value = t[ k++ ];
    }
    for ( ; k < len ; k++ ) {
      if ( k in t ) {
        value = callback( value, t[k], k, t );
      }
    }
    return value;
  };
}

io.sockets.on('connection', function (socket) {
  console.log('user connected!');

  socket.on('event_occurred', function (data) {
    events_per_second++;
    console.log('Event occoured! ' + data.event);
    socket.broadcast.emit('event', data);

  });
});

setInterval(function(){
  var events_per_minute_sum = 0;
  if(events_per_minute.length >= 2){
    events_per_minute_sum = events_per_minute.reduce(function(a, b) {
      return a + b;
    });
  }

  io.sockets.emit('events_per_second',
    {
      'second': events_per_second,
      //'minute': events_per_minute,
      'minute_sum': events_per_minute_sum
    }
  );
  if(events_per_minute.length >= 60){
    events_per_minute.shift();
  }
  events_per_minute.push(events_per_second);
  events_per_second = 0;
}, 1000);