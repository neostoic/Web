jQuery(document).ready(function(){
  console.log("Document ready");
  var conn = new WebSocket('ws://127.0.0.1:8080');
  conn.onopen = function(e) {
    console.log("Connection established!");
  };

  conn.onmessage = function(e) {
    console.log(e.data);
  };
});
