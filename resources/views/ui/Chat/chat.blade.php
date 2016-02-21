@extends('ui.layout')
@section('content')
<script src="node_modules/socket.io-client/socket.io.js"></script>
<script src="/chat/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="/chat/chat.js" type="text/javascript"></script>
<script src="/node_modules/socket.io-client/socket.io.js"  type="text/javascript"></script>
<style type="text/css" media="screen">
    .chat
{
    list-style: none;
    margin: 0;
    padding: 0;
}

.chat li
{
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
}

.chat li.left .chat-body
{
    margin-left: 60px;
}

.chat li.right .chat-body
{
    margin-right: 60px;
}


.chat li .chat-body p
{
    margin: 0;
    color: #777777;
}

.panel .slidedown .glyphicon, .chat .glyphicon
{
    margin-right: 5px;
}

.panel-body
{
    overflow-y: scroll;
    height: 250px;
}

::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

::-webkit-scrollbar
{
    width: 12px;
    background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #555;
}

</style>
<div class="container" style="margin-top:10%">
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span> Chat
                    <div class="btn-group pull-right">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </button>
                        <ul class="dropdown-menu slidedown">
                            <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-refresh">
                            </span>Refresh</a></li>
                            <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-ok-sign">
                            </span>Available</a></li>
                            <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-remove">
                            </span>Busy</a></li>
                            <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-time"></span>
                                Away</a></li>
                            <li class="divider"></li>
                            <li><a href="http://www.jquery2dotnet.com"><span class="glyphicon glyphicon-off"></span>
                                Sign Out</a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                <input type="hidden" name="username" id="username" value="{{Auth::user()->username}}">
                    <ul class="chat">
                        <li class="left clearfix"><span class="chat-img pull-left">

                        </span>
                            <div class="chat-body clearfix">
                                <p id="chat-content">
                                  
                                </p>
                                <div id="typeStatus"></div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="panel-footer">
                    <div class="input-group col-lg-12">
                        <input id="text-mess" type="text" class="form-control input-sm" placeholder="Type your message here..." onblur="notTyping()" autofocus=""/>
                        <span class="input-group-btn">
<!--                             <button class="btn btn-warning btn-md" id="btn-sendmess">
    Send</button> -->
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop