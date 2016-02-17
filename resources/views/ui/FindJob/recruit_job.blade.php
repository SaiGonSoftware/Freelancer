@extends('ui.layout')
@section('content')
<section id="title">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1>Tìm Việc Làm</h1>
				<h4>Hãy Lựa Chọn Công Việc Phù Hợp Với Bạn</h4>
			</div>
		</div>
	</div>
</section>

<section id="jobs">
	<div class="container">
		<div class="row" >
			<div class="col-sm-8" id="recruit_pagi">
				<h2>Công việc hiện có</h2>

				<div class="jobs">

					<!-- Job offer -->
					@foreach($job_pagi as $jobPost)
					<a href="/chi-tiet-cong-viec/{{$jobPost -> slug}}/{{date("d-m-Y", strtotime($jobPost -> post_at))}}">
						<div class="featured"></div>
						<img src="{{$jobPost->user->avatar}}" alt="{{$jobPost->title}}" class="img-circle" />
						<div class="title">
							<h5 style="width: 150px">
								{{$jobPost -> title}}
							</h5>
							<p>{{date("d-m-Y", strtotime($jobPost -> post_at))}}</p>
							<p>Đăng bởi: {{$jobPost->user->full_name}}
							</p> 

						</div>
						<div class="data">
							<span class="city"><i class="fa fa-map-marker"></i>{{$jobPost -> location}}</span>
							<span class="type full-time">
								<i class="fa fa-user"></i>Số lượng: {{ ($jobPost -> 	quantity)}}
							</span>
							<i class="fa fa-dollar"></i>{{ ($jobPost -> salary)}}
						</div>
					</a>
					@endforeach


				</div>

				<div class="paging_recruit">
					{!! $job_pagi->render() !!}
				</div>					

				

			</div>
			<div class="col-sm-4" id="sidebar">


				<h2>Tin tuyển dụng mới nhất</h2>
				<a href="/tin-tuyen-dung/{{$recruit_job  -> slug }}/{{date("d-m-Y", strtotime($recruit_job -> post_at))}}" target="_blank" >
					<img src="images/featured-job.jpg" alt="Featured Job" class="img-responsive" />
					<div class="featured-job">
						<div class="title">
							<h5>{{$recruit_job->title}}</h5>
						</div>
						<div class="data">
							<span class="city"><i class="fa fa-map-marker"></i>{{$recruit_job->location}}</span>
							<span class="type full-time"><i class="fa fa-clock-o"></i>Kinh nghiệm: {{ ($recruit_job ->	experience_year)}} năm&nbsp;
							<i class="fa fa-user"></i>Số lượng: {{ ($recruit_job -> 	quantity)}}
							</span>
							<span class="sallary"><i class="fa fa-dollar"></i>{{$recruit_job->salary}}</span>
						</div>
						<div class="description" style="height:150px;
						width: 100%;
						display:inline-block;
						white-space: nowrap;
						overflow:hidden !important;
						text-overflow: ellipsis;">
						{!!$recruit_job -> content!!}</div>
					</div>
				</a>

			</div>
		</div>
	</div>
</section>
@stop