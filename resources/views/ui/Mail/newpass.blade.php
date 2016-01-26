@extends('ui.layout')
@section('content')
<div class="container-fluid" style="margin-top:11%">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">New Password</div>
				<div class="panel-body">
					
					<form id="newpassReset" class="form-horizontal" role="form" method="POST" action="/password/new">
						{!! csrf_field() !!}
						<input type="hidden" name="url" id="url" value="{{$_SERVER['REQUEST_URI']}}
						">
						<div class="form-group">
							<label class="col-md-4 control-label">Mật khẩu mới</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="newpassword" id="newpassword">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary" id="resetPass">Cập nhật mật khẩu</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
