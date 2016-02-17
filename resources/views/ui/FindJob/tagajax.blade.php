<h2>Công việc hiện có</h2>
<div class="jobs">
	@if (isset($tag_cotent))
	@foreach($tag_cotent as $jobPost)
	<a href="/chi-tiet-cong-viec/{{$jobPost -> slug}}/{{date("d-m-Y", strtotime($jobPost -> post_at))}}">
		<div class="featured"></div>
		<img src="/{{$jobPost->avatar}}" alt="{{$jobPost->title}}" class="img-circle" />
		<div class="title">
			<h5 style="width: 150px">
				{{$jobPost -> title}}
			</h5>
			<p>{{date("d-m-Y", strtotime($jobPost -> post_at))}}</p>
			<p>Đăng bởi: {{$jobPost->full_name}}
			</p>  

		</div>
		<div class="data">
			<span class="city"><i class="fa fa-map-marker"></i>{{$jobPost -> location}}</span>
			<span class="type full-time">
				<i class="fa fa-clock-o"></i>
				Hết hạn :<br>{{date("d-m-Y", strtotime($jobPost -> deadline))}}
			</span>
			<span class="sallary">Chi Phí:<br>{{number_format ($jobPost -> allowance_min)."d"."-".number_format ($jobPost -> allowance_max)."d"}}</span>
		</div>
	</a>
	@endforeach



</div>
@else
<div class="alert alert-info" role="alert"> 
	<strong>Công việc hiện tại chưa có </strong>
</div>					


@endif
<div class="tag_job">
	{!! $tag_cotent->render() !!}
</div>