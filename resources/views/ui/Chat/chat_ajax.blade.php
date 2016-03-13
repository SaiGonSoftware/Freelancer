@foreach ($chat_message as $message)
    <div class="pull-left" href="#">
        <img class="media-object" style="width: 50px; height: 50px;;"  src="/{{$message->user->avatar}}">
    </div>
    <div class="media-body">
        <small class="pull-right time"><i class="fa fa-clock-o"></i> {{date("d-m-Y H:i:s", strtotime($message->created_at))}}</small>
        <h5 class="media-heading"> {{$message->from_user}}</h5>
        <small>{{$message->content}}</small>
    </div>

@endforeach