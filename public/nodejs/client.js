$(function(){
  $("#addClass").click(function () {
    $('#message_popup').addClass('popup-box-on');
  });

  $("#removeClass").click(function () {
    $('#message_popup').removeClass('popup-box-on');
  });
})
$('#sendMess').click(function(event){
  var msg=$("#messageInput").val();
  var avatar=$("#user_avatar").attr('src');
  var from_user=$("#message_popup").data('auth');
  var to_user=$("#message_popup").data('userpost');
  var token=$("input[name='_token']").val();
  $.ajax({
    url: '/message/new',
    type: 'POST',
    data: {
      message:msg,
      from_user:from_user,to_user:to_user,_token:token
    }
  })
  .success(function(data) {
   var actualContent=$("#messages").html();
   var cur_time=new Date().toTimeString().split(" ")[0];
   var newContent='<div class="direct-chat-info clearfix"><span class="direct-chat-name pull-left">'+from_user+'</span></div><img alt="message user image" src="'+avatar+'" class="direct-chat-img"><div class="direct-chat-text">'+msg+'</div><div class="direct-chat-info clearfix"><span class="direct-chat-timestamp pull-right">'+cur_time+'</span></div>';
   $("#messages").append(newContent);
 })
  .error(function() {
    alert("Có lỗi xảy ra");
  });
  
})




