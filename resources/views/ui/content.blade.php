@extends('ui.layout')
@section('content')
<!-- ============ SLIDES START ============ -->
@include('ui.slider')
<!-- ============ SLIDES END ============ -->

<!-- ============ JOBS START ============ -->

<section id="jobs">
	<div class="container">
		<div class="row">

			<div class="col-sm-8">
				<h2>Công việc mới nhất</h2>
				<div class="jobs">
					@foreach($content as $jobPost)
					<a href="chi-tiet-cong-viec/{{$jobPost -> slug}}/{{date("d-m-Y", strtotime($jobPost -> post_at))}}">
						<div class="featured"></div>
						<img src="{{$jobPost->user->avatar}}" alt="{{$jobPost->title}}" class="img-circle" />
						<div class="title">
							<h5 style="width: 150px">
								{{$jobPost -> title}}</h5>
								<p>{{date("d-m-Y", strtotime($jobPost -> post_at))}}</p>
								<p>Đăng bởi: {{$jobPost->user->full_name}}</p>

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

					<a class="btn btn-primary" id="more-jobs" href="tim-viec">
						<span class="">Xem thêm <i class="fa fa-arrow-down"></i></span>
					</a>

				</div>

				<div class="col-sm-4">
					<h2>Tin tuyển dụng mới nhất</h2>
					<a href="/tin-tuyen-dung/{{$recruit_job  -> slug }}/{{date("d-m-Y", strtotime($recruit_job -> post_at))}}" target="_blank" >
						<img src="images/featured-job.jpg" alt="Featured Job" class="img-responsive" />
						<div class="featured-job">
							<div class="title">
								<h5>{{$recruit_job->title}}</h5>
							</div>
							<div class="data">
								<span class="city"><i class="fa fa-map-marker"></i>{{$recruit_job->location}}</span>
								<span class="type full-time"><i class="fa fa-clock-o"></i>Kinh nghiệm: {{ ($recruit_job ->	experience_year)}} năm</span>
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

	<!-- ============ JOBS END ============ -->

	<!-- ============ STATS START ============ -->

	<section id="stats" class="parallax text-center">
		<div class="tint"></div>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h1>Cho đến nay chúng tôi đã có</h1>
				</div>
			</div>
			<div class="row" id="counter">

				<div class="counter">
					<div class="number">{{$totalUser}}</div>
					<div class="description">Members</div>
				</div>

				<div class="counter">
					<div class="number">{{$totalJob}}</div>
					<div class="description">Jobs</div>
				</div>

				<div class="counter">
					<div class="number">1,482</div>
					<div class="description">Resumes</div>
				</div>

				<div class="counter">
					<div class="number">83</div>
					<div class="description">Companies</div>
				</div>

			</div>
			<div class="row">
				<div class="col-sm-12">
					<p><a class="link-register btn btn-primary">Join Us</a></p>
				</div>
			</div>
		</div>
	</section>

	<!-- ============ STATS END ============ -->
	<!-- ============ COMPANIES START ============ -->

	@include('ui.companies')

	<!-- ============ COMPANIES END ============ -->

	@stop