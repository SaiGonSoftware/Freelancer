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
<form>
	<div class="row" style="margin-left:20%">
		<div class="col-sm-8">
			
			<div class="form-group" id="job-title-group">
				<label for="title">Tên dự án:</label>
				<input type="text" class="form-control" id="title" placeholder="Tên dự án:">
			</div>
			<div class="form-group" id="job-title-group">
				<label for="job-title">Địa điểm</label>
				<div id="location"></div>
			</div>
			<div class="form-group" id="job-region-group">
				<label for="job-region">Các kỹ năng yêu cầu(Tối đa 5 kỹ năng)</label>
				<div id="skill"></div>
			</div>
			<label for="allowance-region">Hãy xác định ngân sách tùy chỉnh của mình</label>
			<div class="input-group input-group-sm col-md-6">
				<input type="number" class="form-control" placeholder="Giá tối thiểu" aria-describedby="sizing-addon3" min="0" id="min-allowance" name="min-allowance">
				<span class="input-group-addon" id="sizing-addon3">VND</span>
			</div>
			<div class="input-group input-group-sm col-md-6">
				<input type="number" class="form-control" placeholder="Giá tối đa" aria-describedby="sizing-addon3" min="0" id="max-allowance" name="max-allowance">
				<span class="input-group-addon" id="sizing-addon3">VND</span>
			</div>
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
			<div class="form-group wysiwyg" id="job-description-group">
				<label>Mô tả chi tiết dự án của bạn:</label>
				<div class="btn-toolbar" data-role="editor-toolbar" data-target="#job-description">
					<div class="btn-group">
						<a class="btn" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
						<a class="btn" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
					</div>
					<div class="btn-group">
						<a class="btn" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="fa fa-list-ul"></i></a>
						<a class="btn" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="fa fa-list-ol"></i></a>
					</div>
					<div class="btn-group">
						<a class="btn" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
						<a class="btn" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
						<a class="btn" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
					</div>
					<div class="btn-group">
						<a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Hyperlink"><i class="fa fa-link"></i></a>
						<div class="dropdown-menu input-append">
							<input class="form-control pull-left" placeholder="http://" type="text" data-edit="createLink">
							<button class="btn btn-primary" type="button">Add</button>
						</div>
						<a class="btn" data-edit="unlink" title="" data-original-title="Remove Hyperlink"><i class="fa fa-unlink"></i></a>
					</div>
					<input type="text" data-edit="inserttext" id="voiceBtn" style="display: none">
				</div>

				<div class="editor" id="job-description" contenteditable="true" style="overflow:scroll"></div>
			</div>
		</div>

	</div>
	<div class="row text-center" style="margin-bottom:2%">
		<p>&nbsp;</p>
		<button class="btn btn-primary btn-lg post-job">Đăng công việc <i class="fa fa-arrow-right"></i></button>
	</div>
</form>

@stop