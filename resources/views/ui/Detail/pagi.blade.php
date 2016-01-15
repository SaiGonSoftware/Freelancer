
<table class="table table-hover" > 
	<thead> 
		<tr> 
			<th>Freelancer đặt giá</th> 
			<th>Giới thiệu bản thân</th> 
			<th>Ngày hoàn thành</th> 
			<th>Đặt giá (VNĐ)</th> 
		</tr> 
	</thead> 
	<tbody> 
		@foreach($job_comment as $jobReply)
		<tr> 
			<td>{{$jobReply -> user -> full_name }}</td> 
			<td>{{$jobReply -> introduce}}</td>
			<td>{{$jobReply -> completed_day}}</td>
			<td>{{number_format($jobReply -> allowance)}}</td>
		</tr> 
		@endforeach()
	</tbody> 
</table>
<div class="details_pagi">
	{!! $job_comment->render() !!}
</div>

