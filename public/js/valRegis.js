$(document).ready(function() {
    function randomNumber(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    }
    $('#captchaOperation').html([randomNumber(1, 100), '+', randomNumber(1, 200), '='].join(' '));
    $("#regis_form").bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
       },
       fields: {
            sernameRegis:{
                message: 'The username is not valid',
                validators:{
                    notEmpty:{
                         message: 'Vui lòng nhập tên đăng nhập'
                    },
                    regexp:{
                        regex: /^[a-zA-Z0-9_\.]+$/,
                        message: 'Tên đăng nhập chỉ bao gồm kí tự số và _'
                    }
                }
            },
            fullnameRegis:{
                message: 'The fullname is not valid',
                validators:{
                    notEmpty:{
                         message: 'Vui lòng nhập tên hiển thị'
                    }
                }
            },
            emailRegis:{
                message: 'The email is not valid',
                validators:{
                    notEmpty:{
                         message: 'Vui lòng nhập email'
                    },
                    emailAddress: {
                            message: 'Email không hợp lệ'
                    }
                }
            },
            passwordRegis:{
                message: 'The password is not valid',
                validators:{
                    notEmpty:{
                         message: 'Vui lòng nhập tên mật khẩu'
                    }
                }

            },
            rePassword:{
                message: 'The password is not valid',
                validators:{
                    notEmpty:{
                        message: 'Vui lòng nhập tên mật khẩu'
                    },
                    identical:{
                        field: 'passwordRegis',
                        message: 'Mật khẩu bạn nhập không trùng'
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
    })
   

});


