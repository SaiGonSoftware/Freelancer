<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><span>Quản trị hệ thống</span></a>
            <ul class="user-menu">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Xin chào {{Auth::user()->username}} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Profile</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span> Settings</a></li>
                        <li><a href="/admin/logout"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>

    </div><!-- /.container-fluid -->
</nav>
<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <form role="search">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </form>
    <ul class="nav menu">
        <li class="active"><a href="{{url('/admin/quan-ly')}}" id="dashboard"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> Dashboard</a></li>
        <li><a href="{{url('/admin/getUserList')}}" id="user"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Quản lý user</a></li>
        <li><a href="/post" id="post"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Duyệt bài viết</a></li>
        <li><a href="/task" id="task"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span> Công việc cần làm</a></li>
        <li role="presentation" class="divider"></li>
    </ul>

</div><!--/.sidebar-->