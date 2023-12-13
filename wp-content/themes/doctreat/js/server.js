const express 	= require('express');
const app 		= express();
const server 	= app.listen(81, function() {
    console.log('server running on port 81');
});

var clients 		= {};
var connected_users = [];
const io 			= require('socket.io')(server);

 io.on('connection', function(socket) {
	  //add new user's id to socket.
	  socket.on('add-user', function(data) {
			clients[data.userId] = {
			  "socket": socket.id,
			};
			connected_users.push(data.userId);
			io.sockets.emit('connected-users', { users_connected: connected_users });
	  });

	  //sending messsages to require person
	  socket.on('send_msg', function(data){
		  //console.log('data);
		  if (clients[data.user_id]) {
			io.sockets.connected[clients[ data.user_id ].socket].emit("send_msg", data);
		  } else {
			console.log("User does not exist");
		  }
	  });

	  //Removing the socket on disconnect
	  socket.on('disconnect', function() {
		for(var name in clients) {
		  if(clients[name].socket === socket.id) {
			delete clients[name];
			break;
		  }
		}
	  });
});