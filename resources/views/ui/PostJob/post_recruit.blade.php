@extends('ui.layout')
@section('content')

<section id="title">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h1>Thông tin chi tiết tin tuyển dụng</h1>
				
			</div>
		</div>
	</div>
</section>
<hr>
<form action="/job/postNewRecruit" method="post" id="postNewRecruit">
	{!! csrf_field() !!}
	<div class="row" style="margin-left:20%">
		<div class="col-sm-8">
			
			<div class="form-group" id="job-title-group">
				<label for="title">Tiêu đề:</label>
				<input type="text" class="form-control" id="title" name="title" placeholder="Tiêu đề:">
			</div>
			<div class="form-group" id="job-title-group">
				<label for="location">Địa điểm</label>
				<div id="location" name="location"></div>
			</div>
			<div class="form-group" id="job-title-group">
				<label for="salary_number">Mức lương công việc:</label>
				<input type="text" class="form-control" id="salary_number" name="salary_number" placeholder="Mức lương công việc">
			</div>
			<div class="form-group" id="job-title-group">
				<label for="experience_year">Kinh nghiệm tối thiểu(Năm):</label>
				<input type="number" class="form-control" id="experience_year" name="experience_year" placeholder="Kinh nghiệm tối thiểu(Năm)">
			</div>
			<div class="form-group" id="job-title-group">
				<label for="quantity">Số lượng</label>
				<input type="number" class="form-control" id="quantity" name="quantity" placeholder="Số lượng">
			</div>
			<div class="form-group" id="descriptionImg-group">
				<label for="content">Yêu cầu chi tiết công việc</label>
				<textarea id="content" name="content" class="form-control" style="overflow:scroll;width:100%;height:200px" ></textarea>
			</div>
		</div>
	</div>

</div>
<div class="row text-center" style="margin-bottom:2%">
	<p>&nbsp;</p>
	@if(Auth::check())
	<button class="btn btn-primary btn-lg" type="submit" id="post-recruit">Đăng công việc <i class="fa fa-arrow-right"></i></button>
	@else
	<div class="alert alert-danger" role="alert"  style="width: 45%;
	margin: auto;">Vui lòng đăng nhập để đăng công việc</div>
	@endif
</div>
</form>

@stop