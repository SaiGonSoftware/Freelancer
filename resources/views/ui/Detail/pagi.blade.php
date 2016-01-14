
	@foreach($job_comment as $jobReply)
	<tr> 
		<td>{{$jobReply -> user -> full_name }}</td> 
		<td>{{$jobReply -> introduce}}</td>
		<td>{{$jobReply -> completed_day}}</td>
		<td>{{number_format($jobReply -> allowance)}}</td>
	</tr> 
	@endforeach()


{!! $job_comment->render() !!}