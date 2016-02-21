var express=require("express");
	app =express(),
	server=require('http').createServer(app),
	io=require('socket.io').listen(server);
server.listen(3000);

app.get('/tin-nhan',function(req,res){
	res.sendfile(_dirname + 'resources/views/ui/Chat/chat.blade.php');
});