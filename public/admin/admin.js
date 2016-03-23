/**
 * Created by ngohungphuc on 3/14/2016.
 */
function redirect(url) {
    window.location = url;
}

function loader(status) {
    if (status == "on") {
        $("#loading").show();
    } else {
        $("#loading").hide();
    }
}

$("#loginAdmin").click(function () {
    var username = $("#username").val();
    var password = $("#password").val();
    var captcha = $("#captcha").val();
    var token = $("input[name='_token']").val();
    if (username == '') {
        alert("Vui lòng nhập đầy đủ thông tin");
        return false;
    }
    if (password == '') {
        alert("Vui lòng nhập đầy đủ thông tin");
        return false;
    }
    if (captcha == '') {
        alert("Vui lòng nhập đầy đủ thông tin");
        return false;
    }
    loader("on");
    $.ajax({
            url: '/admin/adminLogin',
            type: 'POST',
            data: {
                username: username,
                password: password,
                captcha: captcha,
                _token: token
            },
        })
        .error(function () {
            alert('Captcha vừa nhập không đúng');
            loader("off");
            window.location.reload();
        })
        .success(function (data) {
            loader("off");
            if (data == 'fail') {
                $("#status_message").text('Vui lòng kiểm tra lại username hoặc password');
                $("#status").show();
            } else {
                redirect('/admin/quan-ly');
            }
        });

});

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
