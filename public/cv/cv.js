//save cv,get all the html elements using map function
$(function () {
    $("#savecv").click(function (event) {
        event.preventDefault();
        var name = $("#username").text();
        var job_name = $("#job_name").text();
        var phone = $("#phone").text();
        var email = $("#email").text();
        var address = $("#address").text();
        var token = $("input[name='_token']").val();
        var avatar = document.getElementById("avatar").src;
        var education = $('.education').map(function () {
            return $(this).html();
        }).get().join('\n');
        var experience = $('.experience').map(function () {
            return $(this).html();
        }).get().join('\n');
        var capabilities = $('.capabilities').map(function () {
            return $(this).text();
        }).get().join('<br>');
        var interests = $('.interests').map(function () {
            return $(this).html();
        }).get().join('\n');
        var activities = $('.activities').map(function () {
            return $(this).html();
        }).get().join('\n');
        var skill = $('#skill').map(function () {
            return $(this).html();
        }).get().join('\n');
        var skill_name = $(".skill_name").map(function () {
            return $(this).html();
        }).get().join(',');
        $.ajax({
                url: '/cv/saveCV',
                type: 'POST',
                data: {
                    name: name,
                    job_name: job_name,
                    capabilities: capabilities,
                    phone: phone,
                    email: email,
                    address: address,
                    experience: experience,
                    education: education,
                    interests: interests,
                    activities: activities,
                    skill: skill,
                    _token: token,
                    avatar: avatar,
                    skill_name:skill_name
                }
            })
            .success(function (response) {
                alert(response.mess);
                window.location.reload();
            })
            .error(function () {
                alert("Errors");
            });
    });
});
//ratung star
$(".rating").rating({
    starCaptions: {1: "Kém", 2: "Yếu", 3: "Trung Bình", 4: "Khá", 5: "Tốt"},
    starCaptionClasses: {1: "text-danger", 2: "text-warning", 3: "text-info", 4: "text-primary", 5: "text-success"}
});
//crop image
$(function () {
    $('.image-editor').cropit({
        allowDragNDrop: true,
        exportZoom: 2,
        smallImage: "allow"
    });
});
//display image instant after user click update img
$('#uploadCVAvatar').click(function () {
    var imgSrc = $('.image-editor').cropit('export');
    $('#avatar').attr({src: imgSrc});
});
$('#btnAddExp').click(function () {
    $('.experience:first').clone().appendTo("#exContent");
});
$('#btnDelExp').click(function () {
    var ele_length = document.getElementsByClassName('experience').length;
    if (ele_length > 1) {
        $('.experience:last').remove();
    }
});
$('#btnAddEdu').click(function () {
    $('.education:first').clone().appendTo("#eduContent");
});
$('#btnDelEdu').click(function () {
    var ele_length = document.getElementsByClassName('education').length;
    if (ele_length > 1) {
        $('.education:last').remove();
    }

});
//clone the input rating, then wrap that the same as the original html, then call the .rating.
//article will wrap rating rating:first
$('#btnAddSkill').click(function () {
    var article = $('<article />', {class: "skill"}).append('-<span contenteditable class="skill_name">PHP</span>');
    $('.rating:first').clone().appendTo("#skill").wrap(article);
    $(".rating:last").rating({
        starCaptions: {1: "Kém", 2: "Yếu", 3: "Trung Bình", 4: "Khá", 5: "Tốt"},
        starCaptionClasses: {1: "text-danger", 2: "text-warning", 3: "text-info", 4: "text-primary", 5: "text-success"},
        size: 'xs'
    });
});
$('#btnDelSkill').click(function () {
    var ele_length = document.getElementsByClassName('skill').length;
    if (ele_length > 1) {
        $('.skill:last').remove();
    }

});
$('#btnAddInt').click(function () {
    $('.interests:first').clone().appendTo("#interContent");
});
$('#btnDelInt').click(function () {
    var ele_length = document.getElementsByClassName('interests').length;
    if (ele_length > 1) {
        $('.interests:last').remove();
    }

});
$('#btnAddAct').click(function () {
    $('.activities:first').clone().appendTo("#actiContent");
});
$('#btnDelAct').click(function () {
    var ele_length = document.getElementsByClassName('activities').length;
    if (ele_length > 1) {
        $('.activities:last').remove();
    }


});
/*$("#pdfDownload").click(function(event) {
 event.preventDefault();
 var url=$("#url").val();
 var token=$("input[name='_token']").val();
 alert(url);
 $.ajax({
 url: '/cv/download',
 type: 'POST',
 data:{
 url:url,
 _token:token
 }
 }).success(function(data){
 //alert(data);
 console.log(data);
 })
 .error(function() {
 alert("Có lỗi xảy ra vui lòng thử lại");
 });

 });*/

$("#updateCV").click(function (event) {
    event.preventDefault();
    var id = $("input[name='cv_id']").val();
    var name = $("#username").text();
    var job_name = $("#job_name").text();
    var phone = $("#phone").text();
    var email = $("#email").text();
    var address = $("#address").text();
    var token = $("input[name='_token']").val();
    var avatar = document.getElementById("avatar").src;
    var education = $('.education').map(function () {
        return $(this).html();
    }).get().join('\n');
    var experience = $('.experience').map(function () {
        return $(this).html();
    }).get().join('\n');
    var capabilities = $('.capabilities').map(function () {
        return $(this).html();
    }).get().join('<br>');
    var interests = $('.interests').map(function () {
        return $(this).text();
    }).get().join('\n');
    var activities = $('.activities').map(function () {
        return $(this).html();
    }).get().join('\n');
    var skill = $('#skill').map(function () {
        return $(this).html();
    }).get().join('\n');
    alert(capabilities);
    $.ajax({
            url: '/cv/update/' + id,
            type: 'POST',
            data: {
                name: name,
                job_name: job_name,
                capabilities: capabilities,
                phone: phone,
                email: email,
                address: address,
                experience: experience,
                education: education,
                interests: interests,
                activities: activities,
                skill: skill,
                _token: token,
                avatar: avatar,
                id: id
            }
        })
        .success(function (response) {
            alert(response.mess);
        })
        .error(function () {
            alert("Errors");
        });
});