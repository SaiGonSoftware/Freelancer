@extends('ui.layout')
@section('content')
<script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>
<script src="/nodejs/server.js"></script>
<div class="container" style="margin-top:10%;margin-bottom:10%">
	<form class="form-inline" id="messageForm">
		<input id="nameInput" type="text" class="input-medium" placeholder="Name" />
		<input id="messageInput" type="text" class="input-xxlarge" placeHolder="Message" />

		<input type="submit" value="Send" />
	</form>

	<div>
		<ul id="messages">

		</ul>
	</div>
</div>
<script>

	var socket = io.connect( 'http://localhost:8080' );

	$( "#messageForm" ).submit( function() {
		var nameVal = $( "#nameInput" ).val();
		var msg = $( "#messageInput" ).val();

		socket.emit( 'message', { name: nameVal, message: msg } );

		return false;
	});

	socket.on( 'message', function( data ) {
		var actualContent = $( "#messages" ).html();
		var newMsgContent = '<li> <strong>' + data.name + '</strong> : ' + data.message + '</li>';
		var content = newMsgContent + actualContent;

		$( "#messages" ).html( content );
	});



</script>
@stop