@foreach ($chat_message as $message)
    <a class="pull-left" href="#">
        <img class="media-object" data-src="holder.js/64x64" alt="64x64"
             style="width: 50px; height: 50px;" src="/{{$message->user->avatar}}">
    </a>
    <div class="media-body">
        <h5 class="media-heading"> {{$message->from_user}}</h5>
        <small>{{$message->content}}</small>
    </div>

@endforeach