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
                            var items = $('#captchaOperation').html().split(' '), sum = parseInt(items[0]) + parseInt(items[2]);
                            return value == sum;
                        }
                    }
                }
            },
        }
    });
});