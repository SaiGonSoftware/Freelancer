
<table class="table table-hover"> 
 <thead> 
  <tr> 
    <th>#</th> 
    <th>Title</th> 
    <th>Post_at</th>
    <th>Active</th> 
    <th>Delete</th> 
  </tr> 
</thead> 
<tbody>
  <?php $i=1;?>
  {{csrf_field()}}
  @foreach ($post as $post_list)

  <tr> 
    <th scope="row">{{$i}}</th>
    <td class="job_title"><a href="/admin/viewJobContent/{{$post_list->id}}">{{$post_list->title}}</a></td>
    <td>{{date("d-m-Y", strtotime($post_list -> post_at))}}</td> 
    <th>
      @if ($post_list->active==1)
      Close
      @else Open
      @endif
    </th>
    <td><input type="button" data-id="{{$post_list->id}}" value="Delete" class="btn btn-danger btn-delete"></td> 
  </tr> 
  <?php $i++?>
  @endforeach
  <div class="paging_job pull-right">
    {!! $post->render()!!}
  </div>
</tbody> 
</table>
