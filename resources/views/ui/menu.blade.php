<nav class="navbar navbar-default navbar-fixed-top" style="margin-top: 0%;font-size: 15px;">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-6" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <a class="navbar-brand" href="{{url()}}"><img src="/images/icon.png" alt="Cộng đồng freelancer lớn nhất Việt Nam" title="Cộng đồng freelancer lớn nhất Việt Nam" style="width:12%" />
            </a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown ">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Quản lý tài khoản <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        @if(Auth::check())
                        <li style="margin-left:-15px"><a style="line-height: 40px">Hi <img class="media-object" alt="64x64" style="width: 32px; height: 32px;float: left;
                            margin-right: 10px;" src="/{{Auth::user()->avatar}}" id="user_avatar"><span id="welcome_user"> {{ Auth::user()->username }}</span> </a>
                        </li>
                        <li><a href="{{ url() }}/tin-nhan/{{Auth::user()->username}}"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
                        @if ($total_mess!=null)
                           ({{$total_mess}}) Tin nhắn
                        @else
                            Tin nhắn
                        @endif
                   </a>
               </li>

               <li>
                <a href="/tai-khoan/thong-tin-ca-nhan/{{Auth::user()->username}}/{{Auth::user()->remember_token}}">Thông tin cá nhân</a>
            </li>
            <li><a href="{{ url('/dang-xuat') }}">Đăng xuất</a>
            </li>

            @else
            <li><a class="link-register">Đăng ký</a>
            </li>
            <li><a class="link-login">Đăng nhập</a>
            </li>

            @endif

        </ul>
    </li>
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Thông tin công việc <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url() }}/danh-sach-tin-tuyen-dung">Tin Tuyển Dụng</a>
            </li>
            <li><a href="{{ url() }}/tin-tuyen-dung">Đăng tin tuyển dụng</a>
            </li>
            <li><a href="{{ url() }}/cong-viec-freelancer">Đăng tin freelancer</a>
            </li>
            <li><a href="{{ url() }}/tim-viec">Tìm Việc Freelancer</a>
            </li>
        </ul>
    </li>
</ul>
</div>
</div>
</nav>