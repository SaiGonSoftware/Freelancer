//save cv,get all the html elements using map function
$(function() {
    $("#savecv").click(function(event) {
        event.preventDefault();
        var name=$("#username").text();
        var job_name=$("#job_name").text();
        var phone=$("#phone").text();
        var email=$("#email").text();
        var address=$("#address").text();
        var token=$("input[name='_token']").val();
        /*var avatar=$('#image-upload').val();
        if (avatar.substring(3,11) == 'fakepath' )    { 
            avatar = avatar.substring(12); 
            alert(avatar);
        }*/
        var education = $('.education').map(function() {
            return $(this).html();
        }).get().join('\n');
        var experience = $('.experience').map(function() {
            return $(this).html();
        }).get().join('\n');
        var capabilities = $('.capabilities').map(function() {
            return $(this).html();
        }).get().join('\n');
        var interests = $('.interests').map(function() {
            return $(this).html();
        }).get().join('\n');
        var activities = $('.activities').map(function() {
            return $(this).html();
        }).get().join('\n');
        var skill = $('#skill').map(function() {
            return $(this).html();
        }).get().join('\n');
        $.ajax({
            url: '/cv/saveCV',
            type: 'POST',
            data: {
                name:name,
                job_name:job_name,
                capabilities:capabilities,
                phone:phone,
                email:email,
                address:address,
                experience:experience,
                education:education,
                interests:interests,
                activities:activities,
                skill:skill,
                _token : token  
            }
        })
        .success(function(response) {
            alert(response.mess);
            window.location.reload();
        })
        .error(function() {
            alert("Errors");
        });
    });
});

$(".rating").rating({
    starCaptions: {1: "Kém", 2: "Yếu", 3: "Trung Bình", 4: "Khá", 5: "Tốt"},
    starCaptionClasses: {1: "text-danger", 2: "text-warning", 3: "text-info", 4: "text-primary", 5: "text-success"}
});

