@extends('ui.layout')
@section('content')

<section id="title">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1>Thông tin chi tiết dự án của bạn</h1>
				
			</div>
		</div>
	</div>
</section>
<hr>
<form action="/job/postNewJob" method="post" id="postNewJobForm">
	{!! csrf_field() !!}
	<div class="row" style="margin-left:20%">
		<div class="col-sm-8">
			
			<div class="form-group" id="job-title-group">
				<label for="title">Tên dự án:</label>
				<input type="text" class="form-control" id="title" name="title" placeholder="Tên dự án:">
			</div>
			<div class="form-group" id="job-title-group">
				<label for="job-title">Địa điểm</label>
				<div id="location" name="location"></div>
			</div>
			<div class="form-group" id="job-region-group">
				<label for="job-region">Các kỹ năng yêu cầu(Tối đa 5 kỹ năng)</label>
				<div id="skill" name="skill"></div>
			</div>
			<label for="allowance-region">Hãy xác định ngân sách tùy chỉnh của mình</label>
			<div class="input-group input-group-md col-md-12">
				<span class="input-group-addon" id="sizing-addon3">VND</span>
				<input type="text" class="form-control" placeholder="Giá tối thiểu" aria-describedby="sizing-addon3" min="0" id="min-allowance" name="min_allowance">
			</div><br>
			<div class="input-group input-group-md col-md-12">
				<span class="input-group-addon" id="sizing-addon3">VND</span>
				<input type="text" class="form-control" placeholder="Giá tối đa" aria-describedby="sizing-addon3" min="0" id="max-allowance" name="max_allowance">
			</div><br>
			<div class="form-group" id="dayopen-region-group">
				<label for="day_open_region">Thời gian nhận báo giá:</label>
				<select name="day_open" class="form-control" style="width:100px">
					<?php $num=1; ?>
					@while ($num<=30)
					<option value="{{$num}}">{{$num}}</option>
					<?php $num++; ?>
					@endwhile
				</select>

			</div>
			<textarea id="job_description" name="job_description" class="form-control" style="overflow:scroll;width:100%;height:100px" ></textarea>

		</div>
	</div>

</div>
<div class="row text-center" style="margin-bottom:2%">
	<p>&nbsp;</p>
	@if(Auth::check())
	<button class="btn btn-primary btn-lg" type="submit" id="post-job">Đăng công việc <i class="fa fa-arrow-right"></i></button>
	@else
	<div class="alert alert-danger" role="alert"  style="width: 45%;
	margin: auto;">Vui lòng đăng nhập để đăng công việc</div>
	@endif
</div>
</form>

@stop