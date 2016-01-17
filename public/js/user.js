$(document).ready(function() {
    $("#commentForm").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            allowance: {
                validators: {
                    notEmpty: {
                        message: "Vui lòng nhập kinh phí"
                    },
                    hex:{
                        message: "Kinh phí phải là số"
                    }
                }
            },
            completed_day: {
                validators: {
                    notEmpty: {
                        message: "Vui lòng nhập ngày hoàn thành"
                    },
                    hex :{
                        message: "Ngày hoàn thành phải là số"
                    }
                }
            },
            description: {
                validators: {
                    notEmpty: {
                        message: "Vui lòng nhập giới thiệu bản thân"
                    }
                }
            }
        }
    })
});

$(document).ready(function() {
    $("#btnInsertComment").click(function() {
        var user_id=document.getElementById("user_id").value;
        var introduce=$('textarea#introduce').val();
        var completed_day=document.getElementById("completed_day").value;
        var allowance=document.getElementById("allowance").value;
        var job_id=document.getElementById("job_id").value;
        $.ajax({
            url: '/comment/userReply',
            type: 'POST',
            data: {
                user_id: user_id,
                introduce: introduce,
                completed_day: completed_day,
                allowance: allowance,
                job_id: job_id
            },
        })
        .success(function(data) {
            alert("Thêm báo giá thành công");
        });
    });
});

$(document).ready(function() {
    $("#formPassword").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            password: {
                validators: {
                    notEmpty: {
                        message: "Vui lòng nhập mật khẩu"
                    }
                }
            },
            repassword: {
                validators: {
                    notEmpty: {
                        message: "Vui lòng nhập mật khẩu"
                    },
                    identical: {
                        field: "password",
                        message: "Mật khẩu bạn nhập không trùng"
                    }
                }
            }
        }
    })
});

$(document).ready(function() {
    $("#formAvatar").ajaxForm({
        beforeSend: function() {
            $(".progress").show();
        },
        uploadProgress: function(event, postion, total, percentComplete) {
            $(".progress-bar").width(percentComplete + "%");
            $(".sr-only").html(percentComplete + "%");
        },
        success: function() {
            $(".progress").hide();
            alert('Cập nhật ảnh đại diện thành công');
        }
    });
    $(".progress").hide();
});


$(document).on('ready', function() {
    $("#avatar").fileinput({
        browseClass: "btn btn-primary btn-block",
        showCaption: false,
        showRemove: false,
        showUpload: false,
        allowedFileExtensions: ["png", "jpg", "jpeg"],
        elErrorContainer: "#errorBlock"
    });
});

$("#register-name").keyup(function() {
    var username = $(this).val();
    $("#username_status").text("....");
    if (username != "") {
        $.post("/valid/client.php", {
            username: username
        }, function(data) {
            $("#username_status").text(data);
            if (data == "Tên đăng nhập đã được sử dụng") {
                $("#regis_btn").attr("disabled", true);
            }
            if (data == "Tên đăng nhập có thể sử dụng") {
                $("#regis_btn").attr("disabled", false);
            }
        });
    }
});

$("#register-email").keyup(function() {
    var email = $(this).val();
    $("#email_status").text("....");
    if (email != "") {
        $.post("/valid/client.php", {
            email: email
        }, function(data) {
            $("#email_status").text(data);
            if (data == "Email đã được sử dụng") {
                $("#regis_btn").attr("disabled", true);
            }
            if (data == "Email có thể sử dụng") {
                $("#regis_btn").attr("disabled", false);
            }
        });
    }
});

function loader(status) {
    if (status == "on") {
        $("#login_form").css({
            opacity: 0.2
        });
        $("#loading").show();
    } else {
        $("#login_form").css({
            opacity: 1
        });
        $("#loading").hide();
    }
}

function redirect(url) {
    window.location = url;
}
$('#login_btn').click(function() {
    var login_form = $("#login_form").serializeArray();
    var url = $("#login_form").attr('action');
    loader('on');
    $.post(url, login_form, function(data) {
        loader('off');
        if (data == 'fail') {
            $("#message").text('Username hoặc password sai hoặc tài khoản chưa kích hoạt');
            $("#message").show();
        } else {
            $("#message").text('Đăng nhập thành công vui lòng đợi .....');
            $("#message").show();
            redirect('/trang-chu');
        }
    });
});

$("#regis_btn").click(function() {
    alert("Đăng ký thành công vui lòng kiểm tra email");
});

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('/') + 1).split('/');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

$(document).on("click", ".details_pagi .pagination a", function(page) {
    event.preventDefault();
    var slug = getUrlVars()[3];
    var date_param = getUrlVars()[4];
    var date=date_param.split("-").reverse().join("-");
    var page = $(this).attr("href").split("page=")[1];
    $.ajax({
        url: '/comment/'+ slug +'/' +date + '?page='+page,
        data: {
            slug: slug,
            date: date
        },
    })
    .done(function(data) {
       $("#job_comment_post").html(data);
    });
    
});

function getJob(t) {
    $.ajax({
        url: "/job/joblist?page=" + t
    }).done(function(o) {
        $("#ajax_pagi").html(o), location.hash = t
    })
}

$(document).on("click", ".paging_job .pagination a", function(t) {
    event.preventDefault();
    var o = $(this).attr("href").split("page=")[1];
    getJob(o), $("html, body").animate({
        scrollTop: $(".container").position().top
    })
});

$(document).ready(function() {
    $("#login_form").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            usernameLogin: {
                message: "The username is not valid",
                validators: {
                    notEmpty: {
                        message: "Vui lòng nhập tên đăng nhập"
                    }
                }
            },
            passwordLogin: {
                message: "The password is not valid",
                validators: {
                    notEmpty: {
                        message: "Vui lòng nhập tên mật khẩu"
                    }
                }
            }
        }
    })
});

$(document).ready(function() {
    function randomNumber(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }
    $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));
    $("#register_form_popup").formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            usernameRegis: {
                validators: {
                    notEmpty: {
                        message: 'Vui lòng nhập tên đăng nhập'
                    },
                    stringLength: {
                        min: 5,
                        max: 30,
                        message: 'Tên đăng nhập phải từ 5 - 30 kí tự'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: 'Tên đăng nhập chỉ gồm chữ,số,dấu ., dấu _ '
                    }
                }
            },
            fullnameRegis: {
                validators: {
                    notEmpty: {
                        message: 'Vui lòng nhập tên hiển thị'
                    }
                }
            },
            emailRegis: {
                validators: {
                    notEmpty: {
                        message: 'Vui lòng nhập email'
                    },
                    emailAddress: {
                        message: "Email không hợp lệ"
                    }
                }
            },
            passwordRegis: {
                validators: {
                    notEmpty: {
                        message: 'Vui lòng nhập mật khẩu'
                    },
                    stringLength: {
                        min: 5,
                        max: 30,
                        message: 'Mật khẩu phải từ 5 - 30 kí tự'
                    },
                }
            },
            rePassword: {
                validators: {
                    notEmpty: {
                        message: 'Vui lòng nhập lại mật khẩu'
                    },
                    identical: {
                        field: "passwordRegis",
                        message: "Mật khẩu bạn nhập không trùng"
                    }
                }
            },
            captcha: {
                validators: {
                    callback: {
                        message: 'Kết quả sai',
                        callback: function(value, validator, $field) {
                            var items = $('#captchaOperation').html().split(' '),
                                sum = parseInt(items[0]) + parseInt(items[2]);
                            return value == sum;
                        }
                    }
                }
            },
        }
    });
});

$(document).ready(function() {
    $("#btnInsertComment").click(function() {
       alert('Thêm báo giá thành công')
    });
});