@extends('admin.layout')
@include('admin.menu')

@section('content')
<div class="tab-content" >
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<div class="panel panel-primary">
        <div class="panel-heading">Chi tiết bài viết</div>
        <div class="panel-body">
        @foreach ($jobContent as $job_Content)
          {{$job_Content->content}}
        @endforeach
      </div>
    </div>
  </div>
</div>
</div>

@stop
