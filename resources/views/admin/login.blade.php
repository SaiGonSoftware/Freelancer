@extends('admin.layout')
@section('content')

    <div class="container" id="form_signin">
        <div class="row">
            <form class="form-signin mg-btm" action="/adminLogin" method="POST">
                <h3 class="heading-desc">
                    <button type="button" class="close pull-right" aria-hidden="true">×</button>
                    Đăng nhập quản trị
                    <img style="width:20%;display:none" id="loading" src="/images/loading.gif">
                    <div class="alert alert-danger" style="display: none" id="status">

                        <div id="status_message"></div>

                    </div>

                </h3>

                <div class="captcha-box">
                    {!! csrf_field() !!}
                    <div class="row mg-btm">
                        <div class="col-md-12" id="captcha_img">
                            <?= captcha_img(); ?>
                        </div>
                    </div>

                </div>
                <div class="main">
                    <?php $username = isset($_POST['username']) ? $_POST['username'] : '';
                    $password = isset($_POST['password']) ? $_POST['password'] : '';?>
                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span><input type="text"
                                                                                            class="form-control"
                                                                                            placeholder="Tài khoản"
                                                                                            id="username"
                                                                                            name="username"
                                                                                            value="<?=$username?>">
                    <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span><input type="password"
                                                                                                class="form-control"
                                                                                                placeholder="Mật khẩu"
                                                                                                id="password"
                                                                                                name="password"
                                                                                                value="<?=$password?>">
                    <span class="glyphicon glyphicon-barcode" aria-hidden="true"></span><input type="text"
                                                                                               class="form-control"
                                                                                               placeholder="Captcha"
                                                                                               id="captcha"
                                                                                               name="captcha">

                </div>
                <div class="login-footer">
                    <div class="row">
                        <div class="col-xs-6 col-md-6">
                            <div class="left-section">
                                <a href="#">Quên mật khẩu ?</a>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6 pull-right">
                            <button type="button" class="btn btn-large btn-danger pull-right" id="loginAdmin">Login
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

@stop
