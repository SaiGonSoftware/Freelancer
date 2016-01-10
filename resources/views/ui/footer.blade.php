<footer>
    <div id="prefooter">
        <div class="container">
            <div class="row">
                <div class="col-sm-6" id="newsletter">
                    <h2>Đăng ký nhận những thông tin mới nhất</h2>
                    <form class="form-inline">
                        <div class="form-group">
                            <label class="sr-only" for="newsletter-email">Email address</label>
                            <input type="email" class="form-control" id="newsletter-email" placeholder="Email address">
                        </div>
                        <button type="submit" class="btn btn-primary" id="subcribeMail">Đăng ký</button>
                    </form>
                </div>
                <div class="col-sm-6" id="social-networks">
                    <h2>Giữ liên lạc với chúng tôi</h2>
                    <a href="#"><i class="fa fa-2x fa-facebook-square"></i></a>
                    <a href="#"><i class="fa fa-2x fa-twitter-square"></i></a>
                    <a href="#"><i class="fa fa-2x fa-google-plus-square"></i></a>
                    <a href="#"><i class="fa fa-2x fa-youtube-square"></i></a>
                    <a href="#"><i class="fa fa-2x fa-vimeo-square"></i></a>
                    <a href="#"><i class="fa fa-2x fa-pinterest-square"></i></a>
                    <a href="#"><i class="fa fa-2x fa-linkedin-square"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div id="credits">
        <div class="container text-center">
            <div class="row">
                <div class="col-sm-12">
                    Cộng đồng Freelancer Việt
                    <br> &copy; Phát triển bởi Ngô Hùng Phúc
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- ============ REGISTER START ============ -->

<div class="popup" id="register">
    <div class="popup-form">
        <div class="popup-header">
            <a class="close"><i class="fa fa-remove fa-lg"></i></a>
            <h2>Đăng ký</h2>
        </div>
        <form action="{{ url('/user/register') }}" method="POST" name="RegisterForm" id="register_form_popup">
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <ul class="social-login">
                <li><a class="btn btn-facebook" href="{{url('auth/facebook')}}"><i class="fa fa-facebook"></i>Đăng ký với Facebook</a>
                </li>
            </ul>
            <hr>
            <div class="form-group">
                <label for="register-name">Tên Đăng Nhập</label>
                <input type="text" class="form-control" id="register-name" name="usernameRegis">
                <span id="username_status"></span>
            </div>
            <div class="form-group">
                <label for="register-surname">Tên Hiển Thị</label>
                <input type="text" class="form-control" id="register-surname" name="fullnameRegis">
            </div>
            <div class="form-group">
                <label for="register-email">Email</label>
                <input type="email" class="form-control" id="register-email" name="emailRegis">
                <span id="email_status"></span>
            </div>
            <hr>
            <div class="form-group">
                <label for="register-password1">Mật khẩu</label>
                <input type="password" class="form-control" id="register-password1" name="passwordRegis">
            </div>
            <div class="form-group">
                <label for="register-password2">Nhập lại mật khẩu</label>
                <input type="password" class="form-control" id="register-password2" name="rePassword">
            </div>
            <div class="form-group">
                <label class="control-label" id="captchaOperation">Captcha</label>
                <input type="text" class="form-control" name="captcha" />
            </div>
            <button type="submit" class="btn btn-primary" id="regis_btn">Đăng ký</button>
        </form>
    </div>
</div>
<!-- ============ REGISTER END ============ -->



<div class="popup" id="login">
    <div class="popup-form">
        <div class="popup-header">
            <a class="close"><i class="fa fa-remove fa-lg"></i></a>
            <h2>Đăng nhập</h2>
            <img style="width:20%;display:none" id="loading" src="/images/loading.gif">
        </div>
        <form action="{{URL::to('authen/login')}}" method="POST" name="SignInForm" id="login_form">
            <div class="alert alert-danger" role="alert" id="message" style="display:none"></div>
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <ul class="social-login">
                <li><a class="btn btn-facebook" href="{{url('auth/facebook')}}"><i class="fa fa-facebook"></i>Đăng nhập với Facebook</a>
                </li>
            </ul>
            <hr>
            <div class="form-group">
                <label for="login-username">Username</label>
                <input type="text" class="form-control" id="username" name="usernameLogin">
            </div>
            <div class="form-group">
                <label for="login-password">Password</label>
                <input type="password" class="form-control" id="password" name="passwordLogin">
            </div>
            <button type="button" class="btn btn-primary" id="login_btn">Đăng nhập</button>
        </form>
    </div>
</div>

<!-- ============ LOGIN END ============ -->