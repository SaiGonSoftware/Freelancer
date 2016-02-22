//require module
var socket = require( 'socket.io' );
var express = require( 'express' );
var http = require( 'http' );

//crate instance of express and http
var app = express();
var server = http.createServer( app );
//listen to socket from server
var io = socket.listen( server );

//when client connect to server console.log
io.sockets.on( 'connection', function( client ) {
    console.log( "New client !" );
    //when we receive message 
    client.on( 'message', function( data ) {
        console.log( 'Message received ' + data.name + ":" + data.message +' avatar' +data.avatar );

        io.sockets.emit( 'message', { name: data.name, message: data.message,avatar:data.avatar } );
    });
});

server.listen( 8080 );