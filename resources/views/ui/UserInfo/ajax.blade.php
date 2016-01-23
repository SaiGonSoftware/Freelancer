<table class="table table-hover" style="text-align:left"> 
	<thead> 
		<tr> 
			<th>Của dự án - Ngày gửi</th> 
			<th>Giới thiệu bản thân</th> 
			<th>Ngày hoàn thành</th> 
			<th>Đặt giá (VNĐ)</th> 
			<th>Xóa báo giá</th> 
		</tr> 
	</thead> 
	<tbody> 
		<div class="alert alert-danger" role="alert" id="message" style="display:none"></div>
		@foreach($job_comment_list as $jobReply)
		<tr > 
			<td><a href="/chi-tiet-cong-viec/{{$jobReply -> post -> slug }}/{{date("d-m-Y", strtotime($jobReply -> post-> post_at))}}">{{$jobReply -> post -> title }}</a></td> 
			<td id="introduce:{{$jobReply -> id }}" contenteditable="true"><a href="#" > {{$jobReply -> introduce}}</a></td>
			<td id="completed_day:{{$jobReply -> id }}" contenteditable="true"><a href="#">{{$jobReply -> completed_day}}</a></td>
			<td id="allowance:{{$jobReply -> id }}" contenteditable="true"><a href="#" >{{number_format($jobReply -> allowance)}}</a></td>
			<td><input type="button" class="btn btn-primary delComment" value="Xóa" onclick="return confirm('Bạn có chắc chắn muốn xoá ?')" id="delComment" data-id="{{$jobReply -> id }}"></td>
		</tr> 
		@endforeach()
	</tbody> 

</table>
<div class="user_info_comment">
	{!! $job_comment_list->render() !!}
</div>