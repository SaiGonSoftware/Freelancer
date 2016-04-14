@extends('admin.layout')
@include('admin.menu')

@section('content')
<div class="tab-content" >
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<div class="panel panel-primary">
                <div class="panel-heading">Quản lý user</div>
                <div class="panel-body" id="user_content_ajax">
                 <table class="table table-hover"> 
                     <thead> 
                        <tr> 
                            <th>#</th> 
                            <th>Avatar</th> 
                            <th>Username</th> 
                            <th>Full_name</th>
                            <th>Email</th>
                            <th>Active</th>
                            <th>Deactive</th> 
                        </tr> 
                    </thead> 
                    <tbody>
                    <?php $i=1;?>
                    {{csrf_field()}}
                    @foreach ($user as $user_list)

                       <tr> 
                          <th scope="row">{{$i}}</th>
                          <td><img src="/{{$user_list->avatar}}" alt="{{$user_list->username}}" title="{{$user_list->username}}" style="width:100px"></td>
                          <td>{{$user_list->username}}</td> 
                          <td>{{$user_list->full_name}}</td>
                          <td>{{$user_list->email}}</td>  
                          <th>
                            @if ($user_list->active==1)
                              Active
                            @else Disable
                            @endif
                          </th>
                          <td><input type="button" data-id="{{$user_list->id}}" value="Deactive" class="btn btn-danger btn-deactive"></td> 
                      </tr> 
                      <?php $i++?>
                    @endforeach
                    <div class="paging_user pull-right">
                        {!! $user->render()!!}
                    </div>
                  </tbody> 
              </table>
          </div>
      </div>
		</div>
	</div>
</div>

@stop
