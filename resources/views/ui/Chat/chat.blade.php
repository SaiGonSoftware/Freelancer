@extends('ui.layout')
@section('content')
<script src="/js/jquery-1.11.2.min.js"></script>
<script src="/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/nodejs/node_modules/socket.io-client/socket.io.js"  type="text/javascript"></script>
<script src="/nodejs/server.js"></script>
<link rel="stylesheet" type="text/css" href="/css/chat.css">
<div class="container" style="margin-top:10%;margin-bottom:10%">
    <div class="row">
        <div class="conversation-wrap col-lg-3">
            <div class="media conversation">
                <a class="pull-left" href="#">
                    <img class="media-object" data-src="holder.js/64x64" alt="64x64" style="width: 50px; height: 50px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACqUlEQVR4Xu2Y60tiURTFl48STFJMwkQjUTDtixq+Av93P6iBJFTgg1JL8QWBGT4QfDX7gDIyNE3nEBO6D0Rh9+5z9rprr19dTa/XW2KHl4YFYAfwCHAG7HAGgkOQKcAUYAowBZgCO6wAY5AxyBhkDDIGdxgC/M8QY5AxyBhkDDIGGYM7rIAyBgeDAYrFIkajEYxGIwKBAA4PDzckpd+322243W54PJ5P5f6Omh9tqiTAfD5HNpuFVqvFyckJms0m9vf3EY/H1/u9vb0hn89jsVj8kwDfUfNviisJ8PLygru7O4TDYVgsFtDh9Xo9NBrNes9cLgeTybThgKenJ1SrVXGf1WoVDup2u4jFYhiPx1I1P7XVBxcoCVCr1UBfTqcTrVYLe3t7OD8/x/HxsdiOPqNGo9Eo0un02gHkBhJmuVzC7/fj5uYGXq8XZ2dnop5Mzf8iwMPDAxqNBmw2GxwOBx4fHzGdTpFMJkVzNB7UGAmSSqU2RoDmnETQ6XQiOyKRiHCOSk0ZEZQcUKlU8Pz8LA5vNptRr9eFCJQBFHq//szG5eWlGA1ywOnpqQhBapoWPfl+vw+fzweXyyU+U635VRGUBOh0OigUCggGg8IFK/teXV3h/v4ew+Hwj/OQU4gUq/w4ODgQrkkkEmKEVGp+tXm6XkkAOngmk4HBYBAjQA6gEKRmyOL05GnR99vbW9jtdjEGdP319bUIR8oA+pnG5OLiQoghU5OElFlKAtCGr6+vKJfLmEwm64aosd/XbDbbyIBSqSSeNKU+HXzlnFAohKOjI6maMs0rO0B20590n7IDflIzMmdhAfiNEL8R4jdC/EZIJj235R6mAFOAKcAUYApsS6LL9MEUYAowBZgCTAGZ9NyWe5gCTAGmAFOAKbAtiS7TB1Ng1ynwDkxRe58vH3FfAAAAAElFTkSuQmCC">
                </a>
                <div class="media-body">
                    <h5 class="media-heading">Naimish Sakhpara</h5>
                    <small>Hello</small>
                </div>
            </div>
            <div class="media conversation">
                <a class="pull-left" href="#">
                    <img class="media-object" data-src="holder.js/64x64" alt="64x64" style="width: 50px; height: 50px;" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAACqUlEQVR4Xu2Y60tiURTFl48STFJMwkQjUTDtixq+Av93P6iBJFTgg1JL8QWBGT4QfDX7gDIyNE3nEBO6D0Rh9+5z9rprr19dTa/XW2KHl4YFYAfwCHAG7HAGgkOQKcAUYAowBZgCO6wAY5AxyBhkDDIGdxgC/M8QY5AxyBhkDDIGGYM7rIAyBgeDAYrFIkajEYxGIwKBAA4PDzckpd+322243W54PJ5P5f6Omh9tqiTAfD5HNpuFVqvFyckJms0m9vf3EY/H1/u9vb0hn89jsVj8kwDfUfNviisJ8PLygru7O4TDYVgsFtDh9Xo9NBrNes9cLgeTybThgKenJ1SrVXGf1WoVDup2u4jFYhiPx1I1P7XVBxcoCVCr1UBfTqcTrVYLe3t7OD8/x/HxsdiOPqNGo9Eo0un02gHkBhJmuVzC7/fj5uYGXq8XZ2dnop5Mzf8iwMPDAxqNBmw2GxwOBx4fHzGdTpFMJkVzNB7UGAmSSqU2RoDmnETQ6XQiOyKRiHCOSk0ZEZQcUKlU8Pz8LA5vNptRr9eFCJQBFHq//szG5eWlGA1ywOnpqQhBapoWPfl+vw+fzweXyyU+U635VRGUBOh0OigUCggGg8IFK/teXV3h/v4ew+Hwj/OQU4gUq/w4ODgQrkkkEmKEVGp+tXm6XkkAOngmk4HBYBAjQA6gEKRmyOL05GnR99vbW9jtdjEGdP319bUIR8oA+pnG5OLiQoghU5OElFlKAtCGr6+vKJfLmEwm64aosd/XbDbbyIBSqSSeNKU+HXzlnFAohKOjI6maMs0rO0B20590n7IDflIzMmdhAfiNEL8R4jdC/EZIJj235R6mAFOAKcAUYApsS6LL9MEUYAowBZgCTAGZ9NyWe5gCTAGmAFOAKbAtiS7TB1Ng1ynwDkxRe58vH3FfAAAAAElFTkSuQmCC">
                </a>
                <div class="media-body">
                    <h5 class="media-heading">Naimish Sakhpara</h5>
                    <small>Hello</small>
                </div>
            </div>


        </div>



        <div class="message-wrap col-lg-8">
            <div class="msg-wrap">
                <div class="media msg " id="messages">

                </div>

            </div>

            <div class="send-wrap ">

                <textarea class="form-control send-message" rows="3" placeholder="Write a reply..." id="messageInput"></textarea>


            </div>
            <form class="form-inline" id="messageForm">
                <div class="">
                    <input type="submit" value="Gửi" id="sendMess" class="btn btn-primary btn-block" />
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    var socket=io.connect( 'http://localhost:8080' );

    $("#messageForm").submit(function(){
        var username=$("#welcome_user").text();
        var msg=$("#messageInput").val();
        var avatar=$("#user_avatar").attr('src')
        socket.emit('message',{name:username,message:msg,avatar:avatar});
        return false;
    });

    socket.on('message' ,function(data){
        var actualContent=$("#messages").html();
        var current=new Date().toTimeString().split(" ")[0];
        var newContent='<span class="pull-left" href="#">'+'<img class="media-object" style="width: 32px; height: 32px;float: left;margin-right: 10px;" src='+data.avatar+'>'+'</span><div class="media-body"> <small class="pull-right time"><i class="fa fa-clock-o"></i>'+current+'</small><h5 class="media-heading username">'+data.name+'</h5><small class="col-lg-10 message_content">'+data.message+'</small></div>';
        var content=newContent+actualContent;
        $("#messages").append(newContent);
    });
</script>
@stop