var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis(process.env.REDIS_HOST || 'localhost');

redis.subscribe('channel-room', function(err, count){
    console.log(err, count)
});

redis.on('message', function(channel, message){
	console.log('Message reçu: ' + message);
	message = JSON.parse(message);
	io.emit(channel + ':' + message.event, message.data);
});

http.listen(6001, '0.0.0.0', function(){
	console.log('listening on Port 6001')
});
