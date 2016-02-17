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
			<div class="col-sm-8" id="ajax_pagi_tag">
				<h2>Công việc hiện có</h2>
				<div class="jobs">
					@if (isset($check))
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


					@else
					<div class="alert alert-info" role="alert"> 
						Công việc hiện tại chưa có
					</div>					

					@endif
				</div>
				
				
				<div class="tag_job">
					{!! $tag_cotent->render() !!}
				</div>

				
				

			</div>
			<div class="col-sm-4" id="sidebar">

				<h2>Tin tuyển dụng mới nhất</h2>
				<a href="/tin-tuyen-dung/{{$recruit_job  -> slug }}/{{date("d-m-Y", strtotime($recruit_job -> post_at))}}" target="_blank" >
				<img src="/images/featured-job.jpg" alt="Featured Job" class="img-responsive" />
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
						text-overflow: ellipsis;margin-bottom:50px">
						{!!$recruit_job -> content!!}</div>
					</div>
				</a>


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