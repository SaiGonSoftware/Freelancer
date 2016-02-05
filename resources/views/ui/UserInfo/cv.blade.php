@extends('ui.userinfo.cv_layout')
@section('content')
<form action="/cv/saveCV" method="post" id="cv_form" name="cv_form">
    <button type="submit" id="savecv" class="btn btn-primary" style="float:right;margin-bottom:5%">Lưu CV</button>
    {!! csrf_field() !!}
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
                    <div class="col m12 s12 l3 icon"> <!-- icon -->
                        <i class="fa fa-user"></i>
                    </div>                                
                    <div class="col m12 s12 l9 info wow fadeIn a1 animated" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;"> <!-- text -->
                        <div class="section-item-details">
                           <h2 contenteditable id="name" name="name">Al Rayhan</h2> <!-- title name -->
                           <h3 contenteditable id="job_name" name="job_name">UI &amp; UX Expert</h3>
                       </div>             
                   </div>
               </div>         
           </div>
           <!-- sidebar info -->
           <div class="col l12 m12 s12 sort-info sidebar-item">
            <div class="row">                               
                <div class="col m12 s12 l3 icon"> <!-- icon -->
                    <i class="fa fa-thumbs-up"></i>
                </div>                                
                <div class="col m12 s12 l9 info wow fadeIn a1 animated" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;"> <!-- text -->
                    <div class="section-item-details">
                        <h5>Giới thiệu bản thân</h5>
                        <p contenteditable class="capabilities" name="capabilities">Giới thiệu bản thân 
                        </p>
                        </div>             
                    </div>
                </div>         
            </div>
            <!-- MOBILE NUMBER -->
            <div class="col l12 m12 s12  mobile sidebar-item">
                <div class="row">                                
                    <div class="col m12 s12 l3 icon">
                        <i class="fa fa-phone"></i> <!-- icon -->
                    </div>                                
                    <div class="col m12 s12 l9 info wow fadeIn a2 animated" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
                        <div class="section-item-details">
                            <div class="personal">
                                <h4 contenteditable id="phone" name="phone">(111)-333-4444</h4>
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
                        <i class="fa fa-envelope"></i> <!-- icon -->
                    </div>                                
                    <div class="col m12 s12 l9 info wow fadeIn a3 animated" data-wow-delay="0.3s" style="visibility: visible; animation-delay: 0.3s; animation-name: fadeIn;">
                        <div class="section-item-details">
                            <div class="personal">                                    
                                <h4 contenteditable id="email" name="email">mail@alrayhan.com</h4>
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
                                <h4 contenteditable id="address" name="address">
                                    24 Golden Tower
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

                        <span contenteditable id="skill" name="skill">PHP</span>                                    
                        <div class="progress">
                            <div class="determinate" style="width: 70%;" contenteditable><i class="fa fa-circle"></i></div>
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

                                <div class="experience custom-content-wrapper wow fadeIn a2 animated" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
                                    <h3 contenteditable name="experience">UI/UX Designer</h3>
                                    <span contenteditable name="experience">JAN 2013 - DEC 2013 </span>
                                    <p contenteditable name="experience">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut 
                                        labore et dolore magna aliqua. 
                                    </p>
                                </div>


                            </div>                            
                        </div>
                         <div class="section-wrapper z-depth-1">
                            <div class="section-icon col s12 m12 l2">
                                <i class="fa fa-graduation-cap"></i>
                            </div>
                            <div class="custom-content col s12 m12 l10 wow fadeIn a1 animated" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                                <h2>Học Tập </h2>
                                
                                <div class="education custom-content-wrapper wow fadeIn a2 animated" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
                                    <h3 contenteditable name="education">Art Multimedia </h3>
                                    <span contenteditable name="education">JAN 2013 - DEC 2013 </span>
                                    <p contenteditable name="education">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                </div>
                            </div>
                        </div>

                        <div class="section-wrapper z-depth-1">
                            <div class="section-icon col s12 m12 l2">
                                <i class="fa fa-thumbs-up"></i>
                            </div>
                            <div class="custom-content col s12 m12 l10 wow fadeIn a1 animated" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                                <h2 contenteditable>Sở Thích</h2>
                                
                                <div class="interests custom-content-wrapper wow fadeIn a2 animated" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
                                    <h3 contenteditable name="interests">Art &amp; Multimedia </h3>
                                    <h3 contenteditable name="interests">Art &amp; Multimedia </h3>
                                    <h3 contenteditable name="interests">Art &amp; Multimedia </h3>
                                </div>
                            </div>
                        </div>

                        <div class="section-wrapper z-depth-1">
                            <div class="section-icon col s12 m12 l2">
                                <i class="fa fa-headphones"></i>
                            </div>
                            <div class="custom-content col s12 m12 l10 wow fadeIn a1 animated" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                                <h2>Hoạt Động Cá Nhân</h2>
                                
                                <div class="activities custom-content-wrapper wow fadeIn a2 animated" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeIn;">
                                    <h3 contenteditable name="activities">Art &amp; Multimedia </h3>
                                    <h3 contenteditable name="activities">Art &amp; Multimedia </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </form>
    @stop