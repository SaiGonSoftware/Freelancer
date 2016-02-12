@extends('ui.userinfo.cv_layout')
@section('content')
<script src="/js/jquery.js"></script>
<script type="text/javascript">
//display cv without contenteditable
$(function(){
  var editable_elements = document.querySelectorAll("[contenteditable]");
  $('.caption').hide();
  $('.rating-container .rating-gly-star').css('display','none');
  for(var i=0; i<editable_elements.length; i++)
    editable_elements[i].setAttribute("contentEditable", false);
});
</script>
<a href="/cv/download" type="submit" id="pdfDownload" class="btn btn-primary btn-md" style="">Tải CV PDF </a>
<div id="cv" class="instaFade">
  <div class="mainDetails">
    <div id="headshot" class="quickFade">
    <input type="hidden" name="url" value="{{$_SERVER['REQUEST_URI']}}" id="url">
    {!! csrf_field() !!}
      <img src="/{{$cv_info->avatar}}" name="avatar" id="avatar" style="width: 150px;
      ">

    </div>

    <div id="name" style="padding-left: 5%;">
      <h1 class="quickFade delayTwo" contenteditable id="name" name="name" style="margin-bottom:20px">{!!$cv_info->name!!} </h1>
      <h2 contenteditable id="job_name" name="job_name" class="quickFade delayThree">{!!$cv_info->  job_name!!}
      </h2>
    </div>

    <div id="contactDetails" class="quickFade delayFour">
      <ul>
        <li>Email: <a href="#" contenteditable id="email" name="email">{!!$cv_info->  email!!}</a></li>
        <li>Địa Chỉ: <a href="#" contenteditable id="address" name="address">{!!$cv_info->  address!!}</a></li>
        <li>Số Điên Thoại: <a href="#" contenteditable id="phone" name="phone">{!!$cv_info->  phone!!}</a></li>
      </ul>
    </div>
    <div class="clear"></div>
  </div>

  <div id="mainArea" class="quickFade delayFive">
    <section>
      <article>
        <div class="sectionTitle">
          <h1>Giới thiệu bản thân</h1>
        </div>

        <div class="sectionContent" contenteditable class="capabilities" name="capabilities">
          {!!$cv_info->  capabilities!!}
        </div>
      </article>
      <div class="clear"></div>
    </section>


    <section>
      <div class="sectionTitle">
        <h1>Kinh Nghiệm Làm Việc</h1>
      </div>

      <div class="sectionContent">
        <article class="experience">
         {!!$cv_info->  experience!!}
       </article>
     </div>
     <div class="clear"></div>
   </section>

   <section>
    <div class="sectionTitle">
      <h1>Học Tập</h1>
    </div>

    <div class="sectionContent">
      <article class="education">
        {!!$cv_info->  education!!}
      </article>
    </div>
    <div class="clear"></div>
  </section>

  <section>
    <div class="sectionTitle">
      <h1>Kỹ năng</h1>
    </div>

    <div class="sectionContent" class="skill">
      {!!$cv_info->  skill!!}
    </div>
    <div class="clear"></div>
  </section>

  <section>
    <div class="sectionTitle">
      <h1>Sở Thích</h1>
    </div>

    <div class="sectionContent">
      <article class="interests">
        {!!$cv_info->  interests!!}
      </article>


    </div>
    <div class="clear"></div>
  </section>

  <section>
    <div class="sectionTitle">
      <h1>Hoạt Động Cá Nhân</h1>
    </div>

    <div class="sectionContent">
      <article class="activities">
        {!!$cv_info->  activities!!}
      </article>


    </div>
    <div class="clear"></div>
  </section>


</div>
</div>
@stop  