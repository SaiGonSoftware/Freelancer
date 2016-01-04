$(document).ready(function() {
	function randomNumber(min,max){
		return Math.floor(Math.random() * (max - min + 1) + min);
	}
	$("#captchaOperation").html([randomNumber(1,100), "+" , randomNumber(1,200), "="].join(" "));
	$('#login_form').formValidation({
		framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields:{
        	usernameLogin:{
        		row:'.col-xs-4',
        		validators: {
        			notEmpty: {
        				message:'Vui lòng nhập tên đăng nhập'
        			}
        		}
        	},
        	passwordLogin:{
        		row:'.col-xs-4',
        		validators:{
        			notEmpty:{
        				message:'Vui lòng nhập tên hiển thị'
        			}
        		}
        	}

        }
	});
});