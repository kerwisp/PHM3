const app = require('express')();
const http = require('http').createServer(app);
const dotenv = require('dotenv');
dotenv.config();
const io = require('socket.io')(http, {
  cors: {
    origins: [process.env.DOMAIN]
  }
});


app.set('port', process.env.PORT_ID);
  
app.get('/', (req, res) => {
  res.send('<h1>Hello WPGuppy Socket.io</h1>');
});

var connectedUsers  = [];

http.listen(app.get('port'), () =>  console.log('server is running on port '+ app.get('port')));

io.on('connection', (socket) => {
  
  // let token = socket.handshake.auth.token;
  //add new user's id to socket.
	socket.on('addUser', (data) => {
    connectedUsers.push({ userId: data.userId, socket_id: socket.id });
		// io.emit('updateUsers', { connectedUsers});
		console.log('connectusers',connectedUsers);
	});
  
  // on disconnection 
  socket.on('disconnect', () => {
    connectedUsers = connectedUsers.filter(function(user){
      return user.socket_id != socket.id;
    });
    console.log('user disconnect',connectedUsers);
    // io.emit('updateUsers', {connectedUsers});
    
  });

  //update message to receiver
	socket.on('receiverChatData', (data) => {
    let chatType = data.chatData.chatType;
    if( chatType == 1 || chatType == 3 ){
      let receiverId  = data.chatData.chatId.split('_');
      receiverId        = receiverId[0];
      let payload = {
        chatId                : data.messagelistData.chatId,
        chatData              : data.chatData,
        chatType              : data.chatType,
        messagelistData       : data.messagelistData,
      }
      if(connectedUsers.length){
        connectedUsers.forEach( item => {
          if(item.userId == receiverId){ 
            io.to(item.socket_id).emit('receiverChatData', payload);
          }
        });
      }
    }
	});

  //update message to sender
	socket.on('senderChatData', (senderData) => {
    let payload     = JSON.parse(JSON.stringify(senderData));
    let chatType    = payload.chatData.chatType;
    if(chatType == 1 || chatType == 3){
      let receiverId    = payload.messagelistData.chatId.split('_');
      receiverId        = receiverId[0];
      payload.messagelistData.isSender        = true; 
      payload.chatData.isSender               = true; 
      payload.messagelistData.UnreadCount     = 0;
      payload.messagelistData.chatId          = payload.chatData.chatId;
      payload.messagelistData.userName        = payload.userName; 
      payload.messagelistData.userAvatar      = payload.userAvatar; 
      payload.messagelistData.muteNotification      = payload.muteNotification; 
      if(connectedUsers.length){
        let data = {
          chatId            : payload.chatData.chatId,
          chatType          : payload.chatType,
          messagelistData   : payload.messagelistData,
          chatData          : payload.chatData,
        } 
        connectedUsers.forEach( item => {
          if(item.userId == receiverId){ 
            io.to(item.socket_id).emit('senderChatData', data);
          }
        });
      }
    }
	});

  //update message status to sender
	socket.on('updateMsgStatus', (data) => {
    let chatType    = data.chatType;
    if( chatType == 1 || chatType == 3){
      let receiverId = data.chatId.split('_');
          receiverId = receiverId[0];
      
      let senderId = data.senderId;
      if(connectedUsers.length){
        connectedUsers.forEach( item => {
          if(item.userId == senderId){ 
            data.isSender = true;
            io.to(item.socket_id).emit('updateMsgStatus', data);
          }
          if(item.userId == receiverId){
            data.isSender = false;
            io.to(item.socket_id).emit('updateMsgStatus', data);
          }
        });
      }
    }
	});

  //delete sender Message
	socket.on('deleteSenderMessage', (data) => {
    if(connectedUsers.length){
      let payload     = JSON.parse(JSON.stringify(data));
      let chatType    = payload.chatType;
      if(chatType == 1 || chatType == 3){
        payload.chatId = payload.receiverId+'_'+chatType;
      }
      connectedUsers.forEach( item => {
        if(item.userId == data.userId){ 
          io.to(item.socket_id).emit('deleteSenderMessage', payload);
        }
      });
    } 
	});

  //delete receiver Message
	socket.on('deleteReceiverMessage', (data) => {
    let payload     = JSON.parse(JSON.stringify(data));
    let chatType    = payload.chatType;
    if(chatType == 1 || chatType == 3){
      let receiverId      = payload.receiverId;
      if(connectedUsers.length){
        connectedUsers.forEach( item => {
          if(item.userId == receiverId){ 
          io.to(item.socket_id).emit('deleteReceiverMessage', payload);
          }
        });
      }
    }
	});

  //is Typing
	socket.on('isTyping', (data) => {
    let chatType    = data.chatType;
    if(chatType == 1 || chatType == 3){
      let receiverId    = data.chatId;
      receiverId = receiverId.split('_');
      if(connectedUsers.length){
        connectedUsers.forEach( item => {
          if(item.userId == receiverId[0]){ 
          io.to(item.socket_id).emit('isTyping', data);
          }
        });
      }
    }
	});

  //update user
	socket.on('updateReceiverUser', (data) => {
    let payload = data.userData;
    let receiverId = 0;
    payload['userName']   = payload.senderUserName;
		payload['userAvatar'] = payload.senderUserAvatar;
    if(payload.chatType == 1){
      let chatId      = payload.chatId;
      chatId          = chatId.split('_');
      receiverId      = chatId[0];
      blockerId       = payload.blockerId;
      payload.chatId  = blockerId+'_1';
    }
    
    if(connectedUsers.length){
      connectedUsers.forEach( item => {
        if(item.userId == receiverId){ 
         io.to(item.socket_id).emit('updateUser', payload);
        }
      });
    }
	});

	socket.on('updateSenderUser', (data) => {
    let payload     = data.userData;
    let receiverId  = payload.blockerId;
        payload['muteNotification'] = payload.receiverMuteNotification;
    if(connectedUsers.length){
      connectedUsers.forEach( item => {
        if(item.userId == receiverId){ 
         io.to(item.socket_id).emit('updateUser', payload);
        }
      });
    }
	});

	socket.on('updateMuteChatNotify', (data) => {
    let receiverId    = data.userId;
    if(connectedUsers.length){
      connectedUsers.forEach( item => {
        if(item.userId == receiverId){ 
         io.to(item.socket_id).emit('updateMuteChatNotify', data);
        }
      });
    }
	});

	socket.on('clearChat', (data) => {
    let receiverId    = data.userId;
    if(connectedUsers.length){
      connectedUsers.forEach( item => {
        if(item.userId == receiverId){ 
         io.to(item.socket_id).emit('clearChat', data);
        }
      });
    }
	});

});