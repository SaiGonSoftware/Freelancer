//require module
var socket = require( 'socket.io' );
var express = require( 'express' );
var http = require( 'http' );
var dateFormat = require('date-format');
//crate instance of express and http
var app = express();
var server = http.createServer( app );
//listen to socket from server
var io = socket.listen( server );
var connection = require('mysql').createConnection({
	host		: 'localhost',
	user		: 'root',
	password	: '',
	database	: 'freelancer'
});
connection.connect(function(err){
	if(err) console.log(err);
});


//when client connect to server console.log
io.sockets.on( 'connection', function( client ) {
	var isOnline=false;
	console.log( "New client id " + client.id );
	io.sockets.emit('user_online',{isOnline:true});
    //when we receive message 
    client.on('message', function( data ) {
    	console.log( 'Message received from' + data.name + ":" + data.message +' avatar' +data.avatar +' id '+ data.form_user_id + ' ' + data.to_user_id);
    	var insertData = {	  
    		content:data.message,
    		from_user_id :data.from_user_id,
    		to_user_id:data.to_user_id,
    		created_at:dateFormat('yyyy-MM-dd hh:mm:ss', new Date()),
    		view:0
    	};
    	var query=connection.query('INSERT INTO chat SET ?',insertData, function (error, results) {
    		if(error) throw error;
    	});
    	console.log(query.sql);
    	io.sockets.emit( 'message', 
    	{ 
    		name: data.name,
    		message: data.message,
    		avatar:data.avatar,
    		form_user_id:data.form_user_id,
    		to_user_id:data.to_user_id,
    		cur_time:data.cur_time 
    	});
    });
    client.on('typing',function(data){
    	client.broadcast.emit('typing',data);
    });
/*    client.on('list-message',function(data){
    	var query=connection.query('SELECT * FROM chat  WHERE (from_user_id = ? AND to_user_id = ?) OR (from_user_id = ? AND to_user_id = ?) ORDER BY id ASC',data.from_user_id,data.to_user_id,data.to_user_id,data.from_user_id, function (error, results) {
    		if(error) throw error;
    		else{
    			
    		}
    	});
});*/
});


server.listen( 8080 );