@extends('ui.layout')
@section('content')
<section id="title">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 text-center">
						<h1>{{$job -> title}}</h1>
						<h4 style="margin-top:10px">
							<span><i class="fa fa-map-marker"></i>{{$job -> location}}</span>
							<span><i class="fa fa-clock-o"></i>{{date("d-m-Y", strtotime($job -> post_at))}} Mở trong {{$job -> day_open}} ngày</span>
							<span><i class="fa fa-dollar"></i>{{number_format ($job -> allowance_min)."d"."-".number_format ($job -> allowance_max)."d"}}</span>
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
							<p>{{$job -> content}}</p>
							<h3>Yêu cầu công việc</h3>
							<!-- <ul>
								<li>Aliquam rhoncus justo eget tellus scelerisque, at mollis mi aliquam.</li>
								<li>Quisque pretium convallis pulvinar.</li>
								<li>Nulla rutrum nisi mi, iaculis commodo nibh lobortis sed.</li>
								<li>Sed pulvinar, nunc vitae molestie dapibus, lacus dolor dignissim sapien.</li>
								<li>Pellentesque ipsum ex, imperdiet quis consequat sed, consectetur ut ante.</li>
								<li>Aliquam libero felis, mollis vitae elementum vel, bibendum eu tortor.</li>
								<li>Morbi rhoncus luctus interdum.</li>
							</ul>
							<h3>Benefits</h3>
							<ul>
								<li>Aliquam rhoncus justo eget tellus scelerisque, at mollis mi aliquam.</li>
								<li>Quisque pretium convallis pulvinar.</li>
								<li>Nulla rutrum nisi mi, iaculis commodo nibh lobortis sed.</li>
								<li>Sed pulvinar, nunc vitae molestie dapibus, lacus dolor dignissim sapien.</li>
								<li>Pellentesque ipsum ex, imperdiet quis consequat sed, consectetur ut ante.</li>
								<li>Aliquam libero felis, mollis vitae elementum vel, bibendum eu tortor.</li>
								<li>Morbi rhoncus luctus interdum.</li>
							</ul> -->
							<div class="panel panel-primary">
								 <div class="panel-heading"> 
								 	<h3 class="panel-title">Báo Giá</h3> 
								 </div>
							
							 <div class="panel-body">
								<table class="table table-hover"> 
									<thead> 
										<tr> 
											<th>Freelancer đặt giá</th> 
											<th>Giới thiệu bản thân</th> 
											<th>Ngày hoàn thành</th> 
											<th>Đặt giá (VNĐ)</th> 
										</tr> 
									</thead> 
									<tbody> 
									@foreach($job->comments as $jobReply)
									<tr> 
										 <td>{{$jobReply -> user -> full_name }}</td> 
										 <td>{{$jobReply -> introduce}}</td>
										 <td>{{$jobReply -> completed_day}}</td>
										 <td>{{number_format($jobReply -> allowance)}}</td>
									</tr> 
								@endforeach()
									</tbody> 
								</table>
							 </div>
							 </div>
							<p>
							<div class="input-group">
								<a href="#" class="btn btn-primary btn-lg" id="apply_job">Gửi báo giá</a>
								&nbsp;
							</div> 
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
							
							<p>Người đăng: {{$job -> user -> full_name}}</p>
							
						</div>
						<hr>
						<div class="sidebar-widget" id="company-jobs">
							<h2>Các công việc liên quan khác</h2>
							<ul>
							<?php $num=1; ?>
							@foreach($related_job as $relatedJob)
							
								<li>
									<a href="/chi-tiet-cong-viec/{{$relatedJob -> slug}}/{{date("d-m-Y", strtotime($relatedJob -> post_at))}}.html">
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