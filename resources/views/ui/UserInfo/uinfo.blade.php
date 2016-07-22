@extends('ui.layout')
@section('content')
<div class="container" style="margin-top:10%;margin-bottom:10%">
    <div class="hidden-xs col-sm-3">
        <ul class="nav nav-tabs list-group" role="tablist">
            <a href="#" aria-controls="home" role="tab" class="list-group-item active" data-toggle="tab">Xin
            chào {{Auth::user()->full_name}}</a>
            <a href="#profile" class="list-group-item" aria-controls="profile" role="tab" data-toggle="tab">Thông
            tin cá nhân</a>
            <a href="#manage" class="list-group-item" aria-controls="manage" role="tab" data-toggle="tab">Quản lý
            CV</a>
            <a href="#settings" class="list-group-item" aria-controls="settings" role="tab" data-toggle="tab">Cài
            đặt</a>
            <a href="#comment" class="list-group-item" aria-controls="comment" role="tab" data-toggle="tab">Báo giá
            đã đăng</a>
            <a href="#job" class="list-group-item" aria-controls="job" role="tab" data-toggle="tab">Công việc đã
            đăng</a>
            <a href="#job_recruit" class="list-group-item" aria-controls="job" role="tab" data-toggle="tab">Tin
            tuyển dụng đã đăng</a>
        </ul>
    </div>
    @if(Auth::Check())
    <div class="col-xs-12 col-sm-9 tab-content">
        <!-- <p class="small text-muted">Published May 19, 2015 by Mouse0270</p> -->
        <h2 id="intro" class="title" style="text-align:left;margin-bottom:5%">
        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>{{Auth::user()->full_name}}
        </h2>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="home"></div>
            <div role="tabpanel" class="tab-pane" id="profile">
                <img src="/{{$userDetail->avatar}} " style="width:100px;margin-left: 40%;"
                class="userAvatarUpload">
                <form id="formAvatar" action="/tai-khoan/thong-tin-ca-nhan/{{$userDetail->username}}/upload"
                    method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <label class="control-label">Cập nhật ảnh đại diện</label>
                    <input id="avatar" type="file" name="file" class="file-loading" id="avatarFile">
                    <div id="errorBlock" class="help-block"></div>
                    <input type="submit" class="btn btn-danger" value="Upload" id="btnAvatar"
                    style="margin-top:5px">
                </form>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0"
                        aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        <span class="sr-only">0% Complete</span>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="manage">
                <a href="/cv/tao-cv" target="_blank" class="btn btn-info" style="margin-bottom:10px">Tạo CV</a>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Danh sách các cv đã tạo</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Xem CV</th>
                                    <th>Sửa CV</th>
                                    <th>Xóa CV</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 1;?>
                                @foreach ($list_cv as $cv_list)
                                <tr>
                                    {!! csrf_field() !!}
                                    <th scope="row">{{$num}}</th>
                                    <td>
                                        <a href="/cv/xem-cv/{{$username}}/{{uniqid($cv_list->id)}}"
                                        target="_blank" class="btn btn-info">Xem CV</a>
                                    </td>
                                    <td>
                                        <a href="/cv/sua-cv/{{$username}}/{{uniqid($cv_list->id)}}"
                                        target="_blank" class="btn btn-primary">Sửa CV</a>
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger deleteCV"
                                        data-id="{{uniqid($cv_list->id)}}" value="Xóa CV">
                                    </td>
                                </tr>
                                <?php $num++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="settings">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cập nhật mật khẩu</h3>
                    </div>
                    <div class="panel-body">
                        <form id="formNewPassword" action="{{ url('/updatePassword') }}" method="post">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="password">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="newpassword"
                                placeholder="Mật khẩu mới từ 5-30 kí tự" name="newpassword">
                            </div>
                            <div class="form-group">
                                <label for="repassword">Nhập lại mật khẩu </label>
                                <input type="password" class="form-control" id="repassword" name="repassword">
                            </div>
                            <input type="submit" class="btn btn-info" value="Cập nhật mật khẩu" id="btnNewPass"
                            style="margin-top:5px">
                        </form>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane active" id="comment">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Tổng hợp các báo giá đã đăng</h3>
                    </div>
                    <div class="panel-body" id="comment_content">
                        <table class="table table-hover" style="text-align:left">
                            <thead>
                                <tr>
                                    <th>Của dự án - Ngày gửi</th>
                                    <th>Giới thiệu bản thân</th>
                                    <th>Ngày hoàn thành</th>
                                    <th>Đặt giá (VNĐ)</th>
                                    <th>Xóa báo giá</th>
                                    <th>Tình trạng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div class="alert alert-danger" role="alert" id="message"
                                style="display:none"></div>
                                @foreach($job_comment_list as $jobUserPost)
                                <tr id="comment_list">
                                    <td>
                                        <a href="/chi-tiet-cong-viec/{{$jobUserPost -> post -> slug }}/{{date("d-m-Y", strtotime($jobUserPost -> post-> post_at))}}"
                                        target="_blank">{{$jobUserPost -> post -> title }}</a></td>
                                        <td id="introduce:{{$jobUserPost -> id }}" contenteditable="true"><a
                                        href="#"> {{$jobUserPost -> introduce}}</a></td>
                                        <td id="completed_day:{{$jobUserPost -> id }}" contenteditable="true"><a
                                        href="#">{{$jobUserPost -> completed_day}}</a></td>
                                        <td id="allowance:{{$jobUserPost -> id }}" contenteditable="true"><a
                                        href="#">{{number_format($jobUserPost -> allowance)}}</a></td>
                                        <td><input type="button" class="btn btn-primary delComment" value="Xóa"
                                        id="delComment" data-id="{{$jobUserPost -> id }}"></td>
                                        <td>
                                            @if($jobUserPost->approved!=null)
                                            @if($jobUserPost->approved->user_assign==Auth::user()->id && $jobUserPost->approved->job_id==$jobUserPost -> post-> id)
                                            <div class="alert alert-danger" role="alert"> Công việc được
                                                giao hoàn thành ngay
                                            </div>
                                            @endif
                                            @else
                                            <div class="alert alert-info" role="alert">Đang đợi duyệt</div>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach()
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="job">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Tổng hợp các công việc đã đăng</h3>
                        </div>
                        <div class="panel-body" id="comment_content">
                            <table class="table table-hover" style="text-align:left">
                                <thead>
                                    <tr>
                                        <th>Của dự án - Ngày gửi</th>
                                        <th>Ngày đăng</th>
                                        <th>Xóa công việc</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div class="alert alert-danger" role="alert" id="message"
                                    style="display:none"></div>
                                    @foreach($jobpost as $jobUserPost)
                                    <tr id="comment_list">
                                        <td>
                                            <a href="/chi-tiet-cong-viec/{{$jobUserPost  -> slug }}/{{date("d-m-Y", strtotime($jobUserPost -> post_at))}}"
                                            target="_blank">{{$jobUserPost -> title }}</a></td>
                                            <td>{{date("d-m-Y", strtotime($jobUserPost -> post_at))}}</td>
                                            <td><input type="button" class="btn btn-primary delJobUserPost" value="Xóa"
                                            data-id="{{$jobUserPost -> id }}"></td>
                                        </tr>
                                        @endforeach()
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="job_recruit">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Tổng hợp các tin tuyển dụng đã đăng</h3>
                            </div>
                            <div class="panel-body" id="comment_content">
                                <table class="table table-hover" style="text-align:left">
                                    <thead>
                                        <tr>
                                            <th>Tiêu đề</th>
                                            <th>Ngày đăng</th>
                                            <th>Xóa tin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div class="alert alert-danger" role="alert" id="message"
                                        style="display:none"></div>
                                        @foreach($recruit_job as $jobUserPost)
                                        <tr id="comment_list">
                                            <td>
                                                <a href="/tin-tuyen-dung/{{$jobUserPost  -> slug }}/{{date("d-m-Y", strtotime($jobUserPost -> post_at))}}"
                                                target="_blank">{{$jobUserPost -> title }}</a></td>
                                                <td>{{date("d-m-Y", strtotime($jobUserPost -> post_at))}}</td>
                                                <td><input type="button" class="btn btn-primary delJobRecruit"
                                                value="Xóa tin" data-id="{{$jobUserPost -> id }}"></td>
                                            </tr>
                                            @endforeach()
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @stop