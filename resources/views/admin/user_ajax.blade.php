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