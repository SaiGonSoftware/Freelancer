@extends('ui.layout')
@section('content')
<div class="container" style="margin-top:5%;margin-bottom:10%">
    <div class="hidden-xs col-sm-3" >
      <ul class="nav nav-tabs list-group" role="tablist">
        <a href="#" aria-controls="home" role="tab" class="list-group-item active" data-toggle="tab" >Xin chào {{Auth::user()->full_name}}</a>
        <a href="#profile" class="list-group-item" aria-controls="profile" role="tab" data-toggle="tab">Profile</a>
        <!-- <a href="#messages" class="list-group-item" aria-controls="messages" role="tab" data-toggle="tab">Messages</a>
        <a href="#settings" class="list-group-item" aria-controls="settings" role="tab" data-toggle="tab">Settings</a> -->
      </ul>
    </div>
    <!-- THIS IS NOT NEEDED, THIS IS JUST THE CONTENT OF THE DEMO -->
    <div class="col-xs-12 col-sm-9 tab-content">
        <p class="small text-muted">Published May 19, 2015 by Mouse0270</p>
        <h3 id="intro" class="title">Fading Side Menu</h3>
        <p class="lead">Lets Focus on Content</p>
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="home"></div>
          <div role="tabpanel" class="tab-pane" id="profile">
              @foreach($userDetail as $user)
                  @if(isset($user->social_id))
                     <img src="{{$user->avatar}}" style="width:100px;margin-left: 40%;">
                     <form action="/" class="dropzone"  style="width:200px;"></form>

                  @endif
              @endforeach()
          </div>
         <!--  <div role="tabpanel" class="tab-pane" id="messages">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
         <div role="tabpanel" class="tab-pane" id="settings">...</div> -->
        </div>
    </div>
</div>

@stop