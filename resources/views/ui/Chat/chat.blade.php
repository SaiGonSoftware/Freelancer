@extends('ui.layout')
@section('content')
    <div class="container" style="margin-top:10%;margin-bottom:10%">
        <div class="row">
            <div class="conversation-wrap col-lg-3">
                @foreach ($chat_message as $message)
                    <div class="media conversation" id="{{$message->user->username}}">
                        <a class="pull-left" href="#">
                            <img class="media-object"
                                 style="width: 50px; height: 50px;" src="/{{$message->user->avatar}}">
                        </a>
                        <div class="media-body">
                            <h5 class="media-heading"> {{$message->from_user}}</h5>
                            <small>{{$message->created_at}}</small>
                        </div>
                    </div>
                @endforeach

            </div>


            <div class="message-wrap col-lg-8">
                <div class="msg-wrap" id="messages_details">




                </div>

                <div class="send-wrap ">
                    <textarea class="form-control send-message" rows="3" placeholder="Gửi tin nhắn phản hồi"
                              id="messageContent">

                    </textarea>
                </div>
                <form class="form-inline" id="messageForm">
                    {!! csrf_field() !!}
                    <div>
                        <input type="button" value="Gửi" id="sendMessDetails" class="btn btn-primary btn-block"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

@stop