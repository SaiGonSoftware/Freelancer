<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <link rel="stylesheet" href="/admin/application.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
</head>
<body>
<div class="container">
    <div class="row">
        <form class="form-signin mg-btm" id="form_signin">
            <h3 class="heading-desc">
                <button type="button" class="close pull-right" aria-hidden="true">×</button>
                Đăng nhập quản trị
            </h3>

            <div class="captcha-box">
                <div class="row mg-btm">
                    <div class="col-md-12">
                        <a href="#">
                            {!! captcha_img() !!}
                        </a>
                    </div>
                </div>

            </div>
            <div class="main">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span><input type="text" class="form-control"
                                                                                        placeholder="Tài khoản">
                <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span><input type="password"
                                                                                            class="form-control"
                                                                                            placeholder="Mật khẩu">
                <span class="glyphicon glyphicon-barcode" aria-hidden="true"></span><input type="text"
                                                                                           class="form-control"
                                                                                           placeholder="Captcha">

            </div>
            <div class="login-footer">
                <div class="row">
                    <div class="col-xs-6 col-md-6">
                        <div class="left-section">
                            <a href="#">Quên mật khẩu ?</a>

                        </div>
                    </div>
                    <div class="col-xs-6 col-md-6 pull-right">
                        <button type="submit" class="btn btn-large btn-danger pull-right">Login</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
</form>
</body>
</html>