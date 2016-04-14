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


$(document).on("click", ".paging_user .pagination a", function (page) {
  event.preventDefault();
  var page = $(this).attr("href").split("page=")[1];
  $.ajax({
    url: '/admin/getUserAjax/' + '?page=' + page
  })
  .done(function (data) {
    $("#user_content_ajax").html(data);
  });
});

$(document).on("click", ".paging_job .pagination a", function (page) {
  event.preventDefault();
  var page = $(this).attr("href").split("page=")[1];
  $.ajax({
    url: '/admin/getPostAjax/' + '?page=' + page
  })
  .done(function (data) {
    $("#job_content_ajax").html(data);
  });
});

$(".btn-deactive").click(function(event) {
  var confirm_mess=confirm("Bạn có muốn deactive tài khoản này không");
  if (confirm_mess) {
    var id=$(this).data('id');
    $.ajax({
      url: '/admin/deactiveAccount',
      type: 'GET',
      data: {id: id},
    })
    .error(function(xhr, status, error) {
      alert(xhr.responseText);
    })
    .success(function(data) {
      alert(data.mess);
    });
    
  }
  
});
$(".btn-delete").click(function(event) {
  var confirm_mess=confirm("Bạn có muốn xóa bài viết này không");
  if (confirm_mess) {
    var id=$(this).data('id');
    $.ajax({
      url: '/admin/deleteJob',
      type: 'GET',
      data: {id: id},
    })
    .error(function(xhr, status, error) {
      alert(xhr.responseText);
    })
    .success(function(data) {
      alert(data.mess);
    });
    $(this).parent().parent().remove();
  }
  
});
