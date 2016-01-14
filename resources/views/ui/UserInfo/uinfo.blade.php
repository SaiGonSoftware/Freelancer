@extends('ui.layout')
@section('content')
<div class="container" style="margin-top:5%;margin-bottom:10%">
  <div class="hidden-xs col-sm-3" >
    <ul class="nav nav-tabs list-group" role="tablist">
      <a href="#" aria-controls="home" role="tab" class="list-group-item active" data-toggle="tab" >Xin chào {{Auth::user()->full_name}}</a>
      <a href="#profile" class="list-group-item" aria-controls="profile" role="tab" data-toggle="tab">Thông tin cá nhân</a>
      <a href="#manage" class="list-group-item" aria-controls="manage" role="tab" data-toggle="tab">Quản lý tài khoản</a>
      <a href="#settings" class="list-group-item" aria-controls="settings" role="tab" data-toggle="tab">Cài đặt</a>
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
        @foreach($userDetail as $user)
        <img src="/{{$user->avatar}}" style="width:100px;margin-left: 40%;" id="userAvatar">
        <form id="formAvatar" action="/tai-khoan/thong-tin-ca-nhan/{{$user->username}}/upload" method="post" enctype="multipart/form-data"> 
         {!! csrf_field() !!}
         <label class="control-label">Cập nhật ảnh đại diện</label>
         <input id="avatar"  type="file" name="file" class="file-loading" id="avatarFile">
         <div id="errorBlock" class="help-block"></div>
         <input type="submit" class="btn btn-danger" value="Upload" id="btnAvatar" style="margin-top:5px">
       </form>
       <div class="progress">
        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
          <span class="sr-only">0% Complete</span>
        </div>
      </div>
      <hr>
      <br>
      <br>
      <div >
        <div class="panel panel-primary"> 
          <div class="panel-heading"> 
            <h3 class="panel-title">Cập nhật mật khẩu</h3> 
          </div>
          <div class="panel-body">  
            <form id="formPassword" action="/tai-khoan/thong-tin-ca-nhan/{{$user->username}}/updatePass" method="post">
               {!! csrf_field() !!}
              <div class="form-group">
                <label for="password">Mật khẩu mới</label>
                <input type="password" class="form-control" id="password" placeholder="Mật khẩu mới từ 5-30 kí tự" name="password">
              </div>
              <div class="form-group">
                <label for="repassword">Nhập lại mật khẩu </label>
                <input type="password" class="form-control" id="repassword" name="repassword">
              </div>
              <input type="submit" class="btn btn-info" value="Cập nhật mật khẩu" id="btnNewPass" style="margin-top:5px">
            </form>
          </div> 
        </div>

      </div>

      @endforeach()
    </div>
    <div role="tabpanel" class="tab-pane" id="manage">
     <form>
      <div class="row">
        <div class="col-sm-6">
          <h2>Job Details</h2>
          <div class="form-group" id="job-email-group">
            <label for="job-email">Email</label>
            <input type="email" class="form-control" id="job-email" placeholder="you@yourdomain.com">
          </div>
          <div class="form-group" id="job-title-group">
            <label for="job-title">Title</label>
            <input type="text" class="form-control" id="job-title" placeholder="e.g. Web Designer">
          </div>
          <div class="form-group" id="job-location-group">
            <label for="job-location">Location (Optional)</label>
            <input type="text" class="form-control" id="job-location" placeholder="e.g. New York">
          </div>
          <div class="form-group" id="job-region-group">
            <label for="job-region">Region</label>
            <select  class="form-control" id="job-region">
              <option>Choose a region</option>
              <option>New York</option>
              <option>Los Angeles</option>
              <option>Chicago</option>
              <option>Boston</option>
              <option>San Francisco</option>
            </select>
          </div>
          <div class="form-group" id="job-type-group">
            <label for="job-type">Job Type</label>
            <select  class="form-control" id="job-type">
              <option>Choose a job type</option>
              <option>Freelance</option>
              <option>Part Time</option>
              <option>Full Time</option>
              <option>Internship</option>
              <option>Volunteer</option>
            </select>
          </div>
          <div class="form-group" id="job-category-group">
            <label for="job-category">Job Category</label>
            <select  class="form-control" id="job-category">
              <option>Choose a job category</option>
              <option>Internet Services</option>
              <option>Banking</option>
              <option>Financial</option>
              <option>Marketing</option>
              <option>Management</option>
            </select>
          </div>
          <div class="form-group wysiwyg" id="job-description-group">
            <label>Description</label>

            <div class="btn-toolbar" data-role="editor-toolbar" data-target="#job-description">
              <div class="btn-group">
                <a class="btn" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                <a class="btn" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
              </div>
              <div class="btn-group">
                <a class="btn" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="fa fa-list-ul"></i></a>
                <a class="btn" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="fa fa-list-ol"></i></a>
              </div>
              <div class="btn-group">
                <a class="btn" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                <a class="btn" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                <a class="btn" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
              </div>
              <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Hyperlink"><i class="fa fa-link"></i></a>
                <div class="dropdown-menu input-append">
                  <input class="form-control pull-left" placeholder="http://" type="text" data-edit="createLink">
                  <button class="btn btn-primary" type="button">Add</button>
                </div>
                <a class="btn" data-edit="unlink" title="" data-original-title="Remove Hyperlink"><i class="fa fa-unlink"></i></a>
              </div>
              <input type="text" data-edit="inserttext" id="voiceBtn" style="display: none;">
            </div>

            <div class="editor" id="job-description" contenteditable="true">Job description</div>
          </div>
          <div class="form-group" id="job-url-group">
            <label for="job-url">Application Email/URL</label>
            <input type="text" class="form-control" id="job-url" placeholder="Email or Website URL">
          </div>
        </div>
        <div class="col-sm-6">
          <h2>Company Details</h2>
          <div class="form-group" id="company-name-group">
            <label for="company-name">Company Name</label>
            <input type="text" class="form-control" id="company-name" placeholder="Enter company name">
          </div>
          <div class="form-group" id="company-tagline-group">
            <label for="company-tagline">Tagline (Optional)</label>
            <input type="text" class="form-control" id="company-tagline" placeholder="Brief description">
          </div>
          <div class="form-group wysiwyg" id="company-description-group">
            <label>Description (Optional)</label>

            <div class="btn-toolbar" data-role="editor-toolbar" data-target="#company-description">
              <div class="btn-group">
                <a class="btn" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                <a class="btn" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
              </div>
              <div class="btn-group">
                <a class="btn" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="fa fa-list-ul"></i></a>
                <a class="btn" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="fa fa-list-ol"></i></a>
              </div>
              <div class="btn-group">
                <a class="btn" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                <a class="btn" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                <a class="btn" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
              </div>
              <div class="btn-group">
                <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Hyperlink"><i class="fa fa-link"></i></a>
                <div class="dropdown-menu input-append">
                  <input class="form-control pull-left" placeholder="http://" type="text" data-edit="createLink">
                  <button class="btn btn-primary" type="button">Add</button>
                </div>
                <a class="btn" data-edit="unlink" title="" data-original-title="Remove Hyperlink"><i class="fa fa-unlink"></i></a>
              </div>
              <input type="text" data-edit="inserttext" id="voiceBtn2" style="display: none;">
            </div>

            <div class="editor" id="company-description" contenteditable="true">Company description...</div>
          </div>
          <div class="form-group" id="company-video-group">
            <label for="company-video">Video (Optional)</label>
            <input type="text" class="form-control" id="company-video" placeholder="Video URL">
          </div>
          <div class="form-group" id="company-website-group">
            <label for="company-website">Website (Optional)</label>
            <input type="text" class="form-control" id="company-website" placeholder="http://">
          </div>
          <div class="form-group" id="company-google-group">
            <label for="company-google">Google+ Username (Optional)</label>
            <input type="text" class="form-control" id="company-google" placeholder="yourcompany">
          </div>
          <div class="form-group" id="company-facebook-group">
            <label for="company-facebook">Facebook Username (Optional)</label>
            <input type="text" class="form-control" id="company-facebook" placeholder="yourcompany">
          </div>
          <div class="form-group" id="company-linkedin-group">
            <label for="company-linkedin">LinkedIn Username (Optional)</label>
            <input type="text" class="form-control" id="company-linkedin" placeholder="yourcompany">
          </div>
          <div class="form-group" id="company-twitter-group">
            <label for="company-twitter">Twitter Username (Optional)</label>
            <input type="text" class="form-control" id="company-twitter" placeholder="@yourcompany">
          </div>
          <div class="form-group" id="company-logo-group">
            <label for="company-logo">Logo (Optional)</label>
            <input type="file" id="company-logo">
          </div>
        </div>
      </div>
      <div class="row text-center">
        <p>&nbsp;</p>
        <a href="#" class="btn btn-primary btn-lg">Preview <i class="fa fa-arrow-right"></i></a>
      </div>
    </form>
  </div>
  <div role="tabpanel" class="tab-pane" id="settings">
    @foreach($userDetail as $user)
    <img src="{{$user->avatar}}" style="width:100px;margin-left: 40%;">
    @endforeach()
  </div>
  @endif
</div>
</div>
</div>

@stop

