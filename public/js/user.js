$("#register-name").keyup(function() {
    var username = $(this).val();
    $("#username_status").text("....");
    if (username  != ""){
    	$.post("/valid/client.php",{username:username},function(data){
			$("#username_status").text(data);
            if(data=="Tên đăng nhập đã được sử dụng"){
                $("#regis_btn").attr("disabled",true);
            }
            if(data=="Tên đăng nhập có thể sử dụng"){
                $("#regis_btn").attr("disabled",false);
            }
    	});
    }
});

$("#register-email").keyup(function() {
    var email = $(this).val();
    $("#email_status").text("....");
    if (email  != ""){
    	$.post("/valid/client.php",{email:email},function(data){
			$("#email_status").text(data);
            if(data=="Email đã được sử dụng"){
                $("#regis_btn").attr("disabled",true);
            }
            if(data=="Email có thể sử dụng"){
                $("#regis_btn").attr("disabled",false);
            }
    	});
    }
});

function loader(status){
    if(status=="on"){
        $("#login_form").css({
            opacity:0.2
        });
        $("#loading").show();
    }
    else{
        $("#login_form").css({
            opacity:1
        });
        $("#loading").hide();
    }
}

function redirect(url){
    window.location=url;
}

$('#login_btn').click(function() {
    var login_form=$("#login_form").serializeArray();
    var url=$("#login_form").attr('action');
    loader('on');
    $.post(url,login_form, function(data) {
        loader('off');
        if (data=='fail') {
            $("#message").text('Username hoặc password sai hoặc tài khoản chưa kích hoạt');
            $("#message").show();
        }
        else{
            $("#message").text('Đăng nhập thành công vui lòng đợi .....');
            $("#message").show();
            redirect('/trang-chu');
        }
    });
});

$("#regis_btn").click(function() {
    alert("Đăng ký thành công vui lòng kiểm tra email");
});
