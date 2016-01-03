$(document).on('click', '.pagination a', function(e) {
	event.preventDefault();
	var page = $(this).attr('href').split('page=')[1];// get page number by index 1
	getJob(page);
	$('html, body').animate({
        'scrollTop' : $(".container").position().top
    });
});

function getJob (page) {
	$.ajax({
		url: '/job/joblist?page='+page
	})
	.done(function(data) {
		$('#ajax_pagi').html(data);
		location.hash=page;
	});
	
}
