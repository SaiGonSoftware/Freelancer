$(document).ready(function() {
    $("#login_form").bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
       },
       fields: {
            usernameLogin:{
                message: 'The username is not valid',
                validators:{
                    notEmpty:{
                         message: 'Vui lòng nhập tên đăng nhập'
                    }
                }
            },
            passwordLogin:{
                message: 'The password is not valid',
                validators:{
                    notEmpty:{
                         message: 'Vui lòng nhập tên mật khẩu'
                    }
                }
            },
       }
    })
});