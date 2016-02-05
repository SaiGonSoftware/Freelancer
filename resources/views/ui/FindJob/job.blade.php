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
			<div class="col-sm-8" id="ajax_pagi">
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
								<i class="fa fa-clock-o"></i>
								@if ($jobPost->taken==0)
								Công việc mở
								@else
								Đóng
								@endif
							</span>
							<span class="sallary">Chi Phí:<br>{{number_format ($jobPost -> allowance_min)."d"."-".number_format ($jobPost -> allowance_max)."d"}}</span>
						</div>
					</a>
					@endforeach


				</div>

				<div class="paging_job">
					{!! $job_pagi->render() !!}
				</div>					

				

			</div>
			<div class="col-sm-4" id="sidebar">

				<!-- Featured Jobs Start -->
				<div class="sidebar-widget">
					<h2>Tin tuyển dụng</h2>
					<a href="#">
						<img src="images/featured-job.jpg" alt="Featured Job" class="img-responsive" />
						<div class="featured-job">
							<img src="images/job1.jpg" alt="" class="img-circle pull-left" />
							<div class="title">
								<h5>Web Designer</h5>
								<p>Amazon</p>
							</div>
							<div class="data">
								<span class="city"><i class="fa fa-map-marker"></i>New York City</span>
								<span class="type full-time"><i class="fa fa-clock-o"></i>Full Time</span>
								<span class="sallary"><i class="fa fa-dollar"></i>45,000</span>
							</div>
							<div class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque tristique euismod lorem, a consequat orci consequat a. Donec ullamcorper tincidunt nunc, ut aliquam est pellentesque porta. In neque erat, malesuada sit amet orci ac, laoreet laoreet mauris.</div>
						</div>
					</a>
				</div>
				<!-- Featured Jobs End -->

				<!-- Find a Job Start -->
				<div class="sidebar-widget" id="jobsearch">
					<h2>Tags Cloud</h2>
					<form>
						<div class="row">
							<div class="col-xs-12">
								<div class="tags" style="float:left">
									@foreach ($tag as $tags)
									<a href="/cong-viec/{{$tags->slug}}"  class="danger" id="tag_href">
										{{$tags->name}}
									</a>
									@endforeach	
								</div>
							</div>
						</div>
						<div class="row">
							<div class="row">
								<div class="col-xs-12">
									<h5>Experience</h5>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									<p>More than <b><span id="years-field"></span></b> years</p>
								</div>
								<div class="col-xs-6">
									<div class="form-slider" id="years"></div>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<hr>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<h5>Kinh phí</h5>
									<div class="form-slider" id="salary"></div>
									<p>Từ <b><span id="salary-field-lower"></span></b> to  <b><span id="salary-field-upper"></span></b></p>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<hr>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<a class="btn btn-primary">Reset All Filters</a>
								</div>
							</div>
						</form>
					</div>
					<!-- Find a Job End -->

				</div>
			</div>
		</div>
	</section>
	@stop