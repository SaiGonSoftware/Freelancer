@extends('auth.layout')
@section('content')
<div id="headerbar">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-2">
                <a href="#" class="shortcut-tiles tiles-brown">
                    <div class="tiles-body">
                        <div class="pull-left"><i class="fa fa-pencil"></i></div>
                    </div>
                    <div class="tiles-footer">
                        Create Post
                    </div>
                </a>
            </div>
            <div class="col-xs-6 col-sm-2">
                <a href="#" class="shortcut-tiles tiles-grape">
                    <div class="tiles-body">
                        <div class="pull-left"><i class="fa fa-group"></i></div>
                        <div class="pull-right"><span class="badge">2</span></div>
                    </div>
                    <div class="tiles-footer">
                        Contacts
                    </div>
                </a>
            </div>
            <div class="col-xs-6 col-sm-2">
                <a href="#" class="shortcut-tiles tiles-primary">
                    <div class="tiles-body">
                        <div class="pull-left"><i class="fa fa-envelope-o"></i></div>
                        <div class="pull-right"><span class="badge">10</span></div>
                    </div>
                    <div class="tiles-footer">
                        Messages
                    </div>
                </a>
            </div>
            <div class="col-xs-6 col-sm-2">
                <a href="#" class="shortcut-tiles tiles-inverse">
                    <div class="tiles-body">
                        <div class="pull-left"><i class="fa fa-camera"></i></div>
                        <div class="pull-right"><span class="badge">3</span></div>
                    </div>
                    <div class="tiles-footer">
                        Gallery
                    </div>
                </a>
            </div>

            <div class="col-xs-6 col-sm-2">
                <a href="#" class="shortcut-tiles tiles-midnightblue">
                    <div class="tiles-body">
                        <div class="pull-left"><i class="fa fa-cog"></i></div>
                    </div>
                    <div class="tiles-footer">
                        Settings
                    </div>
                </a>
            </div>
            <div class="col-xs-6 col-sm-2">
                <a href="#" class="shortcut-tiles tiles-orange">
                    <div class="tiles-body">
                        <div class="pull-left"><i class="fa fa-wrench"></i></div>
                    </div>
                    <div class="tiles-footer">
                        Plugins
                    </div>
                </a>
            </div>

        </div>
    </div>
</div>

<header class="navbar navbar-inverse navbar-fixed-top" role="banner">
    <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>
    <a id="rightmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="left" title="Toggle Infobar"></a>

    <div class="navbar-header pull-left">
        <a class="navbar-brand" href="index.html">Avant</a>
    </div>

    <ul class="nav navbar-nav pull-right toolbar">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle username" data-toggle="dropdown"><span class="hidden-xs">John McCartney <i class="fa fa-caret-down"></i></span><img src="assets/demo/avatar/dangerfield.png" alt="Dangerfield" /></a>
            <ul class="dropdown-menu userinfo arrow">
                <li class="username">
                    <a href="#">
                        <div class="pull-left"><img src="assets/demo/avatar/dangerfield.png" alt="Jeff Dangerfield"/></div>
                        <div class="pull-right"><h5>Howdy, John!</h5><small>Logged in as <span>john275</span></small></div>
                    </a>
                </li>
                <li class="userlinks">
                    <ul class="dropdown-menu">
                        <li><a href="#">Edit Profile <i class="pull-right fa fa-pencil"></i></a></li>
                        <li><a href="#">Account <i class="pull-right fa fa-cog"></i></a></li>
                        <li><a href="#">Help <i class="pull-right fa fa-question-circle"></i></a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="text-right">Sign Out</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><i class="fa fa-envelope"></i><span class="badge">1</span></a>
            <ul class="dropdown-menu messages arrow">
                <li class="dd-header">
                    <span>You have 1 new message(s)</span>
                    <span><a href="#">Mark all Read</a></span>
                </li>
                <div class="scrollthis">
                    <li><a href="#" class="active">
                            <span class="time">6 mins</span>
                            <img src="assets/demo/avatar/doyle.png" alt="avatar" />
                            <div><span class="name">Alan Doyle</span><span class="msg">Please mail me the files by tonight.</span></div>
                        </a></li>
                    <li><a href="#">
                            <span class="time">12 mins</span>
                            <img src="assets/demo/avatar/paton.png" alt="avatar" />
                            <div><span class="name">Polly Paton</span><span class="msg">Uploaded all the files to server. Take a look.</span></div>
                        </a></li>
                    <li><a href="#">
                            <span class="time">9 hrs</span>
                            <img src="assets/demo/avatar/corbett.png" alt="avatar" />
                            <div><span class="name">Simon Corbett</span><span class="msg">I am signing off for today.</span></div>
                        </a></li>
                    <li><a href="#">
                            <span class="time">2 days</span>
                            <img src="assets/demo/avatar/tennant.png" alt="avatar" />
                            <div><span class="name">David Tennant</span><span class="msg">How are you doing?</span></div>
                        </a></li>
                    <li><a href="#">
                            <span class="time">6 mins</span>
                            <img src="assets/demo/avatar/doyle.png" alt="avatar" />
                            <div><span class="name">Alan Doyle</span><span class="msg">Please mail me the files by tonight.</span></div>
                        </a></li>
                    <li><a href="#">
                            <span class="time">12 mins</span>
                            <img src="assets/demo/avatar/paton.png" alt="avatar" />
                            <div><span class="name">Polly Paton</span><span class="msg">Uploaded all the files to server. Take a look.</span></div>
                        </a></li>
                </div>
                <li class="dd-footer"><a href="#">View All Messages</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="hasnotifications dropdown-toggle" data-toggle='dropdown'><i class="fa fa-bell"></i><span class="badge">3</span></a>
            <ul class="dropdown-menu notifications arrow">
                <li class="dd-header">
                    <span>You have 3 new notification(s)</span>
                    <span><a href="#">Mark all Seen</a></span>
                </li>
                <div class="scrollthis">
                    <li>
                        <a href="#" class="notification-user active">
                            <span class="time">4 mins</span>
                            <i class="fa fa-user"></i>
                            <span class="msg">New user Registered. </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="notification-danger active">
                            <span class="time">20 mins</span>
                            <i class="fa fa-bolt"></i>
                            <span class="msg">CPU at 92% on server#3! </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="notification-success active">
                            <span class="time">1 hr</span>
                            <i class="fa fa-check"></i>
                            <span class="msg">Server#1 is live. </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="notification-warning">
                            <span class="time">2 hrs</span>
                            <i class="fa fa-exclamation-triangle"></i>
                            <span class="msg">Database overloaded. </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="notification-order">
                            <span class="time">10 hrs</span>
                            <i class="fa fa-shopping-cart"></i>
                            <span class="msg">New order received. </span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="notification-failure">
                            <span class="time">12 hrs</span>
                            <i class="fa fa-times-circle"></i>
                            <span class="msg">Application error!</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="notification-fix">
                            <span class="time">12 hrs</span>
                            <i class="fa fa-wrench"></i>
                            <span class="msg">Installation Succeeded.</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="notification-success">
                            <span class="time">18 hrs</span>
                            <i class="fa fa-check"></i>
                            <span class="msg">Account Created. </span>
                        </a>
                    </li>
                </div>
                <li class="dd-footer"><a href="#">View All Notifications</a></li>
            </ul>
        </li>
        <li>
            <a href="#" id="headerbardropdown"><span><i class="fa fa-level-down"></i></span></a>
        </li>
        <li class="dropdown demodrop">
            <a href="#" class="dropdown-toggle tooltips" data-toggle="dropdown"><i class="fa fa-magic"></i></a>

            <ul class="dropdown-menu arrow dropdown-menu-form" id="demo-dropdown">
                <li>
                    <label for="demo-header-variations" class="control-label">Header Colors</label>
                    <ul class="list-inline demo-color-variation" id="demo-header-variations">
                        <li><a class="color-black" href="javascript:;"  data-headertheme="header-black.html"></a></li>
                        <li><a class="color-dark" href="javascript:;"  data-headertheme="default.html"></a></li>
                        <li><a class="color-red" href="javascript:;" data-headertheme="header-red.html"></a></li>
                        <li><a class="color-blue" href="javascript:;" data-headertheme="header-blue.html"></a></li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li>
                    <label for="demo-color-variations" class="control-label">Sidebar Colors</label>
                    <ul class="list-inline demo-color-variation" id="demo-color-variations">
                        <li><a class="color-lite" href="javascript:;"  data-theme="default.html"></a></li>
                        <li><a class="color-steel" href="javascript:;" data-theme="sidebar-steel.html"></a></li>
                        <li><a class="color-lavender" href="javascript:;" data-theme="sidebar-lavender.html"></a></li>
                        <li><a class="color-green" href="javascript:;" data-theme="sidebar-green.html"></a></li>
                    </ul>
                </li>
                <li class="divider"></li>
                <li>
                    <label for="fixedheader">Fixed Header</label>
                    <div id="fixedheader" style="margin-top:5px;"></div>
                </li>
            </ul>
        </li>
    </ul>
</header>

<div id="page-container">
    <!-- BEGIN SIDEBAR -->
    <nav id="page-leftbar" role="navigation">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="acc-menu" id="sidebar">
            <li id="search">
                <a href="javascript:;"><i class="fa fa-search opacity-control"></i></a>
                <form>
                    <input type="text" class="search-query" placeholder="Search...">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            </li>
            <li class="divider"></li>
            <li><a href="index.html"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
            <li><a href="javascript:;"><i class="fa fa-th"></i> <span>Layout Options</span> </a>
                <ul class="acc-menu">
                    <li><a href="layout-grid.html"><span>Grids</span></a></li>
                    <li><a href="layout-horizontal.html"><span>Horizontal Navigation</span></a></li>
                    <li><a href="layout-horizontal2.html"><span>Horizontal Navigation 2</span></a></li>
                    <li><a href="layout-fixed.html"><span>Fixed Boxed Layout</span></a></li>
                </ul>
            </li>
            <li><a href="javascript:;"><i class="fa fa-list-ol"></i> <span>UI Elements</span> <span class="badge badge-indigo">4</span></a>
                <ul class='acc-menu'>
                    <li><a href="ui-typography.html">Typography</a></li>
                    <li><a href="ui-buttons.html">Buttons</a></li>
                    <li><a href="tables-basic.html">Tables</a></li>
                    <li><a href="form-layout.html">Forms</a></li>
                    <li><a href="ui-panels.html">Panels</a></li>
                    <li><a href="ui-images.html">Images</a></li>
                </ul>
            </li>
            <li><a href="javascript:;"><i class="fa fa-tasks"></i> <span>UI Components</span> <span class="badge badge-info">12</span></a>
                <ul class="acc-menu">
                    <li><a href="ui-tiles.html">Tiles</a></li>
                    <li><a href="ui-modals.html">Modals &amp; Bootbox</a></li>
                    <li><a href="ui-progressbars.html">Progress Bars</a></li>
                    <li><a href="ui-paginations.html">Pagers &amp; Paginations</a></li>
                    <li><a href="ui-breadcrumbs.html">Breadcrumbs</a></li>
                    <li><a href="ui-labelsbadges.html">Labels &amp; Badges</a></li>
                    <li><a href="ui-alerts.html">Alerts &amp; Notificiations</a></li>
                    <li><a href="ui-sliders.html">Sliders &amp; Ranges</a></li>
                    <li><a href="ui-tabs.html">Tabs &amp; Accordions</a></li>
                    <li><a href="ui-carousel.html">Carousel</a></li>
                    <li><a href="ui-nestable.html">Nestable Lists</a></li>
                    <li><a href="ui-wells.html">Wells</a></li>
                    <li><a href="ui-tour.html">Tour</a></li>
                </ul>
            </li>
            <li><a href="javascript:;"><i class="fa fa-table"></i> <span>Advanced Tables</span></a>
                <ul class="acc-menu">
                    <li><a href="tables-data.html">Data Tables</a></li>
                    <li><a href="tables-responsive.html">Responsive Tables</a></li>
                    <li><a href="tables-editable.html">Editable Tables</a></li>
                </ul>
            </li>
            <li><a href="javascript:;"><i class="fa fa-pencil"></i> <span>Advanced Forms</span><span class="badge badge-primary">5</span></a>
                <ul class="acc-menu">
                    <li><a href="form-components.html">Components</a></li>
                    <li><a href="form-wizard.html">Wizards</a></li>
                    <li><a href="form-validation.html">Validation</a></li>
                    <li><a href="form-masks.html">Masks</a></li>
                    <li><a href="form-fileupload.html">Multiple File Uploads</a></li>
                    <li><a href="form-dropzone.html">Dropzone File Uploads</a></li>
                    <li><a href="form-ckeditor.html">WYSIWYG Editor</a></li>
                    <li><a href="form-xeditable.html">Inline Editor</a></li>
                    <li><a href="form-imagecrop.html">Image Cropping</a></li>
                </ul>
            </li>
            <li><a href="javascript:;"><i class="fa fa-map-marker"></i> <span>Maps</span></a>
                <ul class="acc-menu">
                    <li><a href="maps-google.html">Google Maps</a></li>
                    <li><a href="maps-vector.html">Vector Maps</a></li>
                </ul>
            </li>
            <li><a href="javascript:;"><i class="fa fa-bar-chart-o"></i> <span>Charts</span></a>
                <ul class="acc-menu">
                    <li><a href="charts-flot.html">Extensible</a></li>
                    <li><a href="charts-svg.html">Interactive</a></li>
                    <li><a href="charts-canvas.html">Lightweight</a></li>
                    <li><a href="charts-inline.html">Inline</a></li>
                </ul>
            </li>
            <li><a href="calendar.html"><i class="fa fa-calendar"></i> <span>Calendar</span></a></li>
            <li><a href="gallery.html"><i class="fa fa-camera"></i> <span> Gallery</span> </a></li>
            <li><a href="javascript:;"><i class="fa fa-flag"></i> <span>Icons</span> <span class="badge badge-orange">2</span></a>
                <ul class="acc-menu">
                    <li><a href="icons-fontawesome.html">Font Awesome</a></li>
                    <li><a href="icons-glyphicons.html">Glyphicons</a></li>
                </ul>
            </li>
            <li class="divider"></li>
            <li><a href="javascript:;"><i class="fa fa-briefcase"></i> <span>Extras</span> <span class="badge badge-danger">1</span></a>
                <ul class="acc-menu">
                    <li><a href="extras-timeline.html">Timeline</a></li>
                    <li><a href="extras-profile.html">Profile</a></li>
                    <li><a href="extras-inbox.html">Inbox</a></li>
                    <li><a href="extras-search.html">Search Page</a></li>
                    <li><a href="extras-chatroom.html">Chat Room</a></li>
                    <li><a href="extras-invoice.html">Invoice</a></li>
                    <li><a href="extras-registration.html">Registration</a></li>
                    <li><a href="extras-signupform.html">Sign Up</a></li>
                    <li><a href="extras-forgotpassword.html">Password Reset</a></li>
                    <li><a href="extras-login.html">Login 1</a></li>
                    <li><a href="extras-login2.html">Login 2</a></li>
                    <li><a href="extras-404.html">404 Page</a></li>
                    <li><a href="extras-500.html">500 Page</a></li>
                </ul>
            </li>
            <li><a href="javascript:;"><i class="fa fa-sitemap"></i> <span>Unlimited Level Menu</span></a>
                <ul class="acc-menu">
                    <li><a href="javascript:;">Menu Item 1</a></li>
                    <li><a href="javascript:;">Menu Item 2</a>
                        <ul class="acc-menu">
                            <li><a href="javascript:;">Menu Item 2.1</a></li>
                            <li><a href="javascript:;">Menu Item 2.2</a>
                                <ul class="acc-menu">
                                    <li><a href="javascript:;">Menu Item 2.2.1</a></li>
                                    <li><a href="javascript:;">Menu Item 2.2.2</a>
                                        <ul class="acc-menu">
                                            <li><a href="javascript:;">And deeper yet!</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
    </nav>

    <!-- BEGIN RIGHTBAR -->
    <div id="page-rightbar">

        <div id="chatarea">
            <div class="chatuser">
                <span class="pull-right">Jane Smith</span>
                <a id="hidechatbtn" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
            </div>
            <div class="chathistory">
                <div class="chatmsg">
                    <p>Hey! How's it going?</p>
                    <span class="timestamp">1:20:42 PM</span>
                </div>
                <div class="chatmsg sent">
                    <p>Not bad... i guess. What about you? Haven't gotten any updates from you in a long time.</p>
                    <span class="timestamp">1:20:46 PM</span>
                </div>
                <div class="chatmsg">
                    <p>Yeah! I've been a bit busy lately. I'll get back to you soon enough.</p>
                    <span class="timestamp">1:20:54 PM</span>
                </div>
                <div class="chatmsg sent">
                    <p>Alright, take care then.</p>
                    <span class="timestamp">1:21:01 PM</span>
                </div>
            </div>
            <div class="chatinput">
                <textarea name="" rows="2"></textarea>
            </div>
        </div>

        <div id="widgetarea">
            <div class="widget">
                <div class="widget-heading">
                    <a href="javascript:;" data-toggle="collapse" data-target="#accsummary"><h4>Account Summary</h4></a>
                </div>
                <div class="widget-body collapse in" id="accsummary">
                    <div class="widget-block" style="background: #7ccc2e; margin-top:10px;">
                        <div class="pull-left">
                            <small>Current Balance</small>
                            <h5>$71,182</h5>
                        </div>
                        <div class="pull-right"><div id="currentbalance"></div></div>
                    </div>
                    <div class="widget-block" style="background: #595f69;">
                        <div class="pull-left">
                            <small>Account Type</small>
                            <h5>Business Plan A</h5>
                        </div>
                        <div class="pull-right">
                            <small class="text-right">Monthly</small>
                            <h5>$19<small>.99</small></h5>
                        </div>
                    </div>
                    <span class="more"><a href="#">Upgrade Account</a></span>
                </div>
            </div>


            <div id="chatbar" class="widget">
                <div class="widget-heading">
                    <a href="javascript:;" data-toggle="collapse" data-target="#chatbody"><h4>Online Contacts <small>(5)</small></h4></a>
                </div>
                <div class="widget-body collapse in" id="chatbody">
                    <ul class="chat-users">
                        <li data-stats="online"><a href="javascript:;"><img src="assets/demo/avatar/potter.png" alt=""><span>Jeremy Potter</span></a></li>
                        <li data-stats="online"><a href="javascript:;"><img src="assets/demo/avatar/tennant.png" alt=""><span>David Tennant</span></a></li>
                        <li data-stats="online"><a href="javascript:;"><img src="assets/demo/avatar/johansson.png" alt=""><span>Anna Johansson</span></a></li>
                        <li data-stats="busy"><a href="javascript:;"><img src="assets/demo/avatar/jackson.png" alt=""><span>Eric Jackson</span></a></li>
                        <li data-stats="away"><a href="javascript:;"><img src="assets/demo/avatar/jobs.png" alt=""><span>Howard Jobs</span></a></li>
                        <!--li data-stats="offline"><a href="javascript:;"><img src="assets/demo/avatar/watson.png" alt=""><span>Annie Watson</span></a></li>
                        <li data-stats="offline"><a href="javascript:;"><img src="assets/demo/avatar/doyle.png" alt=""><span>Alan Doyle</span></a></li>
                        <li data-stats="offline"><a href="javascript:;"><img src="assets/demo/avatar/corbett.png" alt=""><span>Simon Corbett</span></a></li>
                        <li data-stats="offline"><a href="javascript:;"><img src="assets/demo/avatar/paton.png" alt=""><span>Polly Paton</span></a></li-->
                    </ul>
                    <span class="more"><a href="#">See all</a></span>
                </div>
            </div>

            <div class="widget">
                <div class="widget-heading">
                    <a href="javascript:;" data-toggle="collapse" data-target="#taskbody"><h4>Pending Tasks <small>(5)</small></h4></a>
                </div>
                <div class="widget-body collapse in" id="taskbody">
                    <div class="contextual-progress" style="margin-top:10px;">
                        <div class="clearfix">
                            <div class="progress-title">Backend Development</div>
                            <div class="progress-percentage"><span class="label label-info">Today</span> 25%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-info" style="width: 25%"></div>
                        </div>
                    </div>
                    <div class="contextual-progress">
                        <div class="clearfix">
                            <div class="progress-title">Bug Fix</div>
                            <div class="progress-percentage"><span class="label label-primary">Tomorrow</span> 17%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-primary" style="width: 17%"></div>
                        </div>
                    </div>
                    <div class="contextual-progress">
                        <div class="clearfix">
                            <div class="progress-title">Javascript Code</div>
                            <div class="progress-percentage">70%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" style="width: 70%"></div>
                        </div>
                    </div>
                    <div class="contextual-progress">
                        <div class="clearfix">
                            <div class="progress-title">Preparing Documentation</div>
                            <div class="progress-percentage">6%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-danger" style="width: 6%"></div>
                        </div>
                    </div>
                    <div class="contextual-progress">
                        <div class="clearfix">
                            <div class="progress-title">App Development</div>
                            <div class="progress-percentage">20%</div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-orange" style="width: 20%"></div>
                        </div>
                    </div>

                    <span class="more"><a href="ui-progressbars.html">View all Pending</a></span>
                </div>
            </div>



            <div class="widget">
                <div class="widget-heading">
                    <a href="javascript:;" data-toggle="collapse" data-target="#storagespace"><h4>Storage Space</h4></a>
                </div>
                <div class="widget-body collapse in" id="storagespace">
                    <div class="clearfix" style="margin-bottom: 5px;margin-top:10px;">
                        <div class="progress-title pull-left">1.31 GB of 1.50 GB used</div>
                        <div class="progress-percentage pull-right">87.3%</div>
                    </div>
                    <div class="progress">
                        <div class="progress-bar progress-bar-success" style="width: 50%"></div>
                        <div class="progress-bar progress-bar-warning" style="width: 25%"></div>
                        <div class="progress-bar progress-bar-danger" style="width: 12.3%"></div>
                    </div>
                </div>
            </div>

            <div class="widget">
                <div class="widget-heading">
                    <a href="javascript:;" data-toggle="collapse" data-target="#serverstatus"><h4>Server Status</h4></a>
                </div>
                <div class="widget-body collapse in" id="serverstatus">
                    <div class="clearfix" style="padding: 10px 24px;">
                        <div class="pull-left">
                            <div class="easypiechart" id="serverload" data-percent="67">
                                <span class="percent"></span>
                            </div>
                            <label for="serverload">Load</label>
                        </div>
                        <div class="pull-right">
                            <div class="easypiechart" id="ramusage" data-percent="20.6">
                                <span class="percent"></span>
                            </div>
                            <label for="ramusage">RAM: 422MB</label>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END RIGHTBAR -->
    <div id="page-content">
        <div id='wrap'>
            <div id="page-heading">
                <ol class="breadcrumb">
                    <li class='active'><a href="index-2.html">Dashboard</a></li>
                </ol>

                <h1>Dashboard</h1>
                <div class="options">
                    <div class="btn-toolbar">
                        <button class="btn btn-default" id="daterangepicker2">
                            <i class="fa fa-calendar-o"></i>
                            <span class="hidden-xs hidden-sm">October 2, 2015 - November 1, 2015</span> <b class="caret"></b>
                        </button>
                        <div class="btn-group hidden-xs">
                            <a href='#' class="btn btn-default dropdown-toggle" data-toggle='dropdown'><i class="fa fa-cloud-download"></i><span class="hidden-xs hidden-sm hidden-md"> Export as</span> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Text File (*.txt)</a></li>
                                <li><a href="#">Excel File (*.xlsx)</a></li>
                                <li><a href="#">PDF File (*.pdf)</a></li>
                            </ul>
                        </div>
                        <a href="#" class="btn btn-default hidden-xs"><i class="fa fa-cog"></i></a>
                    </div>
                </div>
            </div>


            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3 col-xs-12 col-sm-6">
                                <a class="info-tiles tiles-toyo" href="#">
                                    <div class="tiles-heading">Profit</div>
                                    <div class="tiles-body-alt">
                                        <!--i class="fa fa-bar-chart-o"></i-->
                                        <div class="text-center"><span class="text-top">$</span>854</div>
                                        <small>+8.7% from last period</small>
                                    </div>
                                    <div class="tiles-footer">more info</div>
                                </a>
                            </div>
                            <div class="col-md-3 col-xs-12 col-sm-6">
                                <a class="info-tiles tiles-success" href="#">
                                    <div class="tiles-heading">Revenue</div>
                                    <div class="tiles-body-alt">
                                        <!--i class="fa fa-money"></i-->
                                        <div class="text-center"><span class="text-top">$</span>22.7<span class="text-smallcaps">k</span></div>
                                        <small>-13.5% from last week</small>
                                    </div>
                                    <div class="tiles-footer">go to accounts</div>
                                </a>
                            </div>
                            <div class="col-md-3 col-xs-12 col-sm-6">
                                <a class="info-tiles tiles-orange" href="#">
                                    <div class="tiles-heading">Members</div>
                                    <div class="tiles-body-alt">
                                        <i class="fa fa-group"></i>
                                        <div class="text-center">109</div>
                                        <small>new users registered</small>
                                    </div>
                                    <div class="tiles-footer">manage members</div>
                                </a>
                            </div>
                            <div class="col-md-3 col-xs-12 col-sm-6">
                                <a class="info-tiles tiles-alizarin" href="#">
                                    <div class="tiles-heading">Orders</div>
                                    <div class="tiles-body-alt">
                                        <i class="fa fa-shopping-cart"></i>
                                        <div class="text-center">57</div>
                                        <small>new orders received</small>
                                    </div>
                                    <div class="tiles-footer">manage orders</div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 clearfix">
                                        <h4 class="pull-left" style="margin: 0 0 20px;">User Report <small>(weekly)</small></h4>
                                        <div class="btn-group pull-right">
                                            <a href="javascript:;" class="btn btn-default btn-sm active">this week</a>
                                            <a href="javascript:;" class="btn btn-default btn-sm ">previous week</a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="site-statistics" style="height:250px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-grape">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 clearfix">
                                        <h4 class="pull-left" style="margin: 0 0 20px;">Annual Sales <small>(by quarter)</small></h4>
                                        <div class="btn-group pull-right">
                                            <a href="javascript:;" class="btn btn-default btn-sm active">2012</a>
                                            <a href="javascript:;" class="btn btn-default btn-sm ">2011</a>
                                            <a href="javascript:;" class="btn btn-default btn-sm ">2010</a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="budget-variance" style="height:250px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 clearfix">
                                        <h4 class="pull-left" style="margin:0 0 10px">Site Reports <small>(overview)</small></h4>
                                        <div class="pull-right">
                                            <a href="javascript:;" class="btn btn-default-alt btn-sm"><i class="fa fa-refresh"></i></a>
                                            <a href="javascript:;" class="btn btn-default-alt btn-sm"><i class="fa fa-wrench"></i></a>
                                            <a href="javascript:;" class="btn btn-default-alt btn-sm"><i class="fa fa-cog"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-2">
                                        <div id="indexvisits" style="width: 90px; margin: 0 auto; padding: 10px 0 6px;"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                        <h3 style="text-align: center; margin: 0; color: #808080;">7,451</h3>
                                        <p style="text-align: center; margin: 0;">Visits</p>
                                        <hr class="hidden-md hidden-lg">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-2">
                                        <div id="indexpageviews" style="width: 90px; margin: 0 auto; padding: 10px 0 6px;"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                        <h3 style="text-align: center; margin: 0; color: #808080;">35,711</h3>
                                        <p style="text-align: center; margin: 0;">Page Views</p>
                                        <hr class="hidden-md hidden-lg">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-2">
                                        <div id="indexpagesvisit" style="width: 90px; margin: 0 auto; padding: 10px 0 6px;"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                        <h3 style="text-align: center; margin: 0; color: #808080;">6.92</h3>
                                        <p style="text-align: center; margin: 0;">Pages / Visit</p>
                                        <hr class="hidden-md hidden-lg">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-2">
                                        <div id="indexavgvisit" style="width: 90px; margin: 0 auto; padding: 10px 0 6px;"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                        <h3 style="text-align: center; margin: 0; color: #808080;">00:04:17</h3>
                                        <p style="text-align: center; margin: 0;">Average Visit Time</p>
                                        <hr class="hidden-md hidden-lg">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-2">
                                        <div id="indexnewvisits" style="width: 90px; margin: 0 auto; padding: 10px 0 6px;"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                        <h3 style="text-align: center; margin: 0; color: #808080;">71.27%</h3>
                                        <p style="text-align: center; margin: 0;">New Visits</p>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-2">
                                        <div id="indexbouncerate" style="width: 90px; margin: 0 auto; padding: 10px 0 6px;"><canvas width="90" height="45" style="display: inline-block; width: 90px; height: 45px; vertical-align: top;"></canvas></div>
                                        <h3 style="text-align: center; margin: 0; color: #808080;">31.08%</h3>
                                        <p style="text-align: center; margin: 0;">Bounce Rate</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-3 col-sm-6 col-lg-3">
                        <a class="info-tiles tiles-alizarin" href="#">
                            <div class="tiles-heading">
                                <div class="pull-left">Comments</div>
                                <div class="pull-right">+15.6%</div>
                            </div>
                            <div class="tiles-body">
                                <div class="pull-left"><i class="fa fa-comments-o"></i></div>
                                <div class="pull-right"><div id="indexinfocomments" style="margin-top: 10px; margin-bottom: -10px;"></div></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-md-3 col-sm-6 col-lg-3">
                        <a class="info-tiles tiles-orange" href="#">
                            <div class="tiles-heading">
                                <div class="pull-left">Likes</div>
                                <div class="pull-right">-5.5%</div>
                            </div>
                            <div class="tiles-body">
                                <div class="pull-left"><i class="fa fa-thumbs-o-up"></i></div>
                                <div class="pull-right"><div id="indexinfolikes" style="margin-top: 10px; margin-bottom: -10px;"></div></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-md-3 col-sm-6 col-lg-3">
                        <a class="info-tiles tiles-success" href="#">
                            <div class="tiles-heading">
                                <div class="pull-left">Bugs Fixed</div>
                                <div class="pull-right">+14.9%</div>
                            </div>
                            <div class="tiles-body">
                                <div class="pull-left"><i class="fa fa-check"></i></div>
                                <div class="pull-right">37</div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-md-3 col-sm-6 col-lg-3">
                        <a class="info-tiles tiles-toyo" href="#">
                            <div class="tiles-heading">
                                <div class="pull-left">Downloads</div>
                                <div class="pull-right">-9.8%</div>
                            </div>
                            <div class="tiles-body">
                                <div class="pull-left"><i class="fa fa-download"></i></div>
                                <div class="pull-right">3.67<span class="text-smallcaps">k</span></div>
                            </div>
                        </a>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-grape">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 clearfix">
                                        <h4 class="pull-left" style="margin:0 0 10px">Visitor Statistics <small>(overview)</small></h4>
                                        <div class="btn-group pull-right">
                                            <a href="javascript:;" id="updatePieCharts" class="btn btn-default-alt btn-sm">Refresh</a>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-4" style="padding-top:10px;padding-bottom:10px;">
                                        <div class="easypiechart" id="returningvisits" data-percent="65">
                                            <span class="percent"></span>
                                        </div>
                                        <label for="newvisits">Returning Visits</label>
                                        <hr class="hidden-md hidden-lg">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-4" style="padding-top:10px;padding-bottom:10px;">
                                    <span class="easypiechart" id="newvisitor" data-percent="81">
                                        <span class="percent"></span>
                                    </span>
                                        <label for="bouncerate">New Visitor</label>
                                        <hr class="hidden-md hidden-lg">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-4" style="padding-top:10px;padding-bottom:10px;">
                                    <span class="easypiechart" id="clickrate" data-percent="42">
                                        <span class="percent"></span>
                                    </span>
                                        <label for="clickrate">Click Rate</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-orange">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12 clearfix">
                                        <h4 class="pull-left" style="margin: 0 0 20px;">Server Load</h4>
                                        <div class="btn-group pull-right">
                                            <a href="javascript:;" class="btn btn-default btn-sm active">Server #1</a>
                                            <a href="javascript:;" class="btn btn-default btn-sm ">Server #2</a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="server-load" style="height:125px"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-indigo">
                            <div class="panel-heading">
                                <h4>User Accounts</h4>
                                <div class="options">
                                    <a href="javascript:;"><i class="fa fa-cog"></i></a>
                                    <a href="javascript:;"><i class="fa fa-wrench"></i></a>
                                    <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table" style="margin-bottom: 0px;">
                                        <thead>
                                        <tr>
                                            <th class="col-xs-1 col-sm-1"><input type="checkbox" id="select-all"></th>
                                            <th class="col-xs-9 col-sm-3">User ID</th>
                                            <th class="col-sm-6 hidden-xs">Email Address</th>
                                            <th class="col-xs-2 col-sm-2">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody class="selects">
                                        <tr>
                                            <td><input type="checkbox" class=""></td>
                                            <td>cranston</td>
                                            <td class="hidden-xs">cranstonb@gnail.com</td>
                                            <td><span class="label label-success">Approved</span></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class=""></td>
                                            <td>aaron</td>
                                            <td class="hidden-xs">ppaul@lime.com</td>
                                            <td><span class="label label-grape">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class=""></td>
                                            <td>norris</td>
                                            <td class="hidden-xs">j.norris@gnail.com</td>
                                            <td><span class="label label-warning">Suspended</span></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class=""></td>
                                            <td>gunner</td>
                                            <td class="hidden-xs">gunner@outluk.com</td>
                                            <td><span class="label label-danger">Blocked</span></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class=""></td>
                                            <td>mrford</td>
                                            <td class="hidden-xs">fordm@gnail.com</td>
                                            <td><span class="label label-grape">Pending</span></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" class=""></td>
                                            <td>stewrtt</td>
                                            <td class="hidden-xs">swttrs@outluk.com</td>
                                            <td><span class="label label-danger">Blocked</span></td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr class="active">
                                            <td colspan="4" class="text-left">
                                                <label for="action" style="margin-bottom:0">Action </label>
                                                <select name="action">
                                                    <option value="Edit">Edit</option>
                                                    <option value="Aprove">Aprove</option>
                                                    <option value="Move">Move</option>
                                                    <option value="Delete">Delete</option>
                                                </select>
                                            </td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-grape">
                            <div class="panel-heading">
                                <h4><i class="icon-highlight fa fa-check"></i> To-do List</h4>
                                <!-- <div class="options">
                                  <a href="javascript:;"><i class="fa fa-cog"></i></a>
                                  <a href="javascript:;"><i class="fa fa-wrench"></i></a>
                                  <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                                </div> -->
                            </div>
                            <div class="panel-body">
                                <ul class="panel-tasks">
                                    <li class="item-danger">
                                        <label>
                                            <i class="fa fa-ellipsis-v icon-dragtask"></i>
                                            <input type="checkbox">
                                            <span class="task-description">Write documentation for theme</span>
                                            <span class="label label-info">6 Days</span>
                                        </label>
                                        <div class="options todooptions">
                                            <div class="btn-group">
                                                <button class="btn btn-default btn-xs"><i class="fa fa-check"></i></button>
                                                <button class="btn btn-default btn-xs"><i class="fa fa-cog"></i></button>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="item-primary">
                                        <label>
                                            <i class="fa fa-ellipsis-v icon-dragtask"></i>
                                            <input type="checkbox">
                                            <span class="task-description">Compile code</span>
                                            <span class="label label-primary">3 Days</span>
                                        </label>
                                        <div class="options todooptions">
                                            <div class="btn-group">
                                                <button class="btn btn-default btn-xs"><i class="fa fa-check"></i></button>
                                                <button class="btn btn-default btn-xs"><i class="fa fa-cog"></i></button>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="item-info">
                                        <label>
                                            <i class="fa fa-ellipsis-v icon-dragtask"></i>
                                            <input type="checkbox">
                                            <span class="task-description">Upload files to server</span>
                                            <span class="label label-orange">Tomorrow</span>
                                        </label>
                                        <div class="options todooptions">
                                            <div class="btn-group">
                                                <button class="btn btn-default btn-xs"><i class="fa fa-check"></i></button>
                                                <button class="btn btn-default btn-xs"><i class="fa fa-cog"></i></button>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="item-success">
                                        <label>
                                            <i class="fa fa-ellipsis-v icon-dragtask"></i>
                                            <input type="checkbox">
                                            <span class="task-description">Call client</span>
                                            <span class="label label-danger">Today</span>
                                        </label>
                                        <div class="options todooptions">
                                            <div class="btn-group">
                                                <button class="btn btn-default btn-xs"><i class="fa fa-check"></i></button>
                                                <button class="btn btn-default btn-xs"><i class="fa fa-cog"></i></button>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <label>
                                            <i class="fa fa-ellipsis-v icon-dragtask"></i>
                                            <input type="checkbox">
                                            <span class="task-description">Buy some milk</span>
                                            <span class="label label-danger">Today</span>
                                        </label>
                                        <div class="options todooptions">
                                            <div class="btn-group">
                                                <button class="btn btn-default btn-xs"><i class="fa fa-check"></i></button>
                                                <button class="btn btn-default btn-xs"><i class="fa fa-cog"></i></button>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <label>
                                            <i class="fa fa-ellipsis-v icon-dragtask"></i>
                                            <input type="checkbox">
                                            <span class="task-description">Setup meeting with client</span>
                                            <span class="label label-sky">2 Weeks</span>
                                        </label>
                                        <div class="options todooptions">
                                            <div class="btn-group">
                                                <button class="btn btn-default btn-xs"><i class="fa fa-check"></i></button>
                                                <button class="btn btn-default btn-xs"><i class="fa fa-cog"></i></button>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <label>
                                            <i class="fa fa-ellipsis-v icon-dragtask"></i>
                                            <input type="checkbox">
                                            <span class="task-description">Pay office rent and bills</span>
                                            <span class="label label-sky">3 Weeks</span>
                                        </label>
                                        <div class="options todooptions">
                                            <div class="btn-group">
                                                <button class="btn btn-default btn-xs"><i class="fa fa-check"></i></button>
                                                <button class="btn btn-default btn-xs"><i class="fa fa-cog"></i></button>
                                            </div>
                                        </div>
                                    </li>

                                </ul>
                                <a href="#" class="btn btn-success btn-sm pull-left">Add Tasks</a>
                                <a href="#" class="btn btn-default-alt btn-sm pull-right">See All Tasks</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <h4><i class="icon-highlight fa fa-calendar"></i> Calendar</h4>
                                <div class="options">
                                    <a href="javascript:;"><i class="fa fa-cog"></i></a>
                                    <a href="javascript:;"><i class="fa fa-wrench"></i></a>
                                    <a href="javascript:;" class="panel-collapse"><i class="fa fa-chevron-down"></i></a>
                                </div>
                            </div>
                            <div class="panel-body" id="calendardemo">
                                <div id='calendar-drag'></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-midnightblue">
                            <div class="panel-heading">
                                <h4>
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#threads" data-toggle="tab"><i class="fa fa-list visible-xs icon-scale"></i><span class="hidden-xs">Threads</span></a></li>
                                        <li><a href="#comments" data-toggle="tab"><i class="fa fa-comments visible-xs icon-scale"></i><span class="hidden-xs">Comments</span></a></li>
                                        <li><a href="#users" data-toggle="tab"><i class="fa fa-group visible-xs icon-scale"></i><span class="hidden-xs">Users</span></a></li>
                                    </ul>
                                </h4>
                                <!-- <div class="options">
                                  <a href="javascript:;"><i class="fa fa-cog"></i></a>
                                  <a href="javascript:;"><i class="fa fa-wrench"></i></a>
                                </div> -->
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="threads">
                                        <ul class="panel-threads">
                                            <li>
                                                <img src="assets/demo/avatar/aniss.png" alt="Aniss">
                                                <div class="content">
                                                    <span class="time">20 mins</span>
                                                    <a href="#" class="title">Envato’s Most Wanted – $5,000 Reward for Music & Band Themes and Templates</a>
                                                    <span class="thread">asked by <a href="#">Jim Gordon</a> in <a href="#">Section #3</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/corbett.png" alt="Corbett">
                                                <div class="content">
                                                    <span class="time">2 hrs</span>
                                                    <a href="#" class="title">How to create a corporate wordpress theme?</a>
                                                    <span class="thread">asked by <a href="#">Simon Corbett</a> in <a href="#">Section #15</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/dangerfield.png" alt="Dangerfield">
                                                <div class="content">
                                                    <span class="time">4 hrs</span>
                                                    <a href="#" class="title">Which cart is growing in popularity - WOOCOMMERCE or OPENCART? And which one would you choose?</a>
                                                    <span class="thread">asked by <a href="#">Jeff Dangerfield</a> in <a href="#">Section #9</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/doyle.png" alt="Doyle">
                                                <div class="content">
                                                    <span class="time">13 hrs</span>
                                                    <a href="#" class="title">Pros and Cons of Using Grids in Responsive Web Design</a>
                                                    <span class="thread">asked by <a href="#">Alan Doyle</a> in <a href="#">Section #11</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/jackson.png" alt="Jackson">
                                                <div class="content">
                                                    <span class="time">19 hrs</span>
                                                    <a href="#" class="title">Best Web & Graphic Design Proposal Software</a>
                                                    <span class="thread">asked by <a href="#">Eric Jackson</a> in <a href="#">Section #18</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/aniss.png" alt="Aniss">
                                                <div class="content">
                                                    <span class="time">20 mins</span>
                                                    <a href="#" class="title">Envato’s Most Wanted – $5,000 Reward for Music & Band Themes and Templates</a>
                                                    <span class="thread">asked by <a href="#">Jim Gordon</a> in <a href="#">Section #3</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/corbett.png" alt="Corbett">
                                                <div class="content">
                                                    <span class="time">2 hrs</span>
                                                    <a href="#" class="title">How to create a corporate wordpress theme?</a>
                                                    <span class="thread">asked by <a href="#">Simon Corbett</a> in <a href="#">Section #15</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/dangerfield.png" alt="Dangerfield">
                                                <div class="content">
                                                    <span class="time">4 hrs</span>
                                                    <a href="#" class="title">Which cart is growing in popularity - WOOCOMMERCE or OPENCART? And which one would you choose?</a>
                                                    <span class="thread">asked by <a href="#">Jeff Dangerfield</a> in <a href="#">Section #9</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/doyle.png" alt="Doyle">
                                                <div class="content">
                                                    <span class="time">13 hrs</span>
                                                    <a href="#" class="title">Pros and Cons of Using Grids in Responsive Web Design</a>
                                                    <span class="thread">asked by <a href="#">Alan Doyle</a> in <a href="#">Section #11</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/jackson.png" alt="Jackson">
                                                <div class="content">
                                                    <span class="time">19 hrs</span>
                                                    <a href="#" class="title">Best Web & Graphic Design Proposal Software</a>
                                                    <span class="thread">asked by <a href="#">Eric Jackson</a> in <a href="#">Section #18</a></span>
                                                </div>
                                            </li>
                                        </ul>
                                        <a href="#" class="btn btn-default-alt btn-sm pull-right">Load More</a>
                                    </div>
                                    <div class="tab-pane" id="comments">
                                        <ul class="panel-comments">
                                            <li>
                                                <img src="assets/demo/avatar/aniss.png" alt="Aniss">
                                                <div class="content">
                                                    <span class="actions"><div class="options"><div class="btn-group"><button class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></button><button class="btn btn-default btn-xs"><i class="fa fa-times"></i></button></div></div></span>
                                                    <span class="commented"><a href="#">Jim Gordon</a> commented on <a href="#">Article #121</a></span>
                                                    Just wondering - can random users see our comments? If so, allow them to comment!
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/corbett.png" alt="Corbett">
                                                <div class="content">
                                                    <span class="actions"><div class="options"><div class="btn-group"><button class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></button><button class="btn btn-default btn-xs"><i class="fa fa-times"></i></button></div></div></span>
                                                    <span class="commented"><a href="#">Simon Corbett</a> commented on <a href="#">Article #55</a></span>
                                                    Not sure what changed but for the last few weeks a few of my regulars are having their comments held for moderation.
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/paton.png" alt="Corbett">
                                                <div class="content">
                                                    <span class="actions"><div class="options"><div class="btn-group"><button class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></button><button class="btn btn-default btn-xs"><i class="fa fa-times"></i></button></div></div></span>
                                                    <span class="commented"><a href="#">Polly Paton</a> commented on <a href="#">Article #12</a></span>
                                                    I’m sure there is a tool for that.
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/watson.png" alt="Watson">
                                                <div class="content">
                                                    <span class="actions"><div class="options"><div class="btn-group"><button class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></button><button class="btn btn-default btn-xs"><i class="fa fa-times"></i></button></div></div></span>
                                                    <span class="commented"><a href="#">Annie Watson</a> commented on <a href="#">Article #223</a></span>
                                                    We have enough problems with Spammers already without letting non members leave comments.
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/aniss.png" alt="Aniss">
                                                <div class="content">
                                                    <span class="actions"><div class="options"><div class="btn-group"><button class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></button><button class="btn btn-default btn-xs"><i class="fa fa-times"></i></button></div></div></span>
                                                    <span class="commented"><a href="#">Jim Gordon</a> commented on <a href="#">Article #121</a></span>
                                                    Just wondering - can random users see our comments? If so, allow them to comment!
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/corbett.png" alt="Corbett">
                                                <div class="content">
                                                    <span class="actions"><div class="options"><div class="btn-group"><button class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></button><button class="btn btn-default btn-xs"><i class="fa fa-times"></i></button></div></div></span>
                                                    <span class="commented"><a href="#">Simon Corbett</a> commented on <a href="#">Article #55</a></span>
                                                    Not sure what changed but for the last few weeks a few of my regulars are having their comments held for moderation.
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/paton.png" alt="Corbett">
                                                <div class="content">
                                                    <span class="actions"><div class="options"><div class="btn-group"><button class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></button><button class="btn btn-default btn-xs"><i class="fa fa-times"></i></button></div></div></span>
                                                    <span class="commented"><a href="#">Polly Paton</a> commented on <a href="#">Article #12</a></span>
                                                    I’m sure there is a tool for that.
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/watson.png" alt="Watson">
                                                <div class="content">
                                                    <span class="actions"><div class="options"><div class="btn-group"><button class="btn btn-default btn-xs"><i class="fa fa-pencil"></i></button><button class="btn btn-default btn-xs"><i class="fa fa-times"></i></button></div></div></span>
                                                    <span class="commented"><a href="#">Annie Watson</a> commented on <a href="#">Article #223</a></span>
                                                    We have enough problems with Spammers already without letting non members leave comments.
                                                </div>
                                            </li>
                                        </ul>
                                        <a href="#" class="btn btn-default-alt btn-sm pull-right">Load More</a>
                                    </div>
                                    <div class="tab-pane" id="users">
                                        <ul class="panel-users">
                                            <li>
                                                <img src="assets/demo/avatar/paton.png" alt="Paton">
                                                <div class="content">
                                                    <span class="time">11 mins</span>
                                                    <span class="desc"><a href="#">Polly Paton</a> followed <a href="#">John White</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/tennant.png" alt="Tennant">
                                                <div class="content">
                                                    <span class="time">48 mins</span>
                                                    <span class="desc"><a href="#">David Tennant</a> unfollowed <a href="#">Tony Doubleday</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/jobs.png" alt="Jobs">
                                                <div class="content">
                                                    <span class="time">5 hrs</span>
                                                    <span class="desc"><a href="#">Howard Jobs</a> commented on <a href="#">Selling PSD Template Rights!</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/dangerfield.png" alt="Dangerfield">
                                                <div class="content">
                                                    <span class="time">6 hrs</span>
                                                    <span class="desc"><a href="#">Jeff Dangerfield</a> posted on <a href="#">Please help with Theme Design</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/aniss.png" alt="Aniss">
                                                <div class="content">
                                                    <span class="time">22 hrs</span>
                                                    <span class="desc"><a href="#">Jim Gordon</a> followed <a href="#">Polly Paton</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/corbett.png" alt="Corbett">
                                                <div class="content">
                                                    <span class="time">3 days</span>
                                                    <span class="desc"><a href="#">Simon Corbett</a> followed <a href="#">Anna Johansson</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/paton.png" alt="Paton">
                                                <div class="content">
                                                    <span class="time">11 mins</span>
                                                    <span class="desc"><a href="#">Polly Paton</a> followed <a href="#">John White</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/tennant.png" alt="Tennant">
                                                <div class="content">
                                                    <span class="time">48 mins</span>
                                                    <span class="desc"><a href="#">David Tennant</a> unfollowed <a href="#">Tony Doubleday</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/jobs.png" alt="Jobs">
                                                <div class="content">
                                                    <span class="time">5 hrs</span>
                                                    <span class="desc"><a href="#">Howard Jobs</a> commented on <a href="#">Selling PSD Template Rights!</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/dangerfield.png" alt="Dangerfield">
                                                <div class="content">
                                                    <span class="time">6 hrs</span>
                                                    <span class="desc"><a href="#">Jeff Dangerfield</a> posted on <a href="#">Please help with Theme Design</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/aniss.png" alt="Aniss">
                                                <div class="content">
                                                    <span class="time">22 hrs</span>
                                                    <span class="desc"><a href="#">Jim Gordon</a> followed <a href="#">Polly Paton</a></span>
                                                </div>
                                            </li>
                                            <li>
                                                <img src="assets/demo/avatar/corbett.png" alt="Corbett">
                                                <div class="content">
                                                    <span class="time">3 days</span>
                                                    <span class="desc"><a href="#">Simon Corbett</a> followed <a href="#">Anna Johansson</a></span>
                                                </div>
                                            </li>
                                        </ul>
                                        <a href="#" class="btn btn-default-alt btn-sm pull-right">Load More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- container -->
        </div> <!--wrap -->
    </div> <!-- page-content -->

    <footer role="contentinfo">
        <div class="clearfix">
            <ul class="list-unstyled list-inline pull-left">
                <li>AVANT &copy; 2014</li>
            </ul>
            <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
        </div>
    </footer>

</div> <!-- page-container -->

@stop