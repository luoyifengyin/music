// $(() => {
// 	$('#pjax-container').delegate('.my-comment form.navbar-form','submit', function(ev){
// 		alert('comment submit');
// 		ev.preventDefault();
// 		$.ajax({
// 			type: "POST",
// 			url: "http://mymusic.com/ajax/comment",
// 			data: {content: this.content.value, song_id: this.song_id.value},
// 			success: function(res){
// 				alert('comment ajax success')
// 				alert(res)
// 				$('.comment-content').html(res);
// 			},
// 			error: function(){
// 				alert('连接服务器失败');
// 			}
// 		})
// 	});
// })