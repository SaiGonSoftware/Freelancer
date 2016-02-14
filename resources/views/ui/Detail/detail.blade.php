@extends('ui.layout')
@section('content') 
<section id="title">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1>{{$job -> title}}</h1>
				<h4 style="margin-top:10px">
					<span><i class="fa fa-map-marker"></i>{{$job -> location}}</span>
					<span><i class="fa fa-clock-o"></i>Hết hạn : {{date("d-m-Y", strtotime($job -> deadline))}}</span>
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
					<p>
						{!!$job -> content!!}<br>
					</p>
					
					@if($job -> description)
					<h3>Hình ảnh mô tả</h3>
					<img src="/{{$job -> description}}">
					@endif
					<h3>Yêu cầu công việc</h3>
					@if(isset($tag))
					<div class="tags">
						@foreach ($tag as $tags)
						<a href="#"  class="danger" id="tag_href">
							{{$tags}}
						</a>
						@endforeach
						
					</div>
					@endif
					<div class="panel panel-primary">
						<div class="panel-heading"> 
							<h3 class="panel-title">Báo Giá</h3> 
						</div>

						<div class="panel-body"  id="job_comment_post" style="text-align:left">
							<table class="table table-hover" > 
								<thead> 
									<tr> 
										<th>Freelancer đang đặt giá</th> 
										<th>Giới thiệu bản thânn</th> 
										<th>Ngày hoàn thành</th> 
										<th>Đặt giá (VNĐ)</th>
										@if($job -> user_id==Auth::user()->id)
										<th>Giao Công Việc</th>  
										@endif
									</tr> 
								</thead> 
								<tbody> 
									@foreach($job_comment as $jobReply)
									<tr> 
										<td>{{$jobReply -> user -> full_name }}</td> 
										<td>{{$jobReply -> introduce}}</td>
										<td>{{$jobReply -> completed_day}}</td>
										<td>{{number_format($jobReply -> allowance)}}</td>
										@if($job -> user_id==Auth::user()->id)
										<td>
											<button type="button" id="assignJob" class="btn btn-danger btn-xs">Giao Việc</button>
										</td>
										@endif
									</tr> 
									@endforeach()
								</tbody> 
							</table>
							<div class="details_pagi">
								{!! $job_comment->render() !!}
							</div>


						</div>

					</div>
					<p>
						<div class="panel panel-primary">
							<div class="panel-heading"> 
								<h3 class="panel-title">BÁO GIÁ CHO DỰ ÁN NÀY</h3> 
							</div>

							<div class="panel-body">
								<form id="commentForm" name="commentForm" action="{{URL::to('/postComment') }}" method="post">
									{!! csrf_field() !!}
									<input type="hidden" name="job_id" id="job_id" value="{{$job -> id}}">
									<div class="form-group">
										<label for="allowance">Chi phí trả cho bạn(VND):</label>
										<input type="text" class="form-control" id="allowance" name="allowance" >
									</div>
									<div class="form-group">
										<label for="completed_day">Hoàn thành dự án trong(Ngày):</label>
										<input type="text" class="form-control" id="completed_day" name="completed_day" >
									</div>
									<div class="form-group">
										<label for="introduce">Đề xuất:
											Lý do gì khiến bạn là ứng viên tốt nhất cho dự án này</label>
											<textarea id="introduce" name="introduce" cols="100%" rows="10" style="width=100%;height=100%" ></textarea>
										</div>
										@if(Auth::check() && $job ->active ===1)
										<button type="button" class="btn btn-info" disabled="disabled">Hết hạn báo giá</button>
										&nbsp;
										@elseif(Auth::check() && $job ->active ===0)
										<button type="submit" class="btn btn-info" id="btnInsertComment">Gửi báo giá</button>
										@else
										<div class="alert alert-danger" role="alert">Vui lòng đăng nhập để gửi báo giá</div>
										@endif

									</form>										


								</div>

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
								<a href="/chi-tiet-cong-viec/{{$relatedJob -> slug}}/{{date("d-m-Y", strtotime($relatedJob -> post_at))}}">
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

