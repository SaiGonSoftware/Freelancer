 @foreach($job_comment_list as $jobReply)
 <tr id="comment_content"> 
 	<td><a href="/chi-tiet-cong-viec/{{$jobReply -> post -> slug }}/{{date("d-m-Y", strtotime($jobReply -> post-> post_at))}}">{{$jobReply -> post -> title }}</a></td> 
 	<td id="introduce:{{$jobReply -> id }}" contenteditable="true"><a href="#" > {{$jobReply -> introduce}}</a></td>
 	<td id="completed_day:{{$jobReply -> id }}" contenteditable="true"><a href="#">{{$jobReply -> completed_day}}</a></td>
 	<td id="allowance:{{$jobReply -> id }}" contenteditable="true"><a href="#" >{{number_format($jobReply -> allowance)}}</a></td>
 	<td><input type="button" class="btn btn-primary delComment" value="Xóa" onclick="ConfirmDelete()" id="delComment" data-id="{{$jobReply -> id }}"></td>
 </tr> 
 @endforeach()