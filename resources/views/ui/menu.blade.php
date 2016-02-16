<div class="fm-container">
    <!-- Menu -->
    <div class="menu">
        <div class="button-close text-right">
            <a class="fm-button"><i class="fa fa-close fa-2x"></i></a>
        </div>
        <ul class="nav">
            <li class="active"><a href="{{url()}}">Trang chủ</a>
            </li>
            <li><a href="">Việc làm</a>
            </li>
            <li><a href="{{ url() }}/cong-viec-freelancer">Đăng tin freelancer</a>
            </li>
            <li><a href="{{ url() }}/tin-tuyen-dung">Đăng tin tuyển dụng</a>
            </li>
            <li><a href="{{ url() }}/tim-viec">Tìm Việc</a>
            </li>
            <li><a href="">Tìm freelancer</a>
            </li>
            <li><a href="#">Pages</a>
                <ul>
                    <li><a href="">CV nổi bật</a>
                    </li>
                    <li><a href="">Blog </a>
                    </li>
                    <li><a href="">Thông tin</a>
                    </li>
                </ul>
            </li>
            @if(Auth::check())
            <li><a class="">Xin chào {{ Auth::user()->username }} </a>
            </li>
            <li><a href="#">Quản lý tài khoản</a>
                <ul>
                    <li>
                        <a href="/tai-khoan/thong-tin-ca-nhan/{{Auth::user()->username}}/{{Auth::user()->remember_token}}">Thông tin cá nhân</a>
                    </li>
                    <li><a href="{{ url('/dang-xuat') }}">Đăng xuất</a>
                    </li>
                </ul>
            </li>
            @else
            <li><a class="link-register">Đăng ký</a>
            </li>
            <li><a class="link-login">Đăng nhập</a>
            </li>
            @endif
        </ul>
    </div>
    <!-- end Menu -->
</div>
<header>
    <div id="header-background"></div>
    <div class="container">
        <div class="pull-left">
            <div id="logo">
                <a href="{{url()}}"><img src="/images/icon.png" alt="Cộng đồng freelancer lớn nhất Việt Nam" title="Cộng đồng freelancer lớn nhất Việt Nam" style="width:15%" />
                </a>
            </div>
        </div>
        <div id="menu-open" class="pull-right">
            <a class="fm-button"><i class="fa fa-bars fa-lg"></i></a>
        </div>
        <div id="searchbox" class="pull-right">
            <form>
                <div class="form-group">
                    <label class="sr-only" for="searchfield">Searchbox</label>
                    <input type="text" class="form-control" id="searchfield" placeholder="Tìm kiếm">
                </div>
            </form>
        </div>
        <div id="search" class="pull-right">
            <a><i class="fa fa-search fa-lg"></i></a>
        </div>
    </div>
</header>