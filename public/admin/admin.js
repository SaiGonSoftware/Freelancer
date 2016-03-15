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
            url: '/adminLogin',
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
                //$(".captcha-box").load();
                //window.location.reload();
            } else {
                $("#status_message").text('Đăng nhập thành công vui lòng đợi .....');
                $("#status").show();
                redirect('/admin/quan-ly');
            }
        });

});
