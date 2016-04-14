@extends('admin.layout')
@include('admin.menu')

@section('content')
<script>
    window.onload=function(){
      var pageHitChart=document.getElementById("pagehitChart").getContext("2d");
      $.ajax({
        url: '/admin/getPageHitData'
    })
      .success(function(data) {
        var data = {
          labels: data.keys,
          datasets: [
          {
            label: "Truy cập trong ngày",
            fillColor : "rgba(151,187,205,0.5)",
            strokeColor : "rgba(151,187,205,0.8)",
            highlightFill : "rgba(151,187,205,0.75)",
            highlightStroke : "rgba(151,187,205,1)",
            data: data.values
        }
        ]
    };
    window.myBar = new Chart(pageHitChart).Bar(data, {
      responsive : true
  });
})
      .fail(function() {
         alert("Có lỗi xảy ra vui lòng thử lại");
     });
      
  }
</script>
<div class="tab-content" >
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main" id="content_div">
        <div class="row">
            <ol class="breadcrumb">
                <li><span class="glyphicon glyphicon-home" aria-hidden="true"></span></li>
                <li class="active">Home</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Dashboard</h1>
            </div>
        </div><!--/.row-->

        <div class="row">
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-blue panel-widget ">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                            <span class="glyphicon glyphicon-user" aria-hidden="true" style="font-size: 45px"></span>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$totalUser}}</div>
                            <div class="text-muted">Thành Viên</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6 col-lg-3">
                <div class="panel panel-orange panel-widget">
                    <div class="row no-padding">
                        <div class="col-sm-3 col-lg-5 widget-left">
                         <span class="glyphicon glyphicon-briefcase" aria-hidden="true" style="font-size: 45px"></span>
                     </div>
                     <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large">{{$totalJob}}</div>
                        <div class="text-muted">Công Việc</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-3">
            <div class="panel panel-teal panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                     <span class="glyphicon glyphicon-usd" aria-hidden="true" style="font-size: 45px"></span>
                 </div>
                 <div class="col-sm-9 col-lg-7 widget-right">
                    <div class="large">{{$totalRecruitJob}}</div>
                    <div class="text-muted">CV Tuyển Dụng</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-3">
        <div class="panel panel-red panel-widget">
            <div class="row no-padding">
                <div class="col-sm-3 col-lg-5 widget-left">
                 <span class="glyphicon glyphicon-search" aria-hidden="true" style="font-size: 45px"></span>
             </div>
             <div class="col-sm-9 col-lg-7 widget-right">
                <div class="large">{{$totalVisted}}</div>
                <div class="text-muted">Truy Cập</div>
            </div>
        </div>
    </div>
</div>
</div><!--/.row-->
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">Thống Kê Truy Cập </div>
        <div class="panel-body">
            <div class="canvas-wrapper">
                <canvas class="main-chart" id="pagehitChart" height="354" width="1064" style="width: 1064px; height: 354px;"></canvas>
            </div>
        </div>
    </div>
</div>
</div>    <!--/.main-->
</div>
@stop