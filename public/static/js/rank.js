$(function(){
	$('#pjax-container').delegate('.leftlist_link','click', function(){
		if ($(this).hasClass('selected')) return;
		var target = $(this);
		var rank = target.data('rank');
		var preSelected = $('.leftlist_link.selected');
		$.ajax({
			type: "GET",
			url: URL_DOMAIN + "ajax/rank",
			data: {rank: rank},
			success: function(res){
				// var status = {'preSel':preSelected.data('rank')};
				// history.pushState(status,'','?rank='+rank);
				preSelected.removeClass('selected');
				target.addClass('selected');
				$('.modmusic_tit').text(target.text());
				$('ul.rank_list').html(res);
			},
			error: function(){
				alert('连接服务器失败');
			}
		})
		// $.get("{:url('http://mymusic.com/ajax/rank')}", {rank:1}, function(res){
		// 	alert(res);
		// })
	});
	
	// window.onpopstate = function(){
	// 	var state = history.state;
	// 	if (state){
	// 		$('.leftlist_link.selected').removeClass('selected');
	// 		$('.leftlist_link[data-rank='+state.preSel+']').addClass('selected');
	// 	}
	// }
	// 
	// window.addEventListener('popstate', function(){
	// 	var state = history.state;
	// 	if (state){
	// 		$('.leftlist_link.selected').removeClass('selected');
	// 		$('.leftlist_link[data-rank='+state.preSel+']').addClass('selected');
	// 	}
	// }, true)
})