@extends('ui.userinfo.cv_layout')
@section('content')
<script src="/js/jquery.js"></script>
<script type="text/javascript">
//display cv without contenteditable
$(function(){
 $('.caption').hide();
 $('.rating-container .rating-gly-star').css('display','none');

});
</script>
<style type="text/css">
  .image-upload > input
  {
    display: none;
  }

  .image-upload img
  {
    width: 80px;
    cursor: pointer;
  }
  #avatar{
    width: 100px;
    height: 150px;
  }
</style>
<form action="" method="post" id="cv_form" name="cv_form">
  <button type="submit" id="updateCV" class="btn btn-primary btn-md" style="float:right;margin-bottom:5%">Cập nhật CV</button>
  <input type="hidden" name="cv_id" value="{{uniqid($cv_info->id)}}">
  {!! csrf_field() !!}
  <div id="cv" class="instaFade">
    <div class="mainDetails">
      <div id="headshot" class="quickFade">
        <div class="image-upload">
          <label for="file-input" id="preview">
            <img src="/{{$cv_info->avatar}}" alt="" name="avatar" id="avatar" data-target="#uploadAvatar" data-toggle="modal">
          </label>
        </div>
      </div>

      <div id="name">
        <h1 class="quickFade delayTwo" contenteditable id="username" name="name" style="margin-bottom:20px">{!!$cv_info->name!!}</h1>
        <h2 contenteditable id="job_name" name="job_name" class="quickFade delayThree">{!!$cv_info->  job_name!!}
        </h2>
      </div>

      <div id="contactDetails" class="quickFade delayFour" style="margin-right:20px">
        <ul>
          <li>Email: <a href="#" contenteditable id="email" name="email">{!!$cv_info->  email!!}</a></li>
          <li>Địa Chỉ: <a href="#" contenteditable id="address" name="address">{!!$cv_info->  address!!}</a></li>
          <li>Số Điên Thoại: <a href="#" contenteditable id="phone" name="phone">{!!$cv_info->  phone!!}</a></li>
        </ul>
      </div>
      <div class="clear"></div>
    </div>

    <div id="mainArea" class="quickFade delayFive">
      <section style="margin-bottom:10px">
        <article>
          <div class="sectionTitle">
            <h1>Giới thiệu bản thân</h1>
          </div>

          <div class="sectionContent" contenteditable >
            <div class="capabilities" name="capabilities" >
            {!!$cv_info->  capabilities!!}
            </div>
          </div>


        </article>
        <div class="clear"></div>
      </section>


      <section>
        <div class="sectionTitle">
          <h1>Kinh Nghiệm Làm Việc</h1>
          <input type="button" class="btn btn-primary btn-xs clone" value="Thêm" id="btnAddExp">
          <input type="button" class="btn btn-primary btn-xs delete" value="Xóa" id="btnDelExp">
        </div>

        <div class="sectionContent" id="exContent">
          <article class="experience">
            {!!$cv_info->  experience!!}
          </article>
        </div>
        <div class="clear"></div>
      </section>

      <section>
        <div class="sectionTitle">
          <h1>Học Tập</h1>
          <input type="button" class="btn btn-primary btn-xs clone" value="Thêm" id="btnAddEdu">
          <input type="button" class="btn btn-primary btn-xs delete" value="Xóa" id="btnDelEdu">
        </div>

        <div class="sectionContent" id="eduContent">
          <article class="education">
             {!!$cv_info->  education!!}
          </article>
        </div>
        <div class="clear"></div>
      </section>

      <section>
        <div class="sectionTitle">
          <h1>Kỹ năng</h1>
          <input type="button" class="btn btn-primary btn-xs clone" value="Thêm" id="btnAddSkill">
          <input type="button" class="btn btn-primary btn-xs delete" value="Xóa" id="btnDelSkill">
        </div>

        <div class="sectionContent" id="skill">
          <article class="skill">
            {!!$cv_info->  skill!!}
          </article>
        </div>
        <div class="clear"></div>
      </section>

      <section>
        <div class="sectionTitle">
          <h1>Sở Thích</h1>
          <input type="button" class="btn btn-primary btn-xs clone" value="Thêm" id="btnAddInt">
          <input type="button" class="btn btn-primary btn-xs delete" value="Xóa" id="btnDelInt">
        </div>

        <div class="sectionContent" id="interContent">
          <article class="interests">
              {!!$cv_info->  interests!!}
          </article>
        </div>
        <div class="clear"></div>
      </section>

      <section>
        <div class="sectionTitle">
          <h1>Hoạt Động Cá Nhân</h1>
          <input type="button" class="btn btn-primary btn-xs clone" value="Thêm" id="btnAddAct">
          <input type="button" class="btn btn-primary btn-xs delete" value="Xóa" id="btnDelAct">
        </div>

        <div class="sectionContent"  id="actiContent">
          <article class="activities">
            {!!$cv_info->  activities!!}
         </article>


       </div>
       <div class="clear"></div>
     </section>


   </div>
 </div>
</form>
<div id="uploadAvatar" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="    margin-top: 8%;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="text-center">

                <p>Click hoặc kéo thả ảnh để tải lên!</p>
                <div class="panel-body">
                  <fieldset>
                    {!! csrf_field() !!}
                    <div class="form-group">
                      <div class="image-editor">
                        <div class="cropit-image-preview"></div>
                        <div class="image-size-label">
                          Kéo để chỉnh kích thước hình
                        </div>
                        <input type="range" class="cropit-image-zoom-input">
                        <input type="hidden" name="image-data" class="hidden-image-data" />

                      </div>
                    </div>
                    <button type="button" class="btn btn-lg btn-primary btn-block" id="uploadCVAvatar" >Cập nhật ảnh đại diện</button>
                  </fieldset>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <div class="col-md-12">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        </div>    
      </div>
    </div>
  </div>
</div>

@stop  