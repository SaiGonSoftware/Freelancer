@extends('ui.userinfo.cv_layout')
@section('content')

<div class="container">
    <div class="row">
     <aside class="col l4 m12 s12 sidebar z-depth-1" id="sidebar">
        <div class="row">                      
            <div class="heading">                            
                <div class="feature-img">
                  <a href=""><img src="/images/avatar.png" class="responsive-img" alt="" width="320px" height="270px" name="avatar" ></a> 
              </div>                                         
          </div>
          <div class="col l12 m12 s12 sort-info sidebar-item">
            <div class="row">                               
                <div class="col m12 s12 l3 icon">
                    <i class="fa fa-user"></i>
                </div>                                
                <div class="col m12 s12 l9 info wow fadeIn a1 animated" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                    <div class="section-item-details">
                        <h2 id="name" name="name">   {!!$cv_info->name!!} </h2>
                        <h3 id="job_name" name="job_name">
                            {!!$cv_info->job_name!!} 
                        </h3>
                    </div>             
                </div>
            </div>         
        </div>
        <div class="col l12 m12 s12 sort-info sidebar-item">
            <div class="row">                               
                <div class="col m12 s12 l3 icon">
                    <i class="fa fa-thumbs-up"></i>
                </div>                                
                <div class="col m12 s12 l9 info wow fadeIn a1 animated" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                    <div class="section-item-details">
                        <h5>Giới thiệu bản thân</h5>
                        {!!$cv_info->capabilities!!} 
                    </div>             
                </div>
            </div>         
        </div>
        <div class="col l12 m12 s12  mobile sidebar-item">
            <div class="row">                                
                <div class="col m12 s12 l3 icon">
                    <i class="fa fa-phone"></i>
                </div>                                
                <div class="col m12 s12 l9 info wow fadeIn a2 animated" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
                    <div class="section-item-details">
                        <div class="personal">
                            <h4  id="phone" name="phone">
                             {!!$cv_info->phone!!} 
                         </h4>
                         <span>Điện Thoại</span> 
                     </div>
                 </div>
             </div>
         </div>             
     </div>
     <!--  EMAIL -->
     <div class="col l12 m12 s12  email sidebar-item ">
        <div class="row">                                
            <div class="col m12 s12 l3 icon">
                <i class="fa fa-envelope"></i>
            </div>                                
            <div class="col m12 s12 l9 info wow fadeIn a3 animated" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeIn;">
                <div class="section-item-details">
                    <div class="personal">                                    
                        <h4 id="email" name="email">
                         {!!$cv_info->email!!} 
                     </h4>
                     <span>Email</span> 
                 </div>
             </div>
         </div> 
     </div>          
 </div>
 <!-- ADDRESS  -->
 <div class="col l12 m12 s12  address sidebar-item ">
    <div class="row">                                
        <div class="col l3 m12  s12 icon">
            <i class="fa fa-home"></i> <!-- icon -->
        </div>                                
        <div class="col m12 s12 l9 info wow fadeIn a4 animated" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeIn;">
            <div class="section-item-details">
                <div class="address-details">
                    <h4 id="address" name="address">
                     {!!$cv_info->address!!} 
                 </h4> 
             </div>                         
         </div>
     </div>
 </div>            
</div>
<div class="col l12 m12 s12  skills sidebar-item">
    <div class="row">
        <div class="col m12 l3 s12 icon">
            <i class="fa fa-calendar-o"></i>
        </div>
        <div class="col m12 l9 s12 skill-line a5 wow fadeIn animated" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeIn;">
            <h3>Kỹ năng </h3>

            <span id="skill" name="skill">PHP</span>                                    
            <div class="progress">
                <div class="determinate" style="width: 70%;"><i class="fa fa-circle"></i></div>
            </div>


        </div>
    </div>
</div>
</div>  
</aside>
<section class="col s12 m12 l8 section">
    <div class="row">
        <div class="section-wrapper z-depth-1">                            
            <div class="section-icon col s12 m12 l2">
                <i class="fa fa-suitcase"></i>
            </div>
            <div class="custom-content col s12 m12 l10 wow fadeIn a1 animated" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                <h2>Kinh Nghiệm Làm Việc</h2>

                <div class="custom-content-wrapper wow fadeIn a2 animated" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
                 {!!$cv_info->experience!!} 
             </div>


         </div>                            
     </div>
     <div class="section-wrapper z-depth-1">
        <div class="section-icon col s12 m12 l2">
            <i class="fa fa-graduation-cap"></i>
        </div>
        <div class="custom-content col s12 m12 l10 wow fadeIn a1 animated" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
            <h2>Học Tập </h2>

            <div class="custom-content-wrapper wow fadeIn a2 animated" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
                {!!  $cv_info->education !!} 
            </div>
        </div>
    </div>

    <div class="section-wrapper z-depth-1">
        <div class="section-icon col s12 m12 l2">
            <i class="fa fa-thumbs-up"></i>
        </div>
        <div class="custom-content col s12 m12 l10 wow fadeIn a1 animated" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
            <h2 >Sở Thích</h2>

            <div class="custom-content-wrapper wow fadeIn a2 animated" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
             {!!$cv_info->interests!!} 
         </div>
     </div>
 </div>

 <div class="section-wrapper z-depth-1">
    <div class="section-icon col s12 m12 l2">
        <i class="fa fa-headphones"></i>
    </div>
    <div class="custom-content col s12 m12 l10 wow fadeIn a1 animated" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
        <h2>Hoạt Động Cá Nhân</h2>

        <div class="custom-content-wrapper wow fadeIn a2 animated" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
         {!!$cv_info->activities!!} 
     </div>
 </div>
</div>
</div>
</section>
</div>
</div>
@stop