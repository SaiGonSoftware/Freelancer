<!DOCTYPE html>
<html>

<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="Cộng đồng freelancer Việt">
		<meta name="author" content="Ngô Hùng Phúc">
		<title>Freelancer</title>
		<link rel="shortcut icon" href="/images/favicon.png">
		<link href="/css/style.css" rel="stylesheet">
		<link href="/valid/css/formValidation.min.css" rel="stylesheet">
	</head>
<body id="home">
<div class="container-fluid">
	<div class="row" style="margin-top:8%">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Đăng nhập</div>
				<div class="panel-body">
						<div class="alert alert-danger">
							<strong>Sai tên đăng nhập hoặc mật khẩu vui lòng thử lại</strong>
						</div>

				<form  action="{{ url('/authen/login') }}" method="POST" name="SignInForm" id="login_form" >
					<input type="hidden" name="_token" value="{!! csrf_token() !!}">
						<a class="btn btn-facebook"><i class="fa fa-facebook"></i>Sign In with Facebook</a><br>
						<a class="btn btn-google"><i class="fa fa-google-plus"></i>Sign In with Google</a>
					<div class="form-group">
						<label for="login-username">Username</label>
						<input type="text" class="form-control" id="username" name="usernameLogin">
					</div>
					<div class="form-group">
						<label for="login-password">Password</label>
						<input type="password" class="form-control" id="password" name="passwordLogin">
					</div>
					<button type="submit" class="btn btn-primary" id="login_btn">Đăng nhập</button>
				</form>
				</div>
			</div>
		</div>
	</div>
</div>
		<script src="/js/modernizr.custom.79639.js"></script>
		<script src="/js/jquery-1.11.2.min.js"></script>
		<script src="/js/bootstrap.min.js"></script>
		<script src="/js/retina.min.js"></script>
		<script src="/js/scrollReveal.min.js"></script>
		<script src="/js/jquery.flexmenu.js"></script>
		<script src="/js/pagi.js"></script>
		<script src="/js/jquery.ba-cond.min.js"></script>
		<script src="/js/jquery.slitslider.js"></script>
		<script src="/js/owl.carousel.min.js"></script>
		<script src="/js/parallax.js"></script>
		<script src="/js/jquery.counterup.min.js"></script>
		<script src="/js/waypoints.min.js"></script>
		<script src="/js/jquery.nouislider.all.min.js"></script>
		<script src="/js/bootstrap-wysiwyg.js"></script>
		<script src="/js/jquery.hotkeys.js"></script>
		<script src="/js/jflickrfeed.min.js"></script>
		<script src="/js/fancybox.pack.js"></script>
		<script src="/js/magic.js"></script>
		<script src="/js/settings.js"></script>
		<script src="/js/angular.min.js"></script>
		<script src="/js/val.js"></script>
		<script src="/js/user.js"></script>
		<script src="/valid/js/formValidation.min.js"></script>
        <script src="/valid/js/bootstrap.min.js"></script>
	</body>

</html>