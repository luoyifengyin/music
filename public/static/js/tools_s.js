$(()=>{
	// $('#pjax-container').delegate(".search-form", "submit", function(ev){
	// 	ev.preventDefault();
	// 	var target = $(this);
	// 	var keyword = $(".search-input-bar").val();
	// 	$.ajax({
	// 		type: "GET",
	// 		url: "http://127.0.0.1/ajax/search",
	// 		data: {keyword: keyword},
	// 		success: function(res){
	// 			$('ul.search-list').html(res);
	// 		},
	// 		error: function(){
	// 			alert('连接服务器失败');
	// 		}
	// 	})
	// 	return false;
	// });
	
	$("#pjax-container").delegate("ul.search-list li.music-item", "mouseover", function(){
		$(this).find(".music_tools").css('display', 'block')
		$(this).find(".music-infor-album").css('visibility', 'hidden')
	})
	$("#pjax-container").delegate("ul.search-list li.music-item", "mouseout", function(){
		$(this).find(".music_tools").css('display', 'none')
		$(this).find(".music-infor-album").css('visibility', 'visible')
	})
})