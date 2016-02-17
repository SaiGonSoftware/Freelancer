@extends('ui.layout')
@section('content') 
<section id="title">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1>{{$job -> title}}</h1>
				<h4 style="margin-top:10px">
					<span><i class="fa fa-map-marker"></i>{{$job -> location}}</span>
					<span><i class="fa fa-dollar"></i>{{ ($job -> 	salary)}}</span>
					<span><i class="fa fa-user"></i>Số lượng: {{ ($job -> 	quantity)}}</span>
					<span><i class="fa fa-thumbs-up"></i>Kinh nghiệm: {{ ($job -> 	experience_year)}} năm</span>
				</h4>
			</div>
		</div>
	</div>
</section>

<!-- ============ TITLE END ============ -->

<!-- ============ CONTENT START ============ -->

<section id="jobs">
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<article>
					<h2>Chi tiết công việc</h2>
					<p>
						{!!$job -> content!!}<br>
					</p>

				</article>
			</div>
			<div class="col-sm-4" id="sidebar">
				<div class="sidebar-widget" id="share">
					<h2>Chia Sẻ Công Việc Này</h2>
					<ul>
						<li><a href=""><i class="fa fa-facebook"></i></a></li>
						<li><a href=""><i class="fa fa-twitter"></i></a></li>
						<li><a href=""><i class="fa fa-google-plus"></i></a></li>
					</ul>
				</div>
				<hr>
				<div class="sidebar-widget" id="company">
					<h2>Thông tin công việc</h2>

					<p><img src="/{{$job->user->avatar}}" style="width:100px" /><br>Người đăng: {{$job -> user -> full_name}}<br>
						<button type="button" class="btn btn-info " id="sendMess">Gửi tin nhắn</button>
					</p>

				</div>
				<hr>
				<div class="sidebar-widget" id="company-jobs">
					<h2>Các công việc liên quan khác</h2>
					<ul>
						<?php $num=1; ?>
						@foreach($related_job as $relatedJob)

						<li>
							<a href="/tin-tuyen-dung/{{$relatedJob -> slug}}/{{date("d-m-Y", strtotime($relatedJob -> post_at))}}">
								{{$num}}/{{$relatedJob -> title}}
							</a>
						</li>
						<?php $num++; ?>
						@endforeach()

					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
@stop

