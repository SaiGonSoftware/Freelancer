
$(function() {
    $("#savecv").click(function(event) {
        event.preventDefault();
        var name=$("#name").text();
        var job_name=$("#job_name").text();
        var capabilities=$("#capabilities").text();
        var phone=$("#phone").text();
        var email=$("#email").text();
        var address=$("#address").text();
        var skill=$("#skill").text();
        var token=$("input[name='_token']").val();
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
